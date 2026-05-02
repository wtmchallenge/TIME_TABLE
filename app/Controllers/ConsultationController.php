<?php
namespace App\Controllers;

use App\Models\EmploiDuTempsModel;
use App\Models\FiliereModel;
use App\Models\EnseignantModel;
use App\Models\SalleModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class ConsultationController extends BaseController
{
    protected EmploiDuTempsModel $edtModel;
    protected FiliereModel       $filiereModel;
    protected EnseignantModel    $enseignantModel;
    protected SalleModel         $salleModel;

    public function __construct()
    {
        $this->edtModel        = new EmploiDuTempsModel();
        $this->filiereModel    = new FiliereModel();
        $this->enseignantModel = new EnseignantModel();
        $this->salleModel      = new SalleModel();
    }

    // ─── Helper : lundi de la semaine ────────────────────────────────────
    private function getLundiSemaine(?string $semaine = null): string
    {
        if ($semaine && preg_match('/^\d{4}-\d{2}-\d{2}$/', $semaine)) {
            $ts  = strtotime($semaine);
            $dow = (int)date('N', $ts);
            return date('Y-m-d', $ts - ($dow - 1) * 86400);
        }
        $dow = (int)date('N');
        return date('Y-m-d', time() - ($dow - 1) * 86400);
    }

    // ─── Helper : construire la grille [heure_debut][jour] ───────────────
    private function construireGrille(array $creneaux): array
    {
        $grille = [];
        foreach ($creneaux as $c) {
            $hd = substr($c['heure_debut'], 0, 5); // "07:30"
            $grille[$hd][$c['jour']] = $c;
        }
        return $grille;
    }

    // ─── PAGE PRINCIPALE : Filtrage EDT ──────────────────────────────────
    public function index()
    {
        $semaine       = $this->getLundiSemaine($this->request->getGet('semaine'));
        $filiere_id    = (int)($this->request->getGet('filiere_id')    ?? 0) ?: null;
        $enseignant_id = (int)($this->request->getGet('enseignant_id') ?? 0) ?: null;
        $salle_id      = (int)($this->request->getGet('salle_id')      ?? 0) ?: null;

        $creneaux = $this->edtModel->getCreneauxSemaine(
            $semaine,
            $filiere_id,
            $salle_id,
            $enseignant_id
        );

        return view('consultation/index', [
            'semaine'          => $semaine,
            'semaine_prev'     => date('Y-m-d', strtotime($semaine . ' -7 days')),
            'semaine_next'     => date('Y-m-d', strtotime($semaine . ' +7 days')),
            'grille'           => $this->construireGrille($creneaux),
            'jours'            => EmploiDuTempsModel::$JOURS,
            'creneaux_horaires'=> EmploiDuTempsModel::$CRENEAUX,
            'filieres'         => $this->filiereModel->findAll(),
            'enseignants'      => $this->enseignantModel->findAll(),
            'salles'           => $this->salleModel->findAll(),
            'semaines_dispo'   => $this->edtModel->getSemainesDisponibles(),
            'filiere_id'       => $filiere_id,
            'enseignant_id'    => $enseignant_id,
            'salle_id'         => $salle_id,
        ]);
    }

    // ─── EXPORT PDF FORMAT ENSPM ──────────────────────────────────────────
    public function exportPdf()
    {
        $semaine       = $this->getLundiSemaine($this->request->getGet('semaine'));
        $filiere_id    = (int)($this->request->getGet('filiere_id')    ?? 0) ?: null;
        $enseignant_id = (int)($this->request->getGet('enseignant_id') ?? 0) ?: null;
        $salle_id      = (int)($this->request->getGet('salle_id')      ?? 0) ?: null;

        $creneaux = $this->edtModel->getCreneauxSemaine(
            $semaine,
            $filiere_id,
            $salle_id,
            $enseignant_id
        );

        // Nom de la salle pour l'en-tête
        $salle_nom = 'Toutes salles';
        if ($salle_id) {
            $salle = $this->salleModel->find($salle_id);
            $salle_nom = $salle ? $salle['nom'] : 'Toutes salles';
        }

        // Période formatée : "27 au 02 Mai 2026"
        $lundi    = new \DateTime($semaine);
        $samedi   = (clone $lundi)->modify('+5 days');
        $periode  = $lundi->format('d') . ' au ' . $samedi->format('d ') . 
                    strftime('%B %Y', $samedi->getTimestamp());

        // Générer le HTML du PDF
        $html = view('consultation/pdf_template', [
            'grille'           => $this->construireGrille($creneaux),
            'jours'            => EmploiDuTempsModel::$JOURS,
            'creneaux_horaires'=> EmploiDuTempsModel::$CRENEAUX,
            'salle_nom'        => $salle_nom,
            'periode'          => $periode,
            'semaine'          => $semaine,
        ]);

        // DOMPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', false);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('EDT_ENSPM_' . $semaine . '.pdf', ['Attachment' => true]);
        exit;
    }
}