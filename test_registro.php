<?php

// Validar que se está ejecutando desde la línea de comandos
if (php_sapi_name() !== 'cli') {
    die('Este script solo se puede ejecutar desde la línea de comandos.');
}

// Cargar el framework
require 'F:/wamp/www/minimarket/app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
CodeIgniter\Boot::bootWeb($paths);

use App\Models\UsuarioModel;

$model = new UsuarioModel();

// Datos de prueba
$data = [
    'nombre' => 'Test User',
    'email' => 'test@example.com',
    'password' => 'password123',
    'telefono' => '123456789',
    'rol' => 'cliente'
];

// Limpiar usuario de prueba anterior si existe
$existing = $model->where('email', $data['email'])->first();
if ($existing) {
    echo "Eliminando usuario de prueba anterior...\n";
    $model->delete($existing['id']);
}

// Intentar insertar
echo "Intentando registrar usuario...\n";
try {
    $id = $model->insert($data);
    if ($id) {
        echo "Usuario registrado exitosamente con ID: $id\n";

        // Verificar hash
        $user = $model->find($id);
        if (password_verify('password123', $user['password'])) {
            echo "VERIFICACIÓN EXITOSA: La contraseña se ha hasheado correctamente.\n";
        } else {
            echo "ERROR: La contraseña NO coincide (problema de doble hash o falta de hash).\n";
            echo "Hash almacenado: " . $user['password'] . "\n";
        }
    } else {
        echo "Error al registrar usuario.\n";
        print_r($model->errors());
    }
} catch (Exception $e) {
    echo "Excepción: " . $e->getMessage() . "\n";
}
