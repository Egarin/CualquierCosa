<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Productos extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        helper(['form', 'url', 'text']);
    }

    public function index()
    {
        $data = [
            'titulo' => 'Gestión de Productos',
            'productos' => $this->productoModel->getProductosConCategoria()
        ];

        return view('admin/productos/index', $data);
    }

    public function nuevo()
    {
        $data = [
            'titulo' => 'Nuevo Producto',
            'categorias' => $this->categoriaModel->getActivas(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/productos/form', $data);
    }

    public function guardar()
    {
        $rules = [
            'categoria_id' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'La categoría es obligatoria.',
                    'numeric' => 'La categoría no es válida.'
                ]
            ],
            'codigo' => [
                'rules' => 'required|is_unique[productos.codigo]',
                'errors' => [
                    'required' => 'El código es obligatorio.',
                    'is_unique' => 'El código ya está registrado en otro producto.'
                ]
            ],
            'nombre' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres.'
                ]
            ],
            'precio' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'El precio es obligatorio.',
                    'decimal' => 'El precio debe ser un número decimal.'
                ]
            ],
            'stock' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'El stock es obligatorio.',
                    'integer' => 'El stock debe ser un número entero.'
                ]
            ],
            'imagen' => [
                'rules' => 'if_exist|uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]',
                'errors' => [
                    'uploaded' => 'Error al subir la imagen.',
                    'max_size' => 'La imagen no debe pesar más de 2MB.',
                    'is_image' => 'El archivo debe ser una imagen válida.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'categoria_id' => $this->request->getPost('categoria_id'),
            'codigo' => $this->request->getPost('codigo'),
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'precio_oferta' => $this->request->getPost('precio_oferta') ?: null,
            'stock' => $this->request->getPost('stock'),
            'stock_minimo' => $this->request->getPost('stock_minimo') ?: 5,
            'unidad' => $this->request->getPost('unidad'),
            'marca' => $this->request->getPost('marca'),
            'peso' => $this->request->getPost('peso'),
            'destacado' => $this->request->getPost('destacado') ? 1 : 0
        ];

        try {
            // Manejar imagen
            $imagen = $this->request->getFile('imagen');
            if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
                $nuevoNombre = $imagen->getRandomName();
                $imagen->move(FCPATH . 'uploads/productos', $nuevoNombre);
                $data['imagen'] = $nuevoNombre;
            }

            $this->productoModel->insert($data);

            return redirect()->to('admin/productos')->with('success', 'Producto creado exitosamente');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function editar($id)
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'titulo' => 'Editar Producto',
            'producto' => $producto,
            'categorias' => $this->categoriaModel->getActivas(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/productos/form', $data);
    }

    public function actualizar($id)
    {
        $rules = [
            'categoria_id' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'La categoría es obligatoria.',
                    'numeric' => 'La categoría no es válida.'
                ]
            ],
            'codigo' => [
                'rules' => "required|is_unique[productos.codigo,id,$id]",
                'errors' => [
                    'required' => 'El código es obligatorio.',
                    'is_unique' => 'El código ya está registrado en otro producto.'
                ]
            ],
            'nombre' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El nombre es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres.'
                ]
            ],
            'precio' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'El precio es obligatorio.',
                    'decimal' => 'El precio debe ser un número decimal.'
                ]
            ],
            'stock' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'El stock es obligatorio.',
                    'integer' => 'El stock debe ser un número entero.'
                ]
            ],
            'imagen' => [
                'rules' => 'if_exist|uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]',
                'errors' => [
                    'uploaded' => 'Error al subir la imagen.',
                    'max_size' => 'La imagen no debe pesar más de 2MB.',
                    'is_image' => 'El archivo debe ser una imagen válida.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'categoria_id' => $this->request->getPost('categoria_id'),
            'codigo' => $this->request->getPost('codigo'),
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'precio_oferta' => $this->request->getPost('precio_oferta') ?: null,
            'stock' => $this->request->getPost('stock'),
            'stock_minimo' => $this->request->getPost('stock_minimo') ?: 5,
            'unidad' => $this->request->getPost('unidad'),
            'marca' => $this->request->getPost('marca'),
            'peso' => $this->request->getPost('peso'),
            'destacado' => $this->request->getPost('destacado') ? 1 : 0,
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        // Manejar imagen
        $imagen = $this->request->getFile('imagen');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            // Eliminar imagen anterior
            $producto = $this->productoModel->find($id);
            if ($producto['imagen'] && file_exists(FCPATH . 'uploads/productos/' . $producto['imagen'])) {
                unlink(FCPATH . 'uploads/productos/' . $producto['imagen']);
            }

            $nuevoNombre = $imagen->getRandomName();
            $imagen->move(FCPATH . 'uploads/productos', $nuevoNombre);
            $data['imagen'] = $nuevoNombre;
        }

        $this->productoModel->update($id, $data);

        return redirect()->to('admin/productos')->with('success', 'Producto actualizado exitosamente');
    }

    public function eliminar($id)
    {
        $producto = $this->productoModel->find($id);

        if ($producto['imagen'] && file_exists(FCPATH . 'uploads/productos/' . $producto['imagen'])) {
            unlink(FCPATH . 'uploads/productos/' . $producto['imagen']);
        }

        $this->productoModel->delete($id);

        return redirect()->to('admin/productos')->with('success', 'Producto eliminado');
    }
}
