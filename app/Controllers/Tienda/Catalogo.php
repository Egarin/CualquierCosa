<?php

namespace App\Controllers\Tienda;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Catalogo extends BaseController
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
            'titulo' => 'Catálogo de Productos',
            'productos' => $this->productoModel->getProductosConCategoria(1),
            'categorias' => $this->categoriaModel->getConConteoProductos(),
            'destacados' => $this->productoModel->getDestacados(4)
        ];

        return view('tienda/catalogo/index', $data);
    }

    public function categoria($slug)
    {
        $categoria = $this->categoriaModel->where('slug', $slug)->first();

        if (!$categoria) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'titulo' => $categoria['nombre'],
            'categoria' => $categoria,
            'productos' => $this->productoModel->getPorCategoria($slug),
            'categorias' => $this->categoriaModel->getConConteoProductos()
        ];

        return view('tienda/catalogo/categoria', $data);
    }

    public function buscar()
    {
        $busqueda = $this->request->getGet('q');
        $categoria = $this->request->getGet('categoria');
        $precio_min = $this->request->getGet('precio_min');
        $precio_max = $this->request->getGet('precio_max');

        $data = [
            'titulo' => 'Resultados de búsqueda',
            'busqueda' => $busqueda,
            'productos' => $this->productoModel->buscar($busqueda, $categoria, $precio_min, $precio_max),
            'categorias' => $this->categoriaModel->getConConteoProductos(),
            'filtros' => [
                'categoria' => $categoria,
                'precio_min' => $precio_min,
                'precio_max' => $precio_max
            ]
        ];

        return view('tienda/catalogo/buscar', $data);
    }

    public function detalle($slug)
    {
        $producto = $this->productoModel->where('slug', $slug)->first();

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Productos relacionados
        $relacionados = $this->productoModel->where('categoria_id', $producto['categoria_id'])
            ->where('id !=', $producto['id'])
            ->where('activo', 1)
            ->limit(4)
            ->find();

        $data = [
            'titulo' => $producto['nombre'],
            'producto' => $producto,
            'relacionados' => $relacionados
        ];

        return view('tienda/catalogo/detalle', $data);
    }
}
