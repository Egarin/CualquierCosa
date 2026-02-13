<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'categoria_id',
        'codigo',
        'nombre',
        'slug',
        'descripcion',
        'precio',
        'precio_oferta',
        'stock',
        'stock_minimo',
        'unidad',
        'imagen',
        'marca',
        'peso',
        'destacado',
        'activo'
    ];
    protected $useTimestamps = true;
    protected $beforeInsert = ['generarSlug'];
    protected $beforeUpdate = ['generarSlug'];

    protected function generarSlug(array $data)
    {
        if (!empty($data['data']['nombre'])) {
            $data['data']['slug'] = url_title($data['data']['nombre'], '-', true);

            // Ensure uniqueness
            $originalSlug = $data['data']['slug'];
            $count = 1;
            while ($this->where('slug', $data['data']['slug'])->first()) {
                $data['data']['slug'] = $originalSlug . '-' . $count++;
            }
        }
        return $data;
    }

    // Obtener productos con información de categoría
    public function getProductosConCategoria($activo = null)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, c.nombre as categoria_nombre, c.slug as categoria_slug, c.color');
        $builder->join('categorias c', 'c.id = p.categoria_id');

        if ($activo !== null) {
            $builder->where('p.activo', $activo);
        }

        $builder->orderBy('p.id', 'DESC');
        return $builder->get()->getResultArray();
    }

    // Buscar productos
    public function buscar($busqueda = '', $categoria = null, $precio_min = null, $precio_max = null)
    {
        $builder = $this->db->table($this->table . ' p');
        $builder->select('p.*, c.nombre as categoria_nombre');
        $builder->join('categorias c', 'c.id = p.categoria_id');
        $builder->where('p.activo', 1);

        if (!empty($busqueda)) {
            $builder->groupStart()
                ->like('p.nombre', $busqueda)
                ->orLike('p.marca', $busqueda)
                ->orLike('p.codigo', $busqueda)
                ->groupEnd();
        }

        if ($categoria) {
            $builder->where('c.slug', $categoria);
        }

        if ($precio_min !== null) {
            $builder->where('p.precio >=', $precio_min);
        }

        if ($precio_max !== null) {
            $builder->where('p.precio <=', $precio_max);
        }

        return $builder->get()->getResultArray();
    }

    // Productos destacados
    public function getDestacados($limit = 8)
    {
        return $this->where('destacado', 1)
            ->where('activo', 1)
            ->limit($limit)
            ->find();
    }

    // Productos por categoría
    public function getPorCategoria($categoriaSlug)
    {
        return $this->select('productos.*, categorias.nombre as categoria_nombre')
            ->join('categorias', 'categorias.id = productos.categoria_id')
            ->where('categorias.slug', $categoriaSlug)
            ->where('productos.activo', 1)
            ->findAll();
    }

    // Verificar stock
    public function verificarStock($productoId, $cantidad)
    {
        $producto = $this->find($productoId);
        return $producto && $producto['stock'] >= $cantidad;
    }

    // Actualizar stock
    public function actualizarStock($productoId, $cantidad, $operacion = 'restar')
    {
        $producto = $this->find($productoId);
        if (!$producto) return false;

        $nuevoStock = $operacion === 'restar'
            ? $producto['stock'] - $cantidad
            : $producto['stock'] + $cantidad;

        return $this->update($productoId, ['stock' => $nuevoStock]);
    }
}
