<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dias".
 *
 * @property int $id_dia
 * @property string|null $nombre_dia
 *
 * @property Horarios[] $horarios
 */
class Dias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_dia'], 'required'], 
            [['nombre_dia'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dia' => 'Id Dia',
            'nombre_dia' => 'Nombre Dia',
        ];
    }

    /**
     * Gets query for [[Horarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHorarios()
    {
        return $this->hasMany(Horarios::class, ['id_dia' => 'id_dia']);
    }
    
    public function beforeValidate()
    {
        Yii::info(Yii::$app->request->post(), 'debug');
        return parent::beforeValidate();
    }
    

}
