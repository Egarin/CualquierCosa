<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\ProductoModel;
use App\Models\ClienteModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $pedidoModel = new PedidoModel();
        $productoModel = new ProductoModel();
        $clienteModel = new ClienteModel();

        // Estadísticas de hoy
        $hoy = date('Y-m-d');
        $statsHoy = $pedidoModel->getEstadisticas($hoy, $hoy);
        
        // Estadísticas del mes
        $inicioMes = date('Y-m-01');
        $statsMes = $pedidoModel->getEstadisticas($inicioMes, $hoy);

        $data = [
            'titulo' => 'Dashboard Administrativo',
            'stats_hoy' => $statsHoy,
            'stats_mes' => $statsMes,
            'pedidos_recientes' => $pedidoModel->getPedidosConDetalle(null, 'pendiente'),
            'productos_bajo_stock' => $productoModel->where('stock <=', 'stock_minimo')->findAll(5),
            'ventas_diarias' => $pedidoModel->getVentasDiarias(7),
            'total_clientes' => $clienteModel->where('rol', 'cliente')->countAllResults()
        ];

        return view('admin/dashboard/index', $data);
    }
}