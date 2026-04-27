<?php
namespace App\Controllers;

use App\Models\EmploiDuTempsModel;
use App\Models\FiliereModel;
use App\Models\CoursModel;
use App\Models\EnseignantModel;
use App\Models\SalleModel;
use App\Services\ConflitService;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller : EdtController
 * Module 3 - Construction de l'Emploi du Temps
 * Toutes les routes sont protégées par le filtre auth (défini dans Routes.php).
 */
class EdtController extends BaseController
{
    protected EmploiDuTempsModel $edtModel;
    protected FiliereModel       $filiereModel;
    protected CoursModel         $coursModel;
    protected EnseignantModel    $enseignantModel;
    protected SalleModel         $salleModel;
    protected ConflitService     $conflitService;

    public function __construct()
    {
        $this->edtModel        = new EmploiDuTempsModel();
        $this->filiereModel    = new FiliereModel();
        $this->coursModel      = new CoursModel();
        $this->enseignantModel = new EnseignantModel();
        $this->salleModel      = new SalleModel();
        $this->conflitService  = new ConflitService();
    }

    // ─── Helpers ─────────────────────────────────────────────────────────

    /** Calcule le lundi de la semaine en cours. */
    private function getLundiSemaine(?string $semaine = null): string
    {
        if ($semaine && preg_match('/^\d{4}-\d{2}-\d{2}$/', $semaine)) {
            // Ramène au lundi de cette semaine
            $ts = strtotime($semaine);
            $dow = (int)date('N', $ts);          // 1=Lundi … 7=Dimanche
            return date('Y-m-d', $ts - ($dow - 1) * 86400);
        }
        // Lundi de cette semaine par défaut
        $dow = (int)date('N');
        return date('Y-m-d', time() - ($dow - 1) * 86400);
    }

    /** Vérifie que l'utilisateur est admin (ou cd). */
    private function isAdmin(): bool
    {
        $role = session()->get('user_role');
        return in_array($role, ['admin', 'cd']);
    }

    // ─── CU-08 : Affichage de la grille EDT ──────────────────────────────

    /**
     * GET /edt
     * GET /edt/semaine/{date}
     */
    public function index(?string $semaine = null): string
    {
        $semaine    = $this->getLundiSemaine($semaine ?? $this->request->getGet('semaine'));
        $filiere_id = (int)($this->request->getGet('filiere_id') ?? 0);
        $salle_id   = (int)($this->request->getGet('salle_id')   ?? 0);

        $creneaux = $this->edtModel->getCreneauxSemaine(
            $semaine,
            $filiere_id ?: null,
            $salle_id   ?: null
        );

        // Organiser par [jour][heure_debut] pour la grille
        $grille = [];
        foreach ($creneaux as $c) {
            $hd = substr($c['heure_debut'], 0, 5);
            $grille[$c['jour']][$hd][] = $c;
        }

        return view('edt/index', [
            'semaine'          => $semaine,
            'semaine_prev'     => date('Y-m-d', strtotime($semaine . ' -7 days')),
            'semaine_next'     => date('Y-m-d', strtotime($semaine . ' +7 days')),
            'grille'           => $grille,
            'creneaux_horaires'=> EmploiDuTempsModel::$CRENEAUX,
            'jours'            => EmploiDuTempsModel::$JOURS,
            'filieres'         => $this->filiereModel->findAll(),
            'salles'           => $this->salleModel->findAll(),
            'filiere_id_actif' => $filiere_id,
            'salle_id_actif'   => $salle_id,
            'semaines_dispo'   => $this->edtModel->getSemainesDisponibles(),
            'isAdmin'          => $this->isAdmin(),
        ]);
    }

    // ─── CU-09 : Formulaire d'affectation ────────────────────────────────

    /** GET /edt/create */
    public function create(): string|ResponseInterface
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/edt')->with('error', 'Accès non autorisé.');
        }

        $semaine = $this->getLundiSemaine($this->request->getGet('semaine'));

        return view('edt/create', [
            'semaine'     => $semaine,
            'jours'       => EmploiDuTempsModel::$JOURS,
            'creneaux'    => EmploiDuTempsModel::$CRENEAUX,
            'filieres'    => $this->filiereModel->findAll(),
            'enseignants' => $this->enseignantModel->findAll(),
            'salles'      => $this->salleModel->findAll(),
            'cours'       => $this->coursModel->findAll(),
            'validation'  => \Config\Services::validation(),
        ]);
    }

    /** POST /edt/store */
    public function store()
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['error' => 'Non autorisé'])->setStatusCode(403);
        }

        $data = [
            'semaine'       => $this->request->getPost('semaine'),
            'filiere_id'    => (int)$this->request->getPost('filiere_id'),
            'cours_id'      => (int)$this->request->getPost('cours_id'),
            'enseignant_id' => (int)$this->request->getPost('enseignant_id'),
            'salle_id'      => (int)$this->request->getPost('salle_id'),
            'jour'          => $this->request->getPost('jour'),
            'heure_debut'   => $this->request->getPost('heure_debut'),
            'heure_fin'     => $this->request->getPost('heure_fin'),
            'created_by'    => session()->get('user_id'),
        ];

        // Validation CI4
        if (!$this->edtModel->validate($data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success'  => false,
                    'errors'   => $this->edtModel->errors(),
                    'conflits' => [],
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $this->edtModel->errors());
        }

        // Détection des conflits
        $conflits = $this->conflitService->detecterConflits($data);

        if (!empty($conflits)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success'  => false,
                    'conflits' => $conflits,
                    'errors'   => [],
                ]);
            }
            session()->setFlashdata('conflits', $conflits);
            return redirect()->back()->withInput();
        }

        // Insertion
        $this->edtModel->insert($data);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }

        session()->setFlashdata('success', 'Créneau ajouté avec succès.');
        return redirect()->to('/edt/semaine/' . $data['semaine']);
    }

    // ─── CU-11 : Modifier un créneau ─────────────────────────────────────

    /** GET /edt/edit/{id} */
    public function edit(int $id): string|ResponseInterface
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/edt')->with('error', 'Accès non autorisé.');
        }

        $creneau = $this->edtModel->getCreneauById($id);
        if (!$creneau) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Créneau #$id introuvable.");
        }

        return view('edt/edit', [
            'creneau'     => $creneau,
            'jours'       => EmploiDuTempsModel::$JOURS,
            'creneaux'    => EmploiDuTempsModel::$CRENEAUX,
            'filieres'    => $this->filiereModel->findAll(),
            'enseignants' => $this->enseignantModel->findAll(),
            'salles'      => $this->salleModel->findAll(),
            'cours'       => $this->coursModel->findAll(),
            'validation'  => \Config\Services::validation(),
        ]);
    }

    /** POST /edt/update/{id} */
    public function update(int $id)
    {
        if (!$this->isAdmin()) {
            return $this->response->setJSON(['error' => 'Non autorisé'])->setStatusCode(403);
        }

        $creneau = $this->edtModel->find($id);
        if (!$creneau) {
            return redirect()->to('/edt')->with('error', 'Créneau introuvable.');
        }

        $data = [
            'semaine'       => $this->request->getPost('semaine'),
            'filiere_id'    => (int)$this->request->getPost('filiere_id'),
            'cours_id'      => (int)$this->request->getPost('cours_id'),
            'enseignant_id' => (int)$this->request->getPost('enseignant_id'),
            'salle_id'      => (int)$this->request->getPost('salle_id'),
            'jour'          => $this->request->getPost('jour'),
            'heure_debut'   => $this->request->getPost('heure_debut'),
            'heure_fin'     => $this->request->getPost('heure_fin'),
        ];

        if (!$this->edtModel->validate($data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success'  => false,
                    'errors'   => $this->edtModel->errors(),
                    'conflits' => [],
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $this->edtModel->errors());
        }

        // Conflits (on exclut le créneau lui-même)
        $conflits = $this->conflitService->detecterConflits($data, $id);

        if (!empty($conflits)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success'  => false,
                    'conflits' => $conflits,
                    'errors'   => [],
                ]);
            }
            session()->setFlashdata('conflits', $conflits);
            return redirect()->back()->withInput();
        }

        $this->edtModel->update($id, $data);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }

        session()->setFlashdata('success', 'Créneau modifié avec succès.');
        return redirect()->to('/edt/semaine/' . $data['semaine']);
    }

    // ─── CU-11 : Supprimer un créneau ────────────────────────────────────

    /** GET /edt/delete/{id} */
    public function delete(int $id)
    {
        if (!$this->isAdmin()) {
            session()->setFlashdata('error', 'Accès non autorisé.');
            return redirect()->to('/edt');
        }

        $creneau = $this->edtModel->find($id);
        if (!$creneau) {
            session()->setFlashdata('error', 'Créneau introuvable.');
            return redirect()->to('/edt');
        }

        $semaine = $creneau['semaine'];
        $this->edtModel->delete($id);

        session()->setFlashdata('success', 'Créneau supprimé avec succès.');
        return redirect()->to('/edt/semaine/' . $semaine);
    }

    // ─── AJAX : vérification de conflits en temps réel ───────────────────

    /** POST /edt/check-conflicts */
    public function checkConflicts()
    {
        $data = [
            'semaine'       => $this->request->getPost('semaine'),
            'filiere_id'    => (int)$this->request->getPost('filiere_id'),
            'cours_id'      => (int)$this->request->getPost('cours_id') ?: 1,
            'enseignant_id' => (int)$this->request->getPost('enseignant_id'),
            'salle_id'      => (int)$this->request->getPost('salle_id'),
            'jour'          => $this->request->getPost('jour'),
            'heure_debut'   => $this->request->getPost('heure_debut'),
            'heure_fin'     => $this->request->getPost('heure_fin'),
        ];
        $excludeId = (int)$this->request->getPost('exclude_id') ?: null;

        $conflits = $this->conflitService->detecterConflits($data, $excludeId);

        return $this->response->setJSON([
            'conflits' => $conflits,
            'count'    => count($conflits),
        ]);
    }

    // ─── AJAX : cours filtrés par filière ────────────────────────────────

    /** GET /edt/cours-par-filiere/{filiere_id} */
    public function coursParFiliere(int $filiere_id)
    {
        $cours = $this->coursModel->where('filiere_id', $filiere_id)->findAll();
        return $this->response->setJSON($cours);
    }
}
