<?php
namespace Model;

class User extends ActiveRecord {

    // Base de Datos
    protected static $table = 'usuarios';
    protected static $columnsDB = ['id', 'name', 'lastname', 'email', 'password', 'telephone', 'admin', 'confirmed', 'token'];

    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $telephone;
    public $admin;
    public $confirmed;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telephone = $args['telephone'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmed = $args['confirmed'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de validacion para la creacion de una cuenta
    public function validateNewAccount() {
        if(!$this->name) {
            self::$alerts['error'][] = 'Se requiere un Nombre';
        }

        if(!$this->lastname) {
            self::$alerts['error'][] = 'Se requiere un Apellido';
        }

        if(!$this->telephone) {
            self::$alerts['error'][] = 'Se requiere un Teléfono';
        }

        if(!$this->email) {
            self::$alerts['error'][] = 'Se requiere un Email';
        }

        if(!$this->password) {
            self::$alerts['error'][] = 'Se requiere un Password';
        }

        if(strlen($this->password) < 8) {
            self::$alerts['error'][] = 'El password debe tener al menos 8 caracteres';
        }

        return self::$alerts;
    }

    public function validateLogin() {
        if(!$this->email) {
            self::$alerts['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'El Password es Obligatorio';
        }

        return self::$alerts;
    }

    public function validateEmail() {
        if(!$this->email) {
            self::$alerts['error'][] = 'El Email es Obligatorio';
        }

        return self::$alerts;
    }

    public function validatePassword() {

        if(!$this->password) {
            self::$alerts['error'][] = 'El Password es Obligatorio';
        }
        if(strlen($this->password) < 8) {
            self::$alerts['error'][] = 'El password debe tener al menos 8 caracteres';
        }

        return self::$alerts;
    }

    // Revisa si el usuario ya existe
    public function userExists() {
        $query = " SELECT * FROM " . self::$table . " WHERE email = '" . $this->email . "' LIMIT 1";
        $output = self::$db->query($query);

        if($output->num_rows) {
            self::$alerts['error'][] = 'El Usuario ya Existe';
        }
        return $output;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken() {
        $this->token = uniqid();
    }

    public function validateVerifiedAndPassword($password) {
      $output = password_verify($password, $this->password);
      if(!$output || !$this->confirmed) {
          self::$alerts['error'][] = 'Password Incorrecto o Cuenta no Confirmada';
      } else {
        return true;
      }
    }
}
