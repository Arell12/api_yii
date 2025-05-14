<?php
namespace app\controllers;

use app\models\Asistencias;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class AsistenciasController extends ActiveController
{
    public $modelClass = 'app\models\Asistencias';
    public $enableCsrfValidation = false;
    
    function normalizarTexto($texto)
    {
        $acentos = ['á','é','í','ó','ú','Á','É','Í','Ó','Ú'];
        $sinAcento = ['a','e','i','o','u','a','e','i','o','u'];
        return str_replace($acentos, $sinAcento, $texto);
    }

    public function behaviors()
{
    $behaviors = parent::behaviors();

    unset($behaviors['authenticator']);

    $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::className(),
        'cors' => [
            'Origin'                           => ['http://localhost:8100','http://localhost:8101'],
            'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'DELETE'],
            'Access-Control-Request-Headers'   => ['*'],
            'Access-Control-Allow-Credentials' => true,
            'Access-Control-Max-Age'           => 600
        ]
    ];

    $behaviors['authenticator'] = [
        'class' => CompositeAuth::className(),
        'authMethods' => [
            HttpBearerAuth::className(),
        ],
        'except' => ['index', 'view']
    ];

    return $behaviors;


}




public function actionTotal($text="") {

    $total = Asistencias::find()->joinWith('empleado');

    if ($text != '') {
        $palabras = preg_split('/\s+/', trim($text));

        foreach ($palabras as $palabra) {
            $palabra = strtolower($this->normalizarTexto($palabra));

            $total->andWhere([
                'or',
                ['like', new \yii\db\Expression("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(nombre, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'))"), $palabra],
                ['like', new \yii\db\Expression("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(apellido_paterno, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'))"), $palabra],
                ['like', new \yii\db\Expression("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(apellido_materno, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'))"), $palabra],
            ]);
        }
    }

    $total = $total->count();

    return $total;
}




public function actionBuscar($text)
{

    $consulta = Asistencias::find()->joinWith('empleado');

    $palabras = preg_split('/\s+/', trim($text));

    foreach ($palabras as $palabra) {
        // Convertimos la palabra a minúsculas y sin tildes
        $palabra = strtolower($this->normalizarTexto($palabra));

        $consulta->andWhere([
            'or',
            ['like', new \yii\db\Expression("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(nombre, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'))"), $palabra],
            ['like', new \yii\db\Expression("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(apellido_paterno, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'))"), $palabra],
            ['like', new \yii\db\Expression("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(apellido_materno, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u'))"), $palabra],
        ]);
    }

    $asistencias = new ActiveDataProvider([
        'query' => $consulta,
        'pagination' => [
            'pageSize' => 20 // Número de resultados por página
        ],
    ]);

    return $asistencias->getModels();
}
}
