<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "departamentos".
 *
 * @property int $id_departamento
 * @property string|null $nombre_departamento
 * @property string|null $descripcion
 * @property string $img_departamento
 *
 * @property Empleados[] $empleados
 */
class Departamentos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departamentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'img_departamento'], 'string'],
            [['img_departamento'], 'required'],
            [['nombre_departamento'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_departamento' => 'Id Departamento',
            'nombre_departamento' => 'Nombre Departamento',
            'descripcion' => 'Descripcion',
            'img_departamento' => 'Img Departamento',
        ];
    }

    /**
     * Gets query for [[Empleados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleados::class, ['id_departamento' => 'id_departamento']);
    }

    public function fields()
    {
        $fields = parent::fields();

        // Modificar el campo img_departamento para incluir la URL base
        $fields['img_departamento'] = function ($model) {
            return Url::base(true) . '/' . ltrim($model->img_departamento, '/');
        };

        return $fields;
    }
}
