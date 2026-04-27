<?php
namespace App\Controllers;
use App\Models\CoursModel;
use App\Models\FiliereModel;

class CoursController extends BaseController {

    public function index() {
        $model = new CoursModel();
        // On utilise la méthode spéciale du model qui joint la table filieres
        $data['cours'] = $model->getCoursAvecFiliere();
        return view('cours/index', $data);
    }

    public function create() {
        $filiereModel = new FiliereModel();
        // On passe les filières à la view pour remplir le <select>
        $data['filieres'] = $filiereModel->findAll();
        return view('cours/create', $data);
    }

    public function store() {
        $model = new CoursModel();
        $data = [
            'intitule'       => $this->request->getPost('intitule'),
            'filiere_id'     => $this->request->getPost('filiere_id'),
            'volume_horaire' => $this->request->getPost('volume_horaire'),
        ];
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        $model->insert($data);
        return redirect()->to('/cours')->with('success', 'Cours ajouté avec succès');
    }

    public function edit($id) {
        $model        = new CoursModel();
        $filiereModel = new FiliereModel();
        $data['cours']    = $model->find($id);
        $data['filieres'] = $filiereModel->findAll();
        if (!$data['cours']) {
            return redirect()->to('/cours')->with('error', 'Cours introuvable');
        }
        return view('cours/edit', $data);
    }

    public function update($id) {
        $model = new CoursModel();
        $data = [
            'intitule'       => $this->request->getPost('intitule'),
            'filiere_id'     => $this->request->getPost('filiere_id'),
            'volume_horaire' => $this->request->getPost('volume_horaire'),
        ];
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        $model->update($id, $data);
        return redirect()->to('/cours')->with('success', 'Cours modifié avec succès');
    }

    public function delete($id) {
        $model = new CoursModel();
        $model->delete($id);
        return redirect()->to('/cours')->with('success', 'Cours supprimé');
    }
}