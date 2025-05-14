<?php 
namespace app\models;

use yii\base\Model;

class RegistroForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;
    public $telefono;
    public $fecha_contratacion;
    public $id_departamento;
    public $id_rol;
    public $id_estado;
    public $user_img;

    public function rules() 
    {
        return [
            // Validación de unicidad para el username - Con targetClass
            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username'],

            // Campos obligatorios
            [['username', 'password', 'email', 'nombre', 'apellido_paterno', 'apellido_materno', 'telefono', 'fecha_contratacion', 'id_departamento', 'id_rol', 'id_estado'], 'required'],

            [['email'], 'email'],
            [['email'], 'string', 'max' => 128],

            // Validación de tipo de datos
            [['id_departamento', 'id_rol', 'id_estado'], 'integer'],

            [['telefono', 'user_img' ], 'string'],
            
            [['nombre', 'apellido_paterno', 'apellido_materno'], 'string', 'max' => 50],
            
            [['fecha_contratacion'], 'date', 'format' => 'php:Y-m-d'],
            
            [['username', 'password'], 'trim'],
        ];
    }
}