<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\CarritoModel;

class Auth extends BaseController
{
    protected $usuarioModel;
    protected $carritoModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->carritoModel = new CarritoModel();
        helper(['form', 'url']);
    }

    public function login()
    {
        if (session()->get('usuario_id')) {
            return redirect()->to(session()->get('rol') === 'admin' ? 'admin/dashboard' : '/');
        }

        return view('auth/login');
    }

    public function doLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $this->usuarioModel->where('email', $email)->first();

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas');
        }

        if (!$usuario['activo']) {
            return redirect()->back()->with('error', 'Tu cuenta está desactivada');
        }

        // Crear sesión
        session()->set([
            'usuario_id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol']
        ]);

        // Migrar carrito de sesión a usuario
        $sessionId = session()->get('session_id');
        if ($sessionId) {
            $this->carritoModel->migrarASesionUsuario($sessionId, $usuario['id']);
        }

        return redirect()->to($usuario['rol'] === 'admin' ? 'admin/dashboard' : '/')
            ->with('success', '¡Bienvenido ' . $usuario['nombre'] . '!');
    }

    public function registro()
    {
        return view('auth/registro');
    }

    public function doRegistro()
    {
        $rules = [
            'nombre' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'telefono' => 'required|min_length[9]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
            'password' => $this->request->getPost('password'),
            'rol' => 'cliente'
        ];

        $this->usuarioModel->insert($data);

        return redirect()->to('login')->with('success', 'Registro exitoso. Inicia sesión para continuar.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Sesión cerrada correctamente');
    }
}
