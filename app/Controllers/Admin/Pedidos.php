<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\HistorialPedidoModel;

class Pedidos extends BaseController
{
    protected $pedidoModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
    }

    public function index()
    {
        $estado = $this->request->getGet('estado');
        
        $data = [
            'titulo' => 'Gestión de Pedidos',
            'pedidos' => $this->pedidoModel->getPedidosConDetalle(null, $estado),
            'estado_actual' => $estado
        ];

        return view('admin/pedidos/index', $data);
    }

    public function ver($id)
    {
        $pedido = $this->pedidoModel->getPedidoCompleto($id);
        
        if (!$pedido) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'titulo' => 'Pedido #' . $pedido['codigo'],
            'pedido' => $pedido
        ];

        return view('admin/pedidos/ver', $data);
    }

    public function cambiarEstado()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $pedidoId = $this->request->getPost('pedido_id');
        $nuevoEstado = $this->request->getPost('estado');
        $nota = $this->request->getPost('nota');

        $pedido = $this->pedidoModel->find($pedidoId);
        if (!$pedido) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pedido no encontrado']);
        }

        $estadoAnterior = $pedido['estado'];
        
        // Actualizar estado
        $this->pedidoModel->update($pedidoId, ['estado' => $nuevoEstado]);
        
        // Registrar historial
        $historialModel = new HistorialPedidoModel();
        $historialModel->insert([
            'pedido_id' => $pedidoId,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $nuevoEstado,
            'nota' => $nota,
            'usuario_id' => session()->get('usuario_id')
        ]);

        return $this->response->setJSON(['success' => true]);
    }
}