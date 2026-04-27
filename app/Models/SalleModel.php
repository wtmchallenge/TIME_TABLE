<?php
namespace App\Models;
use CodeIgniter\Model;

class SalleModel extends Model {
    protected $table         = 'salles';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nom', 'capacite'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'nom'      => 'required|is_unique[salles.nom]',
        'capacite' => 'required|integer|greater_than[0]',
    ];
}