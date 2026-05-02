<?php
namespace App\Controllers;
use App\Models\DisponibiliteModel;
use App\Models\EnseignantModel;

class DisponibiliteController extends BaseController {

    public function index() {
        $model = new DisponibiliteModel();
        $enseignantModel = new EnseignantModel();
        $data['disponibilites'] = $model
            ->select('disponibilites.*, enseignants.nom, enseignants.prenom')
            ->join('enseignants', 'enseignants.id = disponibilites.enseignant_id')
            ->orderBy('enseignants.nom', 'ASC')
            ->findAll();
        $data['enseignants'] = $enseignantModel->findAll();
        return view('disponibilites/index', $data);
    }

    public function create() {
        $enseignantModel  = new EnseignantModel();
        $data['enseignants'] = $enseignantModel->findAll();
        return view('disponibilites/create', $data);
    }

    public function store() {
        $model = new DisponibiliteModel();
        $data = [
            'enseignant_id' => $this->request->getPost('enseignant_id'),
            'jour'          => $this->request->getPost('jour'),
            'heure_debut'   => $this->request->getPost('heure_debut'),
            'heure_fin'     => $this->request->getPost('heure_fin'),
        ];
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        $model->insert($data);
        return redirect()->to('/disponibilites')->with('success', 'Disponibilité ajoutée');
    }

    public function edit($id) {
        $model           = new DisponibiliteModel();
        $enseignantModel = new EnseignantModel();
        $data['dispo']       = $model->find($id);
        $data['enseignants'] = $enseignantModel->findAll();
        if (!$data['dispo']) {
            return redirect()->to('/disponibilites')->with('error', 'Disponibilité introuvable');
        }
        return view('disponibilites/edit', $data);
    }

    public function update($id) {
        $model = new DisponibiliteModel();
        $data = [
            'enseignant_id' => $this->request->getPost('enseignant_id'),
            'jour'          => $this->request->getPost('jour'),
            'heure_debut'   => $this->request->getPost('heure_debut'),
            'heure_fin'     => $this->request->getPost('heure_fin'),
        ];
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        $model->update($id, $data);
        return redirect()->to('/disponibilites')->with('success', 'Disponibilité modifiée');
    }

    public function delete($id) {
        $model = new DisponibiliteModel();
        $model->delete($id);
        return redirect()->to('/disponibilites')->with('success', 'Disponibilité supprimée');
    }
}