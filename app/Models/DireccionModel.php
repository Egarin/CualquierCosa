<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    protected $table = 'direcciones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['usuario_id', 'alias', 'direccion', 'referencia', 'latitud', 'longitud', 'es_principal'];
    protected $useTimestamps = true;

    public function getDireccionesUsuario($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)
                    ->orderBy('es_principal', 'DESC')
                    ->findAll();
    }

    public function setPrincipal($direccionId, $usuarioId)
    {
        // Quitar principal de otras direcciones
        $this->where('usuario_id', $usuarioId)->set(['es_principal' => 0])->update();
        
        // Establecer nueva principal
        return $this->update($direccionId, ['es_principal' => 1]);
    }
}