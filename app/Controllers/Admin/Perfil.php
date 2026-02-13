<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Perfil extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $userId = session()->get('usuario_id');
        $usuario = $this->usuarioModel->find($userId);

        if (!$usuario) {
            return redirect()->to('admin/dashboard')->with('error', 'Usuario no encontrado.');
        }

        $data = [
            'titulo' => 'Mi Perfil',
            'usuario' => $usuario
        ];

        return view('admin/perfil/index', $data);
    }

    public function actualizar()
    {
        $userId = session()->get('usuario_id');
        $usuario = $this->usuarioModel->find($userId);

        if (!$usuario) {
            return redirect()->to('admin/dashboard')->with('error', 'Usuario no encontrado.');
        }

        $rules = [
            'nombre' => 'required|min_length(3)|max_length(50)',
            'email'  => "required|valid_email|is_unique[usuarios.email,id,{$userId}]"
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length(6)';
            $rules['confirm_password'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email'  => $this->request->getPost('email'),
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->usuarioModel->update($userId, $data);

        // Actualizar sesión si cambió el nombre
        session()->set('nombre', $data['nombre']);

        return redirect()->to('admin/perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
