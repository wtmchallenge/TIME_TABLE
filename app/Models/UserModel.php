<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'actif',
        'reset_token',
        'reset_expires_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'nom'    => 'required|min_length[2]|max_length[100]',
        'prenom' => 'required|min_length[2]|max_length[100]',
        'email'  => 'required|valid_email|max_length[150]|is_unique[users.email,id,{id}]',
        'role'   => 'required|in_list[admin,cd,enseignant]',
    ];

    protected $validationMessages = [
        'nom'    => ['required' => 'Le nom est obligatoire.'],
        'prenom' => ['required' => 'Le prénom est obligatoire.'],
        'email'  => [
            'required'    => "L'email est obligatoire.",
            'valid_email' => "L'adresse email n'est pas valide.",
            'is_unique'   => 'Cet email est déjà utilisé.',
        ],
        'role'   => ['required' => 'Le rôle est obligatoire.'],
    ];

    protected $skipValidation = false;

    /**
     * Retrouve un utilisateur par son email.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)
                    ->where('actif', 1)
                    ->first();
    }

    public function setResetToken(string $email, string $token, string $expiresAt): bool
    {
        return (bool) $this->where('email', $email)
                            ->set(["reset_token" => $token, "reset_expires_at" => $expiresAt])
                            ->update();
    }

    public function findByResetToken(string $token): ?array
    {
        return $this->where('reset_token', $token)
                    ->where('reset_expires_at >=', date('Y-m-d H:i:s'))
                    ->first();
    }

    public function updatePasswordById(int $id, string $password): bool
    {
        return (bool) $this->update($id, [
            'password'          => $password,
            'reset_token'       => null,
            'reset_expires_at'  => null,
        ]);
    }

    public function clearResetToken(int $id): bool
    {
        return (bool) $this->update($id, [
            'reset_token'      => null,
            'reset_expires_at' => null,
        ]);
    }

    /**
     * Retourne le libellé du rôle en français.
     */
    public static function libelleRole(string $role): string
    {
        return match ($role) {
            'admin'      => 'Administrateur',
            'cd'         => 'Chef de Département',
            'enseignant' => 'Enseignant',
            default      => ucfirst($role),
        };
    }
}
