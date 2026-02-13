<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    protected $table = 'direcciones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['usuario_id', 'alias', 'direccion', 'referencia', 'latitud', 'longitud', 'es_principal'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getDireccionesUsuario($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)
            ->orderBy('es_principal', 'DESC')
            ->findAll();
    }

    public function setPrincipal($direccionId, $usuarioId)
    {
        // Quitar principal de otras direcciones del usuario
        $this->where('usuario_id', $usuarioId)->set(['es_principal' => 0])->update();

        // Establecer nueva principal solo si se proporciona un ID
        if ($direccionId) {
            return $this->update($direccionId, ['es_principal' => 1]);
        }

        return true;
    }
}
