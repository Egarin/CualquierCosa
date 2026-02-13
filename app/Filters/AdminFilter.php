<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        if (!$session->get('usuario_id')) {
            return redirect()->to('login')->with('error', 'Debes iniciar sesión');
        }
        
        if ($session->get('rol') !== 'admin') {
            return redirect()->to('/')->with('error', 'No tienes permisos de administrador');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacer nada después
    }
}