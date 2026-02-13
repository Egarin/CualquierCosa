<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClienteModel;

class Clientes extends BaseController
{
    protected $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Gestión de Clientes',
            'clientes' => $this->clienteModel->getClientesConPedidos()
        ];

        return view('admin/clientes/index', $data);
    }

    public function ver($id)
    {
        $cliente = $this->clienteModel->getClienteConDirecciones($id);
        
        if (!$cliente) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'titulo' => 'Cliente: ' . $cliente['nombre'],
            'cliente' => $cliente
        ];

        return view('admin/clientes/ver', $data);
    }
}