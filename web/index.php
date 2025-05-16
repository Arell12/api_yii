<?php

// Cargar la configuración de almacenamiento para Azure App Service
require __DIR__ . '/../config/azure-storage.php';

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

// Aplicar la configuración de almacenamiento de Azure
if (isset($GLOBALS['yii2AzureStorage'])) {
    // Asegurarse de que exista la sección de alias en la configuración
    if (!isset($config['aliases'])) {
        $config['aliases'] = [];
    }
    
    // Agregar las rutas de almacenamiento a los alias
    $config['aliases']['@runtime'] = $GLOBALS['yii2AzureStorage']['runtimePath'];
    $config['aliases']['@webroot/assets'] = $GLOBALS['yii2AzureStorage']['assetsPath'];
}

(new yii\web\Application($config))->run();