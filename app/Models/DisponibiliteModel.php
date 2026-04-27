<?php
namespace App\Models;
use CodeIgniter\Model;

class DisponibiliteModel extends Model {
    protected $table         = 'disponibilites';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['enseignant_id', 'jour', 'heure_debut', 'heure_fin'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'enseignant_id' => 'required|integer',
        'jour'          => 'required',
        'heure_debut'   => 'required',
        'heure_fin'     => 'required',
    ];

    // Récupère toutes les dispos d'un enseignant avec son nom
    public function getDisposAvecEnseignant($enseignant_id) {
        return $this->select('disponibilites.*, enseignants.nom, enseignants.prenom')
                    ->join('enseignants', 'enseignants.id = disponibilites.enseignant_id')
                    ->where('enseignant_id', $enseignant_id)
                    ->findAll();
    }
}