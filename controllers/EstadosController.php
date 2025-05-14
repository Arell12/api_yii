<?php
namespace app\controllers;

use app\models\Estados;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class EstadosController extends ActiveController
{
    public $modelClass = 'app\models\Estados';
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
    $total = Estados::find();
    if($text != '') {
        $total = $total->where(['like', new \yii\db\Expression("CONCAT(nombre_estado)"), $text]);
    }
    $total = $total->count();
    return $total;
}

public function actionBuscar($text)
{
    $consulta = Estados::find()->where(['like', new \yii\db\Expression("CONCAT(nombre_estado)"), $text]);

    $estados = new ActiveDataProvider([
        'query' => $consulta,
        'pagination' => [
            'pageSize' => 20 // Número de resultados por página
        ],
    ]);

    return $estados->getModels();
}
}

