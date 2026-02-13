<?php

namespace App\Controllers\Tienda;

use App\Controllers\BaseController;
use App\Models\DireccionModel;

class Direcciones extends BaseController
{
    protected $direccionModel;

    public function __construct()
    {
        $this->direccionModel = new DireccionModel();
        helper(['form', 'url']);
    }

    public function guardar()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Acceso no permitido']);
        }

        $usuarioId = session()->get('usuario_id');
        if (!$usuarioId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión expirada']);
        }

        $rules = [
            'alias' => 'required|max_length[50]',
            'direccion' => 'required|max_length[255]',
            'referencia' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'usuario_id' => $usuarioId,
            'alias' => $this->request->getPost('alias'),
            'direccion' => $this->request->getPost('direccion'),
            'referencia' => $this->request->getPost('referencia'),
            'es_principal' => $this->request->getPost('es_principal') ? 1 : 0
        ];

        try {
            if ($data['es_principal']) {
                $this->direccionModel->setPrincipal(null, $usuarioId); // Reset others
            }

            $id = $this->direccionModel->insert($data);

            if ($id) {
                // Return all addresses to refresh the list
                $direcciones = $this->direccionModel->getDireccionesUsuario($usuarioId);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Dirección guardada correctamente',
                    'id' => $id,
                    'direcciones' => $direcciones,
                    'csrf_name' => csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al guardar la dirección',
                    'csrf_name' => csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
                'csrf_name' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }
    public function actualizar($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Acceso no permitido']);
        }

        $usuarioId = session()->get('usuario_id');
        $direccion = $this->direccionModel->where(['id' => $id, 'usuario_id' => $usuarioId])->first();

        if (!$direccion) {
            return $this->response->setJSON(['success' => false, 'message' => 'Dirección no encontrada']);
        }

        $rules = [
            'alias' => 'required|max_length[50]',
            'direccion' => 'required|max_length[255]',
            'referencia' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'alias' => $this->request->getPost('alias'),
            'direccion' => $this->request->getPost('direccion'),
            'referencia' => $this->request->getPost('referencia'),
            'es_principal' => $this->request->getPost('es_principal') ? 1 : 0
        ];

        try {
            if ($data['es_principal']) {
                $this->direccionModel->setPrincipal(null, $usuarioId);
            }

            if ($this->direccionModel->update($id, $data)) {
                $direcciones = $this->direccionModel->getDireccionesUsuario($usuarioId);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Dirección actualizada correctamente',
                    'direcciones' => $direcciones,
                    'csrf_name' => csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function eliminar($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Acceso no permitido']);
        }

        $usuarioId = session()->get('usuario_id');
        $direccion = $this->direccionModel->where(['id' => $id, 'usuario_id' => $usuarioId])->first();

        if (!$direccion) {
            return $this->response->setJSON(['success' => false, 'message' => 'Dirección no encontrada']);
        }

        if ($this->direccionModel->delete($id)) {
            $direcciones = $this->direccionModel->getDireccionesUsuario($usuarioId);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Dirección eliminada correctamente',
                'direcciones' => $direcciones,
                'csrf_name' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar dirección']);
    }
}
