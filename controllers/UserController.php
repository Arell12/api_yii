<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\Empleados;
use app\models\LoginForm;
use app\models\RegistroForm;
use app\models\Roles;
use app\models\User;
use Yii;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin'                           => ['http://localhost:8100', 'http://localhost:8101'],
                'Access-Control-Request-Method'    => ['POST'],
                'Access-Control-Request-Headers'   => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age'           => 600
            ]
        ];

        return $behaviors;
    }


    public function actionLogin()
    {
        $token = '';
        $model = new LoginForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->login()) {
            $token = User::findOne(['username' => $model->username])->auth_key;
        }
        return $token;
    }




    public function actionRegistrar()
    {
        $token = '';
        $model = new RegistroForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        // Validamos el modelo primero
        if (!$model->validate()) {
            return $model->errors;
        }

        $user = new User();
        $user->username = $model->username;

        // $user->password = $model->password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($model->password);


        $user->auth_key = Yii::$app->security->generateRandomString(32);

        $user->email = $model->email;

        $user->created_at = time();
        $user->updated_at = time();

        $user->status = User::STATUS_ACTIVE;
        $user->email_confirmed = 1;

        // // Creamos un nuevo modelo de Usuario
        // $user = new User();
        // $user->username        = $model->username;
        // $user->password        = $model->password;  // Puedes encriptar la contraseña más tarde
        // $user->status          = User::STATUS_ACTIVE; // Asegúrate de que STATUS_ACTIVE esté definido
        // $user->email_confirmed = 1;

        // Intentamos guardar el usuario
        if ($user->save()) {
            // Ahora creamos el modelo de Empleado y lo asociamos al usuario
            $empleado = new Empleados();
            $empleado->nombre          = $model->nombre;
            $empleado->apellido_paterno = $model->apellido_paterno;
            $empleado->apellido_materno = $model->apellido_materno;
            $empleado->telefono        = $model->telefono;
            $empleado->fecha_contratacion = $model->fecha_contratacion;
            $empleado->id_departamento  = $model->id_departamento;
            $empleado->id_rol           = $model->id_rol;
            $empleado->id_estado        = $model->id_estado;
            $empleado->user_img         = $model->user_img;  // Aquí puedes guardar la imagen

            $empleado->id_user = $user->id;

            // Guardamos el modelo de empleado
            if ($empleado->save()) {
                // === Paso adicional para AuthAssignment ===

                // 1. Buscar el nombre del rol en la tabla Roles
                $rol = Roles::findOne($empleado->id_rol);

                if ($rol) {
                    // 2. Crear un nuevo registro en AuthAssignment
                    $authAssignment = new AuthAssignment();
                    $authAssignment->item_name = $rol->nombre_rol;  // Asignar el nombre del rol
                    $authAssignment->user_id = $user->id;
                    $authAssignment->created_at = time(); // Asignar la fecha actual

                    if ($authAssignment->save()) {
                        // Si todo va bien, devolvemos el token
                        $token = $user->auth_key;
                    } else {
                        // Error al guardar AuthAssignment
                        $empleado->delete();
                        $user->delete();
                        return $authAssignment->errors;
                    }
                } else {
                    // Error: No se encontró el rol en la base de datos
                    $empleado->delete();
                    $user->delete();
                    return ['error' => 'Rol no encontrado.'];
                }
            } else {
                $user->delete();
                return $empleado->errors;
            }
        } else {
            return $user->errors;
        }

        return $token;
    }
}
