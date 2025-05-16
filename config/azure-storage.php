<?php
/**
 * Este archivo modifica la configuración de Yii2 para que funcione en Azure App Service.
 * 
 * El principal problema que resuelve es la restricción de escritura en el directorio principal
 * de la aplicación (/home/site/wwwroot/) que es de solo lectura en Azure App Service.
 * 
 * Este script:
 * 1. Redirige los directorios `runtime` y `assets` a ubicaciones persistentes en `/home/storage/`
 * 2. Asegura que estos directorios existan y tengan los permisos correctos
 * 3. Configura Yii2 para usar estas rutas en lugar de las predeterminadas
 */

// Definir la ruta de almacenamiento persistente
defined('STORAGE_DIR') or define('STORAGE_DIR', '/home/storage');

// Configurar Yii para usar las rutas de almacenamiento persistente
// Esto debe hacerse antes de cargar la aplicación Yii
$runtimePath = STORAGE_DIR . '/runtime';
$assetsPath = STORAGE_DIR . '/assets';

// Crear directorios si no existen (esto es redundante con el script de inicio,
// pero es una buena práctica tenerlo aquí también)
if (!file_exists($runtimePath)) {
    @mkdir($runtimePath, 0777, true);
}
if (!file_exists($assetsPath)) {
    @mkdir($assetsPath, 0777, true);
}

// Configurar Yii2 para usar estas rutas
// Esto se hará mediante alias cuando se cargue Yii
$GLOBALS['yii2AzureStorage'] = [
    'runtimePath' => $runtimePath,
    'assetsPath' => $assetsPath,
];

// Este archivo debe ser incluido en web/index.php antes de cargar la aplicación
// Después, en la configuración de la aplicación (en config/web.php), agregar:
/*
$config = [
    ...
    'aliases' => [
        '@runtime' => $GLOBALS['yii2AzureStorage']['runtimePath'],
        '@webroot/assets' => $GLOBALS['yii2AzureStorage']['assetsPath'],
    ],
    ...
];
*/