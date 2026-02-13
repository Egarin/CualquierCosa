<?php

namespace App\Controllers\Tienda;

use App\Controllers\BaseController;
use App\Models\PedidoModel;

class Pedidos extends BaseController
{
    protected $pedidoModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
    }

    public function index()
    {
        $usuarioId = session()->get('usuario_id');
        
        $data = [
            'titulo' => 'Mis Pedidos',
            'pedidos' => $this->pedidoModel->getPedidosConDetalle($usuarioId)
        ];

        return view('tienda/pedidos/index', $data);
    }

    public function ver($codigo)
    {
        $usuarioId = session()->get('usuario_id');
        $pedido = $this->pedidoModel->where('codigo', $codigo)->first();
        
        if (!$pedido || $pedido['usuario_id'] != $usuarioId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'titulo' => 'Pedido #' . $codigo,
            'pedido' => $this->pedidoModel->getPedidoCompleto($pedido['id'])
        ];

        return view('tienda/pedidos/ver', $data);
    }
}