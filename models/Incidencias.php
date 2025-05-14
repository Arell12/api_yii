<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "incidencias".
 *
 * @property int $id_incidencia
 * @property int|null $id_empleado
 * @property string|null $tipo
 * @property string|null $fecha_incidencia
 * @property string|null $descripcion
 * @property int|null $id_estado
 * @property string|null $datos_adicionales
 *
 * @property Empleados $empleado
 * @property Estados $estado
 */
class Incidencias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'incidencias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_empleado', 'id_estado'], 'integer'],
            [['tipo', 'descripcion', 'datos_adicionales'], 'string'],
            [['fecha_incidencia'], 'safe'],
            [['id_empleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleados::class, 'targetAttribute' => ['id_empleado' => 'id_empleado']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::class, 'targetAttribute' => ['id_estado' => 'id_estado']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_incidencia' => 'Id Incidencia',
            'id_empleado' => 'Id Empleado',
            'tipo' => 'Tipo',
            'fecha_incidencia' => 'Fecha Incidencia',
            'descripcion' => 'Descripcion',
            'id_estado' => 'Id Estado',
            'datos_adicionales' => 'Datos Adicionales',
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



    public function extraFields(){
        return [
            'empleado' => function($model){
                return[
                    'nombre' => $model -> empleado -> nombre,
                    'apellido_paterno' => $model -> empleado -> apellido_paterno,
                    'apellido_materno' => $model -> empleado -> apellido_materno,
                    'user_img' => 'http://localhost:8080/'.$model -> empleado -> user_img,
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
