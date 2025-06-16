<?php

// Entorno actual: 'dev', 'prod', etc.
define('APP_ENV', 'dev');

// Rutas
define('BASE_URL', '/sca/');

// Configuración por entorno
$config = [
    'dev' => [
        'DB_HOST' => 'localhost',
        'DB_PORT' => '3306',
        'DB_NAME' => 'sca',
        'DB_USER' => 'root',
        'DB_PASS' => '1234',
    ],
    'prod' => [
        'DB_HOST' => 'localhost',
        'DB_PORT' => '3306',
        'DB_NAME' => 'sca_prod',
        'DB_USER' => 'sca_admin',
        'DB_PASS' => 'clave_segura',
    ],
];

// Cargar la config activa
$current = $config[APP_ENV];

define('DB_HOST', $current['DB_HOST']);
define('DB_PORT', $current['DB_PORT']);
define('DB_NAME', $current['DB_NAME']);
define('DB_USER', $current['DB_USER']);
define('DB_PASS', $current['DB_PASS']);
?>