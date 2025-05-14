<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "empleados".
 *
 * @property int $id_empleado
 * @property string|null $nombre
 * @property string|null $apellido_paterno
 * @property string|null $apellido_materno
 * @property string|null $email
 * @property string|null $telefono
 * @property string|null $fecha_contratacion
 * @property int|null $id_departamento
 * @property int|null $id_rol
 * @property int|null $id_estado
 * @property string $user_img
 *
 * @property Asistencias[] $asistencias
 * @property Departamentos $departamento
 * @property Estados $estado
 * @property Horarios[] $horarios
 * @property Incidencias[] $incidencias
 * @property Notificaciones[] $notificaciones
 * @property Roles $rol
 * @property Solicitudes[] $solicitudes
 */
class Empleados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empleados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_contratacion'], 'safe'],
            [['id_departamento', 'id_rol', 'id_estado'], 'integer'],
            [['user_img'], 'required'],
            [['user_img'], 'string'],
            [['nombre', 'apellido_paterno', 'apellido_materno'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['telefono'], 'string', 'max' => 20],
            [['id_departamento'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::class, 'targetAttribute' => ['id_departamento' => 'id_departamento']],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['id_rol' => 'id_rol']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::class, 'targetAttribute' => ['id_estado' => 'id_estado']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_empleado' => 'Id Empleado',
            'nombre' => 'Nombre',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'email' => 'Email',
            'telefono' => 'Telefono',
            'fecha_contratacion' => 'Fecha Contratacion',
            'id_departamento' => 'Id Departamento',
            'id_rol' => 'Id Rol',
            'id_estado' => 'Id Estado',
            'user_img' => 'User Img',
        ];
    }

    /**
     * Gets query for [[Asistencias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAsistencias()
    {
        return $this->hasMany(Asistencias::class, ['id_empleado' => 'id_empleado']);
    }

    /**
     * Gets query for [[Departamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamentos::class, ['id_departamento' => 'id_departamento']);
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
     * Gets query for [[Horarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHorarios()
    {
        return $this->hasMany(Horarios::class, ['id_empleado' => 'id_empleado']);
    }

    /**
     * Gets query for [[Incidencias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIncidencias()
    {
        return $this->hasMany(Incidencias::class, ['id_empleado' => 'id_empleado']);
    }

    /**
     * Gets query for [[Notificaciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificaciones()
    {
        return $this->hasMany(Notificaciones::class, ['id_empleado' => 'id_empleado']);
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

    /**
     * Gets query for [[Solicitudes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudes()
    {
        return $this->hasMany(Solicitudes::class, ['id_empleado' => 'id_empleado']);
    }

    public function fields()
    {
        $fields = parent::fields();

        // Modificar el campo img_departamento para incluir la URL base
        $fields['user_img'] = function ($model) {
            return Url::base(true) . '/' . ltrim($model->user_img, '/');
        };

        return $fields;
    }
    
    public function extraFields()
    {
        return [
            'departamento' => function ($model) {
                return [
                    'nombre_departamento' => $model->departamento->nombre_departamento,
                ];
            },
        'rol'  => function($model){
            return[
                'nombre_rol' => $model->rol->nombre_rol,
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
