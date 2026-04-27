<?php
namespace App\Services;

use CodeIgniter\Database\BaseConnection;

/**
 * Service : ConflitService
 * Détecte automatiquement les conflits (CU-10) avant tout insert/update.
 *
 * Types de conflits :
 *   - salle      : même salle, même jour, même créneau horaire
 *   - enseignant : même enseignant, même jour, même créneau horaire
 *   - filiere    : même filière, même jour, même créneau horaire
 */
class ConflitService
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Détecte tous les conflits pour un créneau donné.
     *
     * @param array $data  Données du créneau :
     *                     [semaine, filiere_id, enseignant_id, salle_id,
     *                      jour, heure_debut, heure_fin]
     * @param int|null $excludeId  ID à exclure (pour les updates)
     * @return array  Tableau des conflits détectés (vide si aucun)
     */
    public function detecterConflits(array $data, ?int $excludeId = null): array
    {
        $conflits = [];

        $conflits = array_merge(
            $conflits,
            $this->conflitSalle($data, $excludeId),
            $this->conflitEnseignant($data, $excludeId),
            $this->conflitFiliere($data, $excludeId)
        );

        return $conflits;
    }

    // ─── Conflit salle ────────────────────────────────────────────────────
    private function conflitSalle(array $d, ?int $excludeId): array
    {
        $builder = $this->db->table('emplois_du_temps edt')
            ->select('edt.id, s.nom AS salle_nom, c.intitule AS cours_nom,
                      e.nom AS ens_nom, e.prenom AS ens_prenom,
                      edt.jour, edt.heure_debut, edt.heure_fin, edt.semaine')
            ->join('salles      s', 's.id = edt.salle_id')
            ->join('cours       c', 'c.id = edt.cours_id')
            ->join('enseignants e', 'e.id = edt.enseignant_id')
            ->where('edt.semaine',  $d['semaine'])
            ->where('edt.salle_id', $d['salle_id'])
            ->where('edt.jour',     $d['jour'])
            ->groupStart()
                ->where('edt.heure_debut <', $d['heure_fin'])
                ->where('edt.heure_fin >',   $d['heure_debut'])
            ->groupEnd();

        if ($excludeId) $builder->where('edt.id !=', $excludeId);

        $rows = $builder->get()->getResultArray();
        $conflits = [];
        foreach ($rows as $r) {
            $conflits[] = [
                'type'    => 'salle',
                'message' => sprintf(
                    'Conflit SALLE : « %s » est déjà occupée le %s de %s à %s par %s (%s %s).',
                    $r['salle_nom'], $r['jour'],
                    substr($r['heure_debut'], 0, 5), substr($r['heure_fin'], 0, 5),
                    $r['cours_nom'], $r['ens_prenom'], $r['ens_nom']
                ),
                'detail' => $r,
            ];
        }
        return $conflits;
    }

    // ─── Conflit enseignant ───────────────────────────────────────────────
    private function conflitEnseignant(array $d, ?int $excludeId): array
    {
        $builder = $this->db->table('emplois_du_temps edt')
            ->select('edt.id, e.nom AS ens_nom, e.prenom AS ens_prenom,
                      c.intitule AS cours_nom, s.nom AS salle_nom,
                      edt.jour, edt.heure_debut, edt.heure_fin')
            ->join('enseignants e', 'e.id = edt.enseignant_id')
            ->join('cours       c', 'c.id = edt.cours_id')
            ->join('salles      s', 's.id = edt.salle_id')
            ->where('edt.semaine',       $d['semaine'])
            ->where('edt.enseignant_id', $d['enseignant_id'])
            ->where('edt.jour',          $d['jour'])
            ->groupStart()
                ->where('edt.heure_debut <', $d['heure_fin'])
                ->where('edt.heure_fin >',   $d['heure_debut'])
            ->groupEnd();

        if ($excludeId) $builder->where('edt.id !=', $excludeId);

        $rows = $builder->get()->getResultArray();
        $conflits = [];
        foreach ($rows as $r) {
            $conflits[] = [
                'type'    => 'enseignant',
                'message' => sprintf(
                    'Conflit ENSEIGNANT : %s %s est déjà programmé(e) le %s de %s à %s en salle %s pour %s.',
                    $r['ens_prenom'], $r['ens_nom'], $r['jour'],
                    substr($r['heure_debut'], 0, 5), substr($r['heure_fin'], 0, 5),
                    $r['salle_nom'], $r['cours_nom']
                ),
                'detail' => $r,
            ];
        }
        return $conflits;
    }

    // ─── Conflit filière (groupe) ─────────────────────────────────────────
    private function conflitFiliere(array $d, ?int $excludeId): array
    {
        $builder = $this->db->table('emplois_du_temps edt')
            ->select('edt.id, f.nom AS filiere_nom, c.intitule AS cours_nom,
                      e.nom AS ens_nom, e.prenom AS ens_prenom, s.nom AS salle_nom,
                      edt.jour, edt.heure_debut, edt.heure_fin')
            ->join('filieres    f', 'f.id = edt.filiere_id')
            ->join('cours       c', 'c.id = edt.cours_id')
            ->join('enseignants e', 'e.id = edt.enseignant_id')
            ->join('salles      s', 's.id = edt.salle_id')
            ->where('edt.semaine',    $d['semaine'])
            ->where('edt.filiere_id', $d['filiere_id'])
            ->where('edt.jour',       $d['jour'])
            ->groupStart()
                ->where('edt.heure_debut <', $d['heure_fin'])
                ->where('edt.heure_fin >',   $d['heure_debut'])
            ->groupEnd();

        if ($excludeId) $builder->where('edt.id !=', $excludeId);

        $rows = $builder->get()->getResultArray();
        $conflits = [];
        foreach ($rows as $r) {
            $conflits[] = [
                'type'    => 'filiere',
                'message' => sprintf(
                    'Conflit FILIÈRE : la filière « %s » a déjà un cours le %s de %s à %s (%s — salle %s).',
                    $r['filiere_nom'], $r['jour'],
                    substr($r['heure_debut'], 0, 5), substr($r['heure_fin'], 0, 5),
                    $r['cours_nom'], $r['salle_nom']
                ),
                'detail' => $r,
            ];
        }
        return $conflits;
    }
}
