<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'usuario_id', 'direccion_id', 'codigo', 'subtotal', 'costo_envio',
        'descuento', 'total', 'tipo_envio', 'estado', 'metodo_pago', 'notas', 'fecha_entrega'
    ];
    protected $useTimestamps = true;

    // Generar código único
    public function generarCodigo()
    {
        $prefijo = 'PED';
        $fecha = date('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return $prefijo . '-' . $fecha . '-' . $random;
    }

    // Obtener pedidos con información completa
    public function getPedidosConDetalle($usuarioId = null, $estado = null)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, u.nombre as cliente_nombre, u.email as cliente_email, u.telefono as cliente_telefono');
        $builder->join('usuarios u', 'u.id = p.usuario_id', 'left');
        
        if ($usuarioId) {
            $builder->where('p.usuario_id', $usuarioId);
        }
        
        if ($estado) {
            $builder->where('p.estado', $estado);
        }
        
        $builder->orderBy('p.created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    // Obtener un pedido con todos sus detalles
    public function getPedidoCompleto($pedidoId)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, u.nombre as cliente_nombre, u.email as cliente_email, u.telefono as cliente_telefono, 
                         d.direccion, d.referencia, d.latitud, d.longitud');
        $builder->join('usuarios u', 'u.id = p.usuario_id', 'left');
        $builder->join('direcciones d', 'd.id = p.direccion_id', 'left');
        $builder->where('p.id', $pedidoId);
        
        $pedido = $builder->get()->getRowArray();
        
        if ($pedido) {
            // Obtener detalles
            $detalleModel = new DetallePedidoModel();
            $pedido['detalles'] = $detalleModel->getDetallesConProducto($pedidoId);
        }
        
        return $pedido;
    }

    // Estadísticas para dashboard
    public function getEstadisticas($fechaInicio = null, $fechaFin = null)
    {
        $builder = $this->db->table($this->table);
        
        if ($fechaInicio && $fechaFin) {
            $builder->where('DATE(created_at) >=', $fechaInicio);
            $builder->where('DATE(created_at) <=', $fechaFin);
        }
        
        // Total de pedidos
        $totalPedidos = $builder->countAllResults(false);
        
        // Total de ventas
        $builder->selectSum('total');
        $result = $builder->get()->getRow();
        $totalVentas = $result->total ?? 0;
        
        // Pedidos por estado
        $builder = $this->db->table($this->table);
        $builder->select('estado, COUNT(*) as cantidad');
        $builder->groupBy('estado');
        $porEstado = $builder->get()->getResultArray();
        
        return [
            'total_pedidos' => $totalPedidos,
            'total_ventas' => $totalVentas,
            'por_estado' => $porEstado
        ];
    }

    // Ventas diarias para gráfico
    public function getVentasDiarias($dias = 30)
    {
        $builder = $this->db->table($this->table);
        $builder->select('DATE(created_at) as fecha, COUNT(*) as cantidad, SUM(total) as total');
        $builder->where('created_at >=', date('Y-m-d', strtotime("-$dias days")));
        $builder->where('estado !=', 'cancelado');
        $builder->groupBy('DATE(created_at)');
        $builder->orderBy('fecha', 'ASC');
        return $builder->get()->getResultArray();
    }
}