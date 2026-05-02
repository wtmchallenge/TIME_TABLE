<?php
namespace App\Models;
use CodeIgniter\Model;

class CoursModel extends Model {
    protected $table         = 'cours';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['intitule', 'filiere_id', 'volume_horaire'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'intitule'       => 'required',
        'filiere_id'     => 'required|integer',
        'volume_horaire' => 'required|integer|greater_than[0]',
    ];

    // Méthode spéciale : récupère les cours avec le nom de leur filière
    public function getCoursAvecFiliere() {
        return $this->select('cours.*, filieres.nom as filiere_nom')
                    ->join('filieres', 'filieres.id = cours.filiere_id')
                    ->findAll();
    }
}