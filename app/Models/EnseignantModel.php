<?php
namespace App\Models;
use CodeIgniter\Model;

class EnseignantModel extends Model {
    protected $table         = 'enseignants';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nom', 'prenom', 'email', 'specialite'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'nom'        => 'required|min_length[2]',
        'prenom'     => 'required|min_length[2]',
        'email'      => 'required|valid_email|is_unique[enseignants.email]',
        'specialite' => 'required',
    ];
}