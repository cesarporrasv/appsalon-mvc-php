<?php 
 
namespace Model;

class Service extends ActiveRecord {

    // Base de Datos
    protected static $table = 'servicios';
    protected static $columnsDB = ['id', 'name', 'price'];

    public $id;
    public $name;
    public $price;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->price = $args['price'] ?? '';
    }

    public function validate() {
        if(!$this->name) {
            self::$alerts['error'][] = 'Debes agregar un nombre al servicio';
        }

        if(!$this->price) {
            self::$alerts['error'][] = 'Debes agregar un precio al servicio';
        }

        if(!is_numeric($this->price)) {
            self::$alerts['error'][] = 'Formato de precio no válido';
        }

        return self::$alerts;
    }
}