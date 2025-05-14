<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notificaciones".
 *
 * @property int $id_notificacion
 * @property int|null $id_empleado
 * @property int|null $id_tiponotificacion
 * @property string|null $mensaje
 * @property string|null $fecha_envio
 * @property int|null $id_estado
 *
 * @property Empleados $empleado
 * @property Estados $estado
 * @property Tipos $tiponotificacion
 */
class Notificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_empleado', 'id_tiponotificacion', 'id_estado'], 'integer'],
            [['mensaje'], 'string'],
            [['fecha_envio'], 'safe'],
            [['id_empleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleados::class, 'targetAttribute' => ['id_empleado' => 'id_empleado']],
            [['id_tiponotificacion'], 'exist', 'skipOnError' => true, 'targetClass' => Tipos::class, 'targetAttribute' => ['id_tiponotificacion' => 'id_tiponotificacion']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::class, 'targetAttribute' => ['id_estado' => 'id_estado']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_notificacion' => 'Id Notificacion',
            'id_empleado' => 'Id Empleado',
            'id_tiponotificacion' => 'Id Tiponotificacion',
            'mensaje' => 'Mensaje',
            'fecha_envio' => 'Fecha Envio',
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
     * Gets query for [[Tiponotificacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTiponotificacion()
    {
        return $this->hasOne(Tipos::class, ['id_tiponotificacion' => 'id_tiponotificacion']);
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
            'estado' => function ($model) {
                return [
                    'nombre_estado' => $model->estado->nombre_estado, 
                ];
            },
            'tipo' => function ($model) {
                return [
                    'tipo' => $model->tiponotificacion->tipo, 
                ];
            },
        ];
    }

}
