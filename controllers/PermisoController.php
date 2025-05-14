<?php

namespace app\controllers;

use app\models\Permiso;
use webvimark\modules\UserManagement\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class PermisoController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin'                           => ['http://localhost:8100'],
                'Access-Control-Request-Method'    => ['GET'],
                'Access-Control-Request-Headers'   => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age'           => 600
            ]
        ];
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ]
        ];
        return $behaviors;
    }

    public $enableCsrfValidation = false;
    public $modelClass = 'app\models\Permiso';

    public function actionListaPermisos($user = '')
    {
        $permitidas = [];
        $user = User::findOne(['auth_key' => $user]);
        if (isset($user)) {
            $userRoles = $user->roles;
            $permisos = Permiso::find()->all();
            foreach ($permisos as $p) {
                $rolesPermitidos = explode(',', $p->per_rol);

                foreach ($userRoles as $rol) {
                    $rolNombre = is_array($rol) ? $rol['name'] : $rol->name;
                    if (in_array($rolNombre, $rolesPermitidos)) {
                        $permitidas[] = $p->per_vista;
                        break;
                    }
                }
            }
        }
        return $permitidas;
    }
}