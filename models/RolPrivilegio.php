<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rol_privilegio".
 *
 * @property int $id_rol_privilegio
 * @property int|null $id_rol
 * @property int|null $id_privilegio
 *
 * @property Privilegios $privilegio
 * @property Roles $rol
 */
class RolPrivilegio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rol_privilegio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rol', 'id_privilegio'], 'integer'],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['id_rol' => 'id_rol']],
            [['id_privilegio'], 'exist', 'skipOnError' => true, 'targetClass' => Privilegios::class, 'targetAttribute' => ['id_privilegio' => 'id_privilegio']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_rol_privilegio' => 'Id Rol Privilegio',
            'id_rol' => 'Id Rol',
            'id_privilegio' => 'Id Privilegio',
        ];
    }

    /**
     * Gets query for [[Privilegio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrivilegio()
    {
        return $this->hasOne(Privilegios::class, ['id_privilegio' => 'id_privilegio']);
    }

    /**
     * Gets query for [[Rol]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Roles::class, ['id_rol' => 'id_rol']);
    }

    public function extraFields()
    {
        return [
            'rol' => function ($model) {
                return [
                    'nombre_rol' => $model->rol->nombre_rol,
                ];
            },
            'privilegio' => function ($model) {
                return [
                    'nombre_privilegio' => $model->privilegio->nombre_privilegio,
                ];
            },
        ];
    }
}
