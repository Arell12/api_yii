<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horarios".
 *
 * @property int $id_horario
 * @property int|null $id_empleado
 * @property int|null $id_turno
 * @property int|null $id_dia
 *
 * @property Dias $dia
 * @property Empleados $empleado
 * @property Turnos $turno
 */
class Horarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_empleado', 'id_turno', 'id_dia'], 'integer'],
            [['id_empleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleados::class, 'targetAttribute' => ['id_empleado' => 'id_empleado']],
            [['id_turno'], 'exist', 'skipOnError' => true, 'targetClass' => Turnos::class, 'targetAttribute' => ['id_turno' => 'id_turno']],
            [['id_dia'], 'exist', 'skipOnError' => true, 'targetClass' => Dias::class, 'targetAttribute' => ['id_dia' => 'id_dia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_horario' => 'Id Horario',
            'id_empleado' => 'Id Empleado',
            'id_turno' => 'Id Turno',
            'id_dia' => 'Id Dia',
        ];
    }

    /**
     * Gets query for [[Dia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDia()
    {
        return $this->hasOne(Dias::class, ['id_dia' => 'id_dia']);
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
     * Gets query for [[Turno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTurno()
    {
        return $this->hasOne(Turnos::class, ['id_turno' => 'id_turno']);
    }
    public function extraFields()
    {
        return[
            'empleado' => function ($model) {
                return[
                    'nombre' => $model->empleado->nombre,
                    'apellido_paterno' => $model->empleado->apellido_paterno,
                    'apellido_materno' => $model->empleado->apellido_materno,
                    'user_img' => 'http://localhost:8080/'.$model->empleado->user_img,
                ];
            },
            'turno'  => function($model){
            return[
                'nombre_turno' => $model->turno->nombre_turno,
                'hora_inicio' => $model->turno->hora_inicio,
                'hora_fin' => $model->turno->hora_fin,
            ];
        },
        'dia'  => function($model){
            return[
                'nombre_dia' => $model->dia->nombre_dia,
            ];
        }    
        ];
    }
}
