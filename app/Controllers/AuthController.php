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
    //  GET /forgot-password — Formulaire de demande de réinitialisation
    // ─────────────────────────────────────────────
    public function forgotPassword(): string
    {
        return view('auth/forgot_password');
    }

    // ─────────────────────────────────────────────
    //  POST /forgot-password — Envoie le lien de réinitialisation
    // ─────────────────────────────────────────────
    public function sendResetLink()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $user  = $this->userModel->findByEmail($email);

        if ($user) {
            $token     = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + 3600);
            $this->userModel->setResetToken($email, $token, $expiresAt);

            $emailService = \Config\Services::email();
            $emailService->setFrom(config('Email')->fromEmail ?: 'no-reply@localhost', 'ENSPM Gestion EDT');
            $emailService->setTo($email);
            $emailService->setSubject('Réinitialisation de votre mot de passe');
            $emailService->setMessage(
                "Bonjour,\r\n\r\n" .
                "Pour réinitialiser votre mot de passe, cliquez sur le lien suivant : \r\n" .
                base_url("/password-reset/{$token}") . "\r\n\r\n" .
                "Ce lien est valide pendant 1 heure.\r\n\r\n" .
                "Si vous n'avez pas demandé cette réinitialisation, ignorez cet email."
            );
            $emailService->setMailType('text');
            $emailService->send();
        }

        return redirect()->to('/login')
                         ->with('success', 'Si cette adresse existe, un lien de réinitialisation a été envoyé.');
    }

    // ─────────────────────────────────────────────
    //  GET /password-reset/{token} — Formulaire de nouveau mot de passe
    // ─────────────────────────────────────────────
    public function resetPassword(string $token): string
    {
        $user = $this->userModel->findByResetToken($token);

        if (! $user) {
            return redirect()->to('/login')
                             ->with('error', 'Le lien de réinitialisation est invalide ou expiré.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    // ─────────────────────────────────────────────
    //  POST /password-reset — Enregistre le nouveau mot de passe
    // ─────────────────────────────────────────────
    public function doResetPassword()
    {
        $rules = [
            'token'            => 'required',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $token = $this->request->getPost('token');
        $user  = $this->userModel->findByResetToken($token);

        if (! $user) {
            return redirect()->to('/login')
                             ->with('error', 'Le lien de réinitialisation est invalide ou expiré.');
        }

        $this->userModel->updatePasswordById($user['id'], password_hash($this->request->getPost('password'), PASSWORD_DEFAULT));

        return redirect()->to('/login')
                         ->with('success', 'Votre mot de passe a bien été réinitialisé.');
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
