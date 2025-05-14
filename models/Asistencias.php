<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asistencias".
 *
 * @property int $id_asistencia
 * @property int|null $id_empleado
 * @property string|null $fecha_hora_entrada
 * @property string|null $fecha_hora_salida
 * @property float|null $latitud
 * @property float|null $longitud
 *
 * @property Empleados $empleado
 */
class Asistencias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asistencias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_empleado'], 'integer'],
            [['fecha_hora_entrada', 'fecha_hora_salida'], 'safe'],
            [['latitud', 'longitud'], 'number'],
            [['id_empleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleados::class, 'targetAttribute' => ['id_empleado' => 'id_empleado']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_asistencia' => 'Id Asistencia',
            'id_empleado' => 'Id Empleado',
            'fecha_hora_entrada' => 'Fecha Hora Entrada',
            'fecha_hora_salida' => 'Fecha Hora Salida',
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
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

    public function extraFields(){
        return [
            'empleado' => function($model){
                return[
                    'nombre' => $model -> empleado -> nombre,
                    'apellido_paterno' => $model -> empleado -> apellido_paterno,
                    'apellido_materno' => $model -> empleado -> apellido_materno,
                    'user_img' => 'http://localhost:8080/'.$model -> empleado -> user_img,
                ];
            }
        ];
    }

}
