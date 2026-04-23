<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // $arguments contient les rôles autorisés, ex: ['admin', 'cd']
        if (empty($arguments)) {
            return;
        }

        $userRole = session()->get('user_role');

        if (! $userRole || ! in_array($userRole, $arguments)) {
            return redirect()->to('/dashboard')
                             ->with('error', "Accès refusé. Vous n'avez pas les droits nécessaires.");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Rien à faire après
    }
}
