<?php

namespace App\Controllers\Tienda;

use App\Controllers\BaseController;
use App\Models\CarritoModel;
use App\Models\ProductoModel;

class Carrito extends BaseController
{
    protected $carritoModel;
    protected $productoModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->productoModel = new ProductoModel();
        helper(['form']);
    }

    public function index()
    {
        $usuarioId = session()->get('usuario_id');
        $sessionId = session()->get('session_id') ?? session_id();

        if (!session()->get('session_id')) {
            session()->set('session_id', $sessionId);
        }

        $data = [
            'titulo' => 'Mi Carrito',
            'items' => $this->carritoModel->getCarrito($usuarioId, $sessionId),
            'total' => $this->carritoModel->calcularTotal($usuarioId, $sessionId)
        ];

        return view('tienda/carrito/index', $data);
    }

    public function agregar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $productoId = $this->request->getPost('producto_id');
        $cantidad = (int)$this->request->getPost('cantidad') ?: 1;

        // Verificar stock
        if (!$this->productoModel->verificarStock($productoId, $cantidad)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Stock insuficiente',
                'csrf_name' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        $usuarioId = session()->get('usuario_id');
        $sessionId = session()->get('session_id') ?? session_id();

        $data = [
            'usuario_id' => $usuarioId,
            'session_id' => $usuarioId ? null : $sessionId,
            'producto_id' => $productoId,
            'cantidad' => $cantidad
        ];

        if ($this->carritoModel->agregarItem($data)) {
            $contador = $this->carritoModel->contarItems($usuarioId, $sessionId);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'contador' => $contador,
                'csrf_name' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error al agregar producto',
            'csrf_name' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function actualizar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $itemId = $this->request->getPost('item_id');
        $cantidad = (int)$this->request->getPost('cantidad');

        if ($cantidad < 1) {
            return $this->eliminar();
        }

        $item = $this->carritoModel->find($itemId);
        if (!$item) {
            return $this->response->setJSON(['success' => false]);
        }

        // Verificar stock
        if (!$this->productoModel->verificarStock($item['producto_id'], $cantidad)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Stock insuficiente',
                'csrf_name' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        $this->carritoModel->update($itemId, ['cantidad' => $cantidad]);

        $usuarioId = session()->get('usuario_id');
        $sessionId = session()->get('session_id');

        return $this->response->setJSON([
            'success' => true,
            'total' => $this->carritoModel->calcularTotal($usuarioId, $sessionId),
            'csrf_name' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function eliminar()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $itemId = $this->request->getPost('item_id');

        if ($this->carritoModel->delete($itemId)) {
            $usuarioId = session()->get('usuario_id');
            $sessionId = session()->get('session_id');

            return $this->response->setJSON([
                'success' => true,
                'total' => $this->carritoModel->calcularTotal($usuarioId, $sessionId),
                'csrf_name' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'csrf_name' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function contador()
    {
        $usuarioId = session()->get('usuario_id');
        $sessionId = session()->get('session_id');

        return $this->response->setJSON([
            'contador' => $this->carritoModel->contarItems($usuarioId, $sessionId)
        ]);
    }
}
