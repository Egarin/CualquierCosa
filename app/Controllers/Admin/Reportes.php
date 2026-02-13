<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;

class Reportes extends BaseController
{
    protected $pedidoModel;
    protected $detallePedidoModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->detallePedidoModel = new DetallePedidoModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Reportes',
            'stats' => $this->pedidoModel->getEstadisticas()
        ];

        return view('admin/reportes/index', $data);
    }

    public function ventas()
    {
        $fechaInicio = $this->request->getGet('inicio') ?? date('Y-m-01');
        $fechaFin = $this->request->getGet('fin') ?? date('Y-m-d');

        $data = [
            'titulo' => 'Reporte de Ventas',
            'ventas' => $this->pedidoModel->getVentasDiarias(30),
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin
        ];

        return view('admin/reportes/ventas', $data);
    }

    public function productos()
    {
        $data = [
            'titulo' => 'Productos Más Vendidos',
            'productos' => $this->detallePedidoModel->getProductosMasVendidos(20)
        ];

        return view('admin/reportes/productos', $data);
    }
}