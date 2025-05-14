<?php
namespace app\controllers;

use app\models\Roles;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class RolesController extends ActiveController
{
    public $modelClass = 'app\models\Roles';
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
    $total = Roles::find();
    if($text != '') {
        $total = $total->where(['like', new \yii\db\Expression("CONCAT(nombre_rol)"), $text]);
    }
    $total = $total->count();
    return $total;
}

public function actionBuscar($text)
{
    $consulta = Roles::find()->where(['like', new \yii\db\Expression("CONCAT(nombre_rol)"), $text]);

    $roles = new ActiveDataProvider([
        'query' => $consulta,
        'pagination' => [
            'pageSize' => 20 // Número de resultados por página
        ],
    ]);

    return $roles->getModels();
}
}
