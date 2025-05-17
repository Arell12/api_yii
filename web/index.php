<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// Configuración de almacenamiento para Azure
$storagePath = '/home/storage';
if (!file_exists("$storagePath/runtime")) {
    mkdir("$storagePath/runtime", 0777, true);
}
if (!file_exists("$storagePath/assets")) {
    mkdir("$storagePath/assets", 0777, true);
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

// Configurar alias para Azure
Yii::setAlias('@runtime', "$storagePath/runtime");
Yii::setAlias('@webroot/assets', "$storagePath/assets");

(new yii\web\Application($config))->run();