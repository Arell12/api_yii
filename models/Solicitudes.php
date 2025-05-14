<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitudes".
 *
 * @property int $id_solicitud
 * @property int|null $id_empleado
 * @property int|null $id_permiso
 * @property string|null $fecha_inicio
 * @property string|null $fecha_fin
 * @property int|null $id_estado
 *
 * @property Empleados $empleado
 * @property Estados $estado
 * @property Permisos $permiso
 */
class Solicitudes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitudes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_empleado', 'id_permiso', 'id_estado'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['id_empleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleados::class, 'targetAttribute' => ['id_empleado' => 'id_empleado']],
            [['id_permiso'], 'exist', 'skipOnError' => true, 'targetClass' => Permisos::class, 'targetAttribute' => ['id_permiso' => 'id_permiso']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::class, 'targetAttribute' => ['id_estado' => 'id_estado']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_solicitud' => 'Id Solicitud',
            'id_empleado' => 'Id Empleado',
            'id_permiso' => 'Id Permiso',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'id_estado' => 'Id Estado',
        ];
    }

    /**
     * Gets query for [[Empleado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleado()
    {
        return $this->hasOne(Empleados::class, ['id_empleado' => 'id_empleado']);
    }

    /**
     * Gets query for [[Estado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estados::class, ['id_estado' => 'id_estado']);
    }

    /**
     * Gets query for [[Permiso]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPermiso()
    {
        return $this->hasOne(Permisos::class, ['id_permiso' => 'id_permiso']);
    }

    public function extraFields()
    {
        return [
            'empleado' => function ($model) {
                return [
                    'nombre' => $model->empleado->nombre,
                    'apellido_paterno' => $model->empleado->apellido_paterno,
                    'apellido_materno' => $model->empleado->apellido_materno,
                    'user_img' => 'http://localhost:8080/'.$model -> empleado -> user_img,
                ];
            },
            'permiso'  => function($model){
                return[
                    'nombre_permiso' => $model->permiso->nombre_permiso,
                ];
            },
        'estado'  => function($model){
            return[
                'nombre_estado' => $model->estado->nombre_estado,
            ];
        }
        ];
    }

}


