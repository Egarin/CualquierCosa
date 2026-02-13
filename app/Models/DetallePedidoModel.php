<?php

namespace App\Models;

use CodeIgniter\Model;

class DetallePedidoModel extends Model
{
    protected $table = 'detalle_pedidos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pedido_id', 'producto_id', 'cantidad', 'precio_unitario', 'subtotal'];
    protected $useTimestamps = false;

    public function getDetallesConProducto($pedidoId)
    {
        $builder = $this->db->table($this->table . ' dp');
        $builder->select('dp.*, p.nombre as producto_nombre, p.imagen, p.unidad');
        $builder->join('productos p', 'p.id = dp.producto_id');
        $builder->where('dp.pedido_id', $pedidoId);
        return $builder->get()->getResultArray();
    }

    // Productos más vendidos
    public function getProductosMasVendidos($limit = 10)
    {
        $builder = $this->db->table($this->table . ' dp');
        $builder->select('dp.producto_id, p.nombre, p.imagen, SUM(dp.cantidad) as total_vendido, SUM(dp.subtotal) as total_ingresos');
        $builder->join('productos p', 'p.id = dp.producto_id');
        $builder->join('pedidos ped', 'ped.id = dp.pedido_id');
        $builder->where('ped.estado !=', 'cancelado');
        $builder->groupBy('dp.producto_id');
        $builder->orderBy('total_vendido', 'DESC');
        $builder->limit($limit);
        return $builder->get()->getResultArray();
    }
}