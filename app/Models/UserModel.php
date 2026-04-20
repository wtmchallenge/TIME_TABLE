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
