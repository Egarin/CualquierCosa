<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'slug', 'descripcion', 'icono', 'color', 'orden', 'activo'];
    protected $useTimestamps = false;

    // Generar slug automáticamente
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

    public function getActivas()
    {
        return $this->where('activo', 1)
            ->orderBy('orden', 'ASC')
            ->findAll();
    }

    public function getConConteoProductos()
    {
        $builder = $this->db->table($this->table . ' c');
        $builder->select('c.*, COUNT(p.id) as total_productos');
        $builder->join('productos p', 'p.categoria_id = c.id AND p.activo = 1', 'left');
        $builder->where('c.activo', 1);
        $builder->groupBy('c.id');
        $builder->orderBy('c.orden', 'ASC');
        return $builder->get()->getResultArray();
    }
}
