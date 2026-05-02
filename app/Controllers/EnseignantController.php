<?php
namespace App\Controllers;
use App\Models\EnseignantModel;

class EnseignantController extends BaseController {

    public function index() {
        $model = new EnseignantModel();
        $data['enseignants'] = $model->findAll();
        return view('enseignants/index', $data);
    }

    public function create() {
        return view('enseignants/create');
    }

    public function store() {
        $model = new EnseignantModel();
        $data = [
            'nom'        => $this->request->getPost('nom'),
            'prenom'     => $this->request->getPost('prenom'),
            'email'      => $this->request->getPost('email'),
            'specialite' => $this->request->getPost('specialite'),
        ];
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        $model->insert($data);
        return redirect()->to('/enseignants')->with('success', 'Enseignant ajouté avec succès');
    }

    public function edit($id) {
        $model = new EnseignantModel();
        $data['enseignant'] = $model->find($id);
        if (!$data['enseignant']) {
            return redirect()->to('/enseignants')->with('error', 'Enseignant introuvable');
        }
        return view('enseignants/edit', $data);
    }

    public function update($id) {
        $model = new EnseignantModel();
        $data = [
            'nom'        => $this->request->getPost('nom'),
            'prenom'     => $this->request->getPost('prenom'),
            'email'      => $this->request->getPost('email'),
            'specialite' => $this->request->getPost('specialite'),
        ];
        // is_unique ignore l'enregistrement qu'on modifie
        $model->setValidationRule('email', "required|valid_email|is_unique[enseignants.email,id,{$id}]");
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        $model->update($id, $data);
        return redirect()->to('/enseignants')->with('success', 'Enseignant modifié avec succès');
    }

    public function delete($id) {
        $model = new EnseignantModel();
        $model->delete($id);
        return redirect()->to('/enseignants')->with('success', 'Enseignant supprimé');
    }
}