<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ─────────────────────────────────────────────
    //  GET /login — Affiche le formulaire
    // ─────────────────────────────────────────────
    public function login(): string
    {
        // Déjà connecté ? On redirige directement
        if (session()->get('user_id')) {
            return redirect()->to($this->redirectByRole(session()->get('user_role')));
        }

        return view('auth/login');
    }

    // ─────────────────────────────────────────────
    //  POST /login — Traite la connexion
    // ─────────────────────────────────────────────
    public function doLogin()
    {
        // Validation CSRF + champs
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Recherche de l'utilisateur
        $user = $this->userModel->findByEmail($email);

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Email ou mot de passe incorrect.');
        }

        // Création de la session sécurisée
        session()->set([
            'user_id'     => $user['id'],
            'user_nom'    => $user['nom'],
            'user_prenom' => $user['prenom'],
            'user_email'  => $user['email'],
            'user_role'   => $user['role'],
            'user_name'   => $user['prenom'] . ' ' . $user['nom'],
            'logged_in'   => true,
        ]);

        session()->regenerate(true); // Régénère l'ID de session (sécurité)

        $redirect = $this->redirectByRole($user['role']);

        return redirect()->to($redirect)
                         ->with('success', 'Bienvenue, ' . $user['prenom'] . ' ' . $user['nom'] . ' !');
    }

    // ─────────────────────────────────────────────
    //  GET /logout — Déconnexion
    // ─────────────────────────────────────────────
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    // ─────────────────────────────────────────────
    //  Helper : redirection selon le rôle
    // ─────────────────────────────────────────────
    private function redirectByRole(string $role): string
    {
        return match ($role) {
            'admin', 'cd' => '/dashboard',
            'enseignant'  => '/mon-planning',
            default       => '/dashboard',
        };
    }
}
