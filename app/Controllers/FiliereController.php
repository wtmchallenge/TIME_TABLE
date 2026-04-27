<?php
namespace App\Controllers;
use App\Models\FiliereModel;

class FiliereController extends BaseController {

    // LISTER toutes les filières
    public function index() {
        $model = new FiliereModel();
        $data['filieres'] = $model->findAll();
        return view('filieres/index', $data);
    }

    // AFFICHER le formulaire d'ajout
    public function create() {
        return view('filieres/create');
    }

    // ENREGISTRER une nouvelle filière
    public function store() {
        $model = new FiliereModel();

        $data = ['nom' => $this->request->getPost('nom')];

        // Validation
        if (!$model->validate($data)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $model->errors());
        }

        $model->insert($data);
        return redirect()->to('/filieres')
                         ->with('success', 'Filière ajoutée avec succès');
    }

    // AFFICHER le formulaire de modification
    public function edit($id) {
        $model = new FiliereModel();
        $data['filiere'] = $model->find($id);

        // Si la filière n'existe pas
        if (!$data['filiere']) {
            return redirect()->to('/filieres')
                             ->with('error', 'Filière introuvable');
        }

        return view('filieres/edit', $data);
    }

    // MODIFIER une filière
    public function update($id) {
        $model = new FiliereModel();

        $data = ['nom' => $this->request->getPost('nom')];

        if (!$model->validate($data)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $model->errors());
        }

        $model->update($id, $data);
        return redirect()->to('/filieres')
                         ->with('success', 'Filière modifiée avec succès');
    }

    // SUPPRIMER une filière
    public function delete($id) {
        $model = new FiliereModel();
        $model->delete($id);
        return redirect()->to('/filieres')
                         ->with('success', 'Filière supprimée');
    }
}