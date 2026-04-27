<?php
namespace App\Controllers;
use App\Models\SalleModel;

class SalleController extends BaseController {

    public function index() {
        $model = new SalleModel();
        $data['salles'] = $model->orderBy('nom', 'ASC')->findAll();
        return view('salles/index', $data);
    }

    public function create() {
        return view('salles/create');
    }

    public function store() {
        $model = new SalleModel();
        $data = [
            'nom'      => $this->request->getPost('nom'),
            'capacite' => $this->request->getPost('capacite'),
        ];
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        $model->insert($data);
        return redirect()->to('/salles')->with('success', 'Salle ajoutée avec succès');
    }

    public function edit($id) {
        $model = new SalleModel();
        $data['salle'] = $model->find($id);
        if (!$data['salle']) {
            return redirect()->to('/salles')->with('error', 'Salle introuvable');
        }
        return view('salles/edit', $data);
    }

    public function update($id) {
        $model = new SalleModel();
        $data = [
            'nom'      => $this->request->getPost('nom'),
            'capacite' => $this->request->getPost('capacite'),
        ];
        $model->setValidationRule('nom', "required|is_unique[salles.nom,id,{$id}]");
        if (!$model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        $model->update($id, $data);
        return redirect()->to('/salles')->with('success', 'Salle modifiée avec succès');
    }

    public function delete($id) {
        $model = new SalleModel();
        $model->delete($id);
        return redirect()->to('/salles')->with('success', 'Salle supprimée');
    }
}