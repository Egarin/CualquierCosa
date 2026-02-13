<?php

namespace App\Controllers\Tienda;

use App\Controllers\BaseController;
use App\Models\CarritoModel;
use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use App\Models\ProductoModel;
use App\Models\DireccionModel;

class Checkout extends BaseController
{
    protected $carritoModel;
    protected $pedidoModel;
    protected $detallePedidoModel;
    protected $productoModel;
    protected $direccionModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->pedidoModel = new PedidoModel();
        $this->detallePedidoModel = new DetallePedidoModel();
        $this->productoModel = new ProductoModel();
        $this->direccionModel = new DireccionModel();
        helper(['form', 'text']);
    }

    public function index()
    {
        $usuarioId = session()->get('usuario_id');
        $sessionId = session()->get('session_id');

        $items = $this->carritoModel->getCarrito($usuarioId, $sessionId);

        if (empty($items)) {
            return redirect()->to('carrito')->with('error', 'Tu carrito está vacío');
        }

        $data = [
            'titulo' => 'Finalizar Compra',
            'items' => $items,
            'subtotal' => $this->carritoModel->calcularTotal($usuarioId, $sessionId),
            'direcciones' => $this->direccionModel->getDireccionesUsuario($usuarioId),
            'costo_envio' => 5.00 // Configurable
        ];

        return view('tienda/checkout/index', $data);
    }

    public function procesar()
    {
        $usuarioId = session()->get('usuario_id');
        $sessionId = session()->get('session_id');

        $items = $this->carritoModel->getCarrito($usuarioId, $sessionId);

        if (empty($items)) {
            return redirect()->to('carrito')->with('error', 'Tu carrito está vacío');
        }

        // Validar
        $rules = [
            'tipo_envio' => 'required|in_list[delivery,pickup]',
            'metodo_pago' => 'required|in_list[efectivo,tarjeta,transferencia,qr]'
        ];

        if ($this->request->getPost('tipo_envio') === 'delivery') {
            $rules['direccion_id'] = 'required|numeric';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Calcular totales
        $subtotal = $this->carritoModel->calcularTotal($usuarioId, $sessionId);
        $costoEnvio = $this->request->getPost('tipo_envio') === 'delivery' ? 5.00 : 0;
        $total = $subtotal + $costoEnvio;

        // Crear pedido
        $pedidoData = [
            'usuario_id' => $usuarioId,
            'direccion_id' => $this->request->getPost('direccion_id') ?: null,
            'codigo' => $this->pedidoModel->generarCodigo(),
            'subtotal' => $subtotal,
            'costo_envio' => $costoEnvio,
            'total' => $total,
            'tipo_envio' => $this->request->getPost('tipo_envio'),
            'metodo_pago' => $this->request->getPost('metodo_pago'),
            'notas' => $this->request->getPost('notas'),
            'estado' => 'pendiente'
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        $pedidoId = $this->pedidoModel->insert($pedidoData);

        // Insertar detalles y actualizar stock
        foreach ($items as $item) {
            $precio = $item['precio_oferta'] ?? $item['precio'];

            $detalleData = [
                'pedido_id' => $pedidoId,
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $precio,
                'subtotal' => $precio * $item['cantidad']
            ];

            $this->detallePedidoModel->insert($detalleData);

            // Actualizar stock
            $this->productoModel->actualizarStock($item['producto_id'], $item['cantidad'], 'restar');
        }

        // Vaciar carrito
        $this->carritoModel->vaciarCarrito($usuarioId, $sessionId);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Error al procesar el pedido');
        }

        return redirect()->to('checkout/confirmacion/' . $pedidoData['codigo']);
    }

    public function confirmacion($codigo)
    {
        $pedido = $this->pedidoModel->where('codigo', $codigo)->first();

        if (!$pedido || $pedido['usuario_id'] != session()->get('usuario_id')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'titulo' => 'Pedido Confirmado',
            'pedido' => $this->pedidoModel->getPedidoCompleto($pedido['id'])
        ];

        return view('tienda/checkout/confirmacion', $data);
    }
}
