<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'email', 'password', 'telefono', 'rol', 'activo'];
    protected $useTimestamps = true;

    public function getClientesConPedidos()
    {
        $builder = $this->db->table($this->table . ' u');
        $builder->select('u.*, COUNT(p.id) as total_pedidos, SUM(p.total) as total_gastado');
        $builder->join('pedidos p', 'p.usuario_id = u.id', 'left');
        $builder->where('u.rol', 'cliente');
        $builder->groupBy('u.id');
        $builder->orderBy('u.created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function getClienteConDirecciones($clienteId)
    {
        $cliente = $this->find($clienteId);
        if ($cliente) {
            $direccionModel = new \App\Models\DireccionModel();
            $cliente['direcciones'] = $direccionModel->where('usuario_id', $clienteId)->findAll();
            
            $pedidoModel = new PedidoModel();
            $cliente['pedidos'] = $pedidoModel->getPedidosConDetalle($clienteId);
        }
        return $cliente;
    }
}