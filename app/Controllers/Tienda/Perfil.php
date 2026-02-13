<?php

namespace App\Controllers\Tienda;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\DireccionModel;

class Perfil extends BaseController
{
    protected $usuarioModel;
    protected $direccionModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->direccionModel = new DireccionModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $usuarioId = (int) session()->get('usuario_id');
        $usuario = $this->usuarioModel->find($usuarioId);

        if (!$usuario) {
            return redirect()->to('login')->with('error', 'Sesión expirada');
        }

        $data = [
            'titulo' => 'Mi Perfil',
            'usuario' => $usuario,
            'direcciones' => $this->direccionModel->getDireccionesUsuario($usuarioId)
        ];

        return view('tienda/perfil/index', $data);
    }

    public function actualizar()
    {
        $usuarioId = (int) session()->get('usuario_id');

        $rules = [
            'nombre' => 'required|min_length[3]|max_length[50]',
            'email' => "required|valid_email|is_unique[usuarios.email,id,{$usuarioId}]",
            'telefono' => 'required|min_length[9]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono')
        ];

        if ($this->usuarioModel->update($usuarioId, $data)) {
            session()->set('nombre', $data['nombre']);
            return redirect()->to('perfil')->with('success', 'Datos actualizados correctamente');
        }

        return redirect()->back()->with('error', 'Error al actualizar datos');
    }

    public function cambiarPassword()
    {
        $usuarioId = (int) session()->get('usuario_id');
        $usuario = $this->usuarioModel->find($usuarioId);

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $currentPassword = $this->request->getPost('current_password');
        if (!password_verify($currentPassword, $usuario['password'])) {
            return redirect()->back()->with('error', 'La contraseña actual no es correcta');
        }

        $newPassword = $this->request->getPost('new_password');
        if ($this->usuarioModel->update($usuarioId, ['password' => $newPassword])) {
            return redirect()->to('perfil')->with('success', 'Contraseña actualizada correctamente');
        }

        return redirect()->back()->with('error', 'Error al actualizar contraseña');
    }
}
