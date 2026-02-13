<?php

namespace App\Models;

use CodeIgniter\Model;

class HistorialPedidoModel extends Model
{
    protected $table = 'historial_pedidos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pedido_id', 'estado_anterior', 'estado_nuevo', 'nota', 'usuario_id'];
    protected $useTimestamps = true;
}