<?php
namespace App\Models;
use CodeIgniter\Model;

class FiliereModel extends Model {
    protected $table         = 'filieres';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nom'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'nom' => 'required|min_length[2]|is_unique[filieres.nom]',
    ];
}