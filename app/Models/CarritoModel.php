<?php

namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table = 'carrito';
    protected $primaryKey = 'id';
    protected $allowedFields = ['usuario_id', 'session_id', 'producto_id', 'cantidad'];
    protected $useTimestamps = true;

    // Obtener carrito con detalles de productos
    public function getCarrito($usuarioId = null, $sessionId = null)
    {
        $builder = $this->db->table($this->table . ' c');
        $builder->select('c.*, p.nombre, p.precio, p.precio_oferta, p.imagen, p.stock, p.slug, p.unidad');
        $builder->join('productos p', 'p.id = c.producto_id');

        if ($usuarioId) {
            $builder->where('c.usuario_id', $usuarioId);
        } else {
            $builder->where('c.session_id', $sessionId);
            $builder->where('c.usuario_id', null);
        }

        return $builder->get()->getResultArray();
    }

    // Agregar o actualizar item
    public function agregarItem($data)
    {
        // Buscar si ya existe específicamente para este usuario o sesión
        $this->where('producto_id', $data['producto_id']);

        if (!empty($data['usuario_id'])) {
            $this->where('usuario_id', $data['usuario_id']);
        } else {
            $this->where('session_id', $data['session_id']);
        }

        $existente = $this->first();

        if ($existente) {
            // Actualizar cantidad
            $nuevaCantidad = $existente['cantidad'] + $data['cantidad'];
            return $this->update($existente['id'], ['cantidad' => $nuevaCantidad]);
        } else {
            // Insertar nuevo
            return $this->insert($data);
        }
    }

    // Vaciar carrito
    public function vaciarCarrito($usuarioId = null, $sessionId = null)
    {
        if ($usuarioId) {
            return $this->where('usuario_id', $usuarioId)->delete();
        }
        return $this->where('session_id', $sessionId)->delete();
    }

    // Migrar carrito de sesión a usuario (al login)
    public function migrarASesionUsuario($sessionId, $usuarioId)
    {
        $items = $this->where('session_id', $sessionId)->findAll();

        foreach ($items as $item) {
            $this->agregarItem([
                'usuario_id' => $usuarioId,
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad']
            ]);
        }

        return $this->where('session_id', $sessionId)->delete();
    }

    // Contar items
    public function contarItems($usuarioId = null, $sessionId = null)
    {
        $builder = $this->db->table($this->table);

        if ($usuarioId) {
            $builder->where('usuario_id', $usuarioId);
        } else {
            $builder->where('session_id', $sessionId);
            $builder->where('usuario_id', null);
        }

        return $builder->countAllResults();
    }

    // Calcular total
    public function calcularTotal($usuarioId = null, $sessionId = null)
    {
        $items = $this->getCarrito($usuarioId, $sessionId);
        $total = 0;

        foreach ($items as $item) {
            $precio = $item['precio_oferta'] ?? $item['precio'];
            $total += $precio * $item['cantidad'];
        }

        return $total;
    }
}
