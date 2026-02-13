<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class Categorias extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        helper(['form']);
    }

    public function index()
    {
        $data = [
            'titulo' => 'Gestión de Categorías',
            'categorias' => $this->categoriaModel->getActivas()
        ];

        return view('admin/categorias/index', $data);
    }

    public function guardar()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|is_unique[categorias.nombre]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'icono' => $this->request->getPost('icono'),
            'color' => $this->request->getPost('color'),
            'orden' => $this->request->getPost('orden') ?: 0
        ];

        $this->categoriaModel->insert($data);

        return redirect()->to('admin/categorias')->with('success', 'Categoría creada exitosamente');
    }

    public function actualizar($id)
    {
        $rules = [
            'nombre' => "required|min_length[2]|is_unique[categorias.nombre,id,$id]"
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'icono' => $this->request->getPost('icono'),
            'color' => $this->request->getPost('color'),
            'orden' => $this->request->getPost('orden') ?: 0,
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        $this->categoriaModel->update($id, $data);

        return redirect()->to('admin/categorias')->with('success', 'Categoría actualizada');
    }

    public function eliminar($id)
    {
        $this->categoriaModel->delete($id);
        return redirect()->to('admin/categorias')->with('success', 'Categoría eliminada');
    }
}