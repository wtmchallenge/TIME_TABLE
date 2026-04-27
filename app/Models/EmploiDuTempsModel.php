<?php
namespace App\Models;
use CodeIgniter\Model;

/**
 * Model : EmploiDuTempsModel
 * Module 3 - Construction de l'Emploi du Temps
 */
class EmploiDuTempsModel extends Model
{
    protected $table         = 'emplois_du_temps';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'semaine', 'filiere_id', 'cours_id', 'enseignant_id',
        'salle_id', 'jour', 'heure_debut', 'heure_fin', 'created_by',
    ];

    protected $validationRules = [
        'semaine'       => 'required|valid_date[Y-m-d]',
        'filiere_id'    => 'required|is_natural_no_zero',
        'cours_id'      => 'required|is_natural_no_zero',
        'enseignant_id' => 'required|is_natural_no_zero',
        'salle_id'      => 'required|is_natural_no_zero',
        'jour'          => 'required|in_list[Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi]',
        'heure_debut'   => 'required',
        'heure_fin'     => 'required',
    ];

    protected $validationMessages = [
        'semaine'       => ['required' => 'La semaine est obligatoire.'],
        'filiere_id'    => ['required' => 'La filière est obligatoire.'],
        'cours_id'      => ['required' => 'Le cours est obligatoire.'],
        'enseignant_id' => ['required' => 'L\'enseignant est obligatoire.'],
        'salle_id'      => ['required' => 'La salle est obligatoire.'],
        'jour'          => ['required' => 'Le jour est obligatoire.'],
        'heure_debut'   => ['required' => 'L\'heure de début est obligatoire.'],
        'heure_fin'     => ['required' => 'L\'heure de fin est obligatoire.'],
    ];

    // ─── Créneaux officiels ENSPM ────────────────────────────────────────
    public static array $CRENEAUX = [
        '07:30' => '09:30',
        '09:30' => '11:30',
        '11:30' => '13:30',
        '14:00' => '16:00',
    ];

    // ─── Jours de la semaine ─────────────────────────────────────────────
    public static array $JOURS = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];

    /**
     * Retourne les créneaux d'une semaine, enrichis par JOINs.
     * @param string $semaine  Date du lundi (ex: 2026-04-27)
     * @param int|null $filiere_id  Filtre optionnel par filière
     * @param int|null $salle_id    Filtre optionnel par salle
     * @param int|null $enseignant_id Filtre optionnel par enseignant
     */
    public function getCreneauxSemaine(string $semaine, ?int $filiere_id = null, ?int $salle_id = null, ?int $enseignant_id = null): array
    {
        $builder = $this->db->table('emplois_du_temps edt')
            ->select('edt.*, 
                      c.intitule  AS cours_nom,  c.code AS cours_code,
                      e.nom       AS ens_nom,    e.prenom AS ens_prenom,
                      s.nom       AS salle_nom,
                      f.nom       AS filiere_nom')
            ->join('cours       c', 'c.id = edt.cours_id')
            ->join('enseignants e', 'e.id = edt.enseignant_id')
            ->join('salles      s', 's.id = edt.salle_id')
            ->join('filieres    f', 'f.id = edt.filiere_id')
            ->where('edt.semaine', $semaine);

        if ($filiere_id)    $builder->where('edt.filiere_id',    $filiere_id);
        if ($salle_id)      $builder->where('edt.salle_id',      $salle_id);
        if ($enseignant_id) $builder->where('edt.enseignant_id', $enseignant_id);

        $builder->orderBy('edt.jour')->orderBy('edt.heure_debut');
        return $builder->get()->getResultArray();
    }

    /**
     * Retourne un seul créneau enrichi (pour edit/show).
     */
    public function getCreneauById(int $id): ?array
    {
        $row = $this->db->table('emplois_du_temps edt')
            ->select('edt.*, 
                      c.intitule AS cours_nom, c.code AS cours_code,
                      e.nom      AS ens_nom,   e.prenom AS ens_prenom,
                      s.nom      AS salle_nom,
                      f.nom      AS filiere_nom')
            ->join('cours       c', 'c.id = edt.cours_id')
            ->join('enseignants e', 'e.id = edt.enseignant_id')
            ->join('salles      s', 's.id = edt.salle_id')
            ->join('filieres    f', 'f.id = edt.filiere_id')
            ->where('edt.id', $id)
            ->get()->getRowArray();
        return $row ?: null;
    }

    /**
     * Retourne les semaines déjà planifiées (pour le sélecteur).
     */
    public function getSemainesDisponibles(): array
    {
        return $this->db->table('emplois_du_temps')
            ->select('semaine')
            ->distinct()
            ->orderBy('semaine', 'ASC')
            ->get()->getResultArray();
    }
}
