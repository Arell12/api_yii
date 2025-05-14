<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id_rol
 * @property string|null $nombre_rol
 *
 * @property Empleados[] $empleados
 * @property RolPrivilegio[] $rolPrivilegios
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_rol'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_rol' => 'Id Rol',
            'nombre_rol' => 'Nombre Rol',
        ];
    }

    /**
     * Gets query for [[Empleados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleados::class, ['id_rol' => 'id_rol']);
    }

    /**
     * Gets query for [[RolPrivilegios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRolPrivilegios()
    {
        return $this->hasMany(RolPrivilegio::class, ['id_rol' => 'id_rol']);
    }
}
