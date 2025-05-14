<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "privilegios".
 *
 * @property int $id_privilegio
 * @property string|null $nombre_privilegio
 *
 * @property RolPrivilegio[] $rolPrivilegios
 */
class Privilegios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'privilegios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_privilegio'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_privilegio' => 'Id Privilegio',
            'nombre_privilegio' => 'Nombre Privilegio',
        ];
    }

    /**
     * Gets query for [[RolPrivilegios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRolPrivilegios()
    {
        return $this->hasMany(RolPrivilegio::class, ['id_privilegio' => 'id_privilegio']);
    }
}
