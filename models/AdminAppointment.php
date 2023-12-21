<?php

namespace Model;

class AdminAppointment extends ActiveRecord {
    protected static $table = 'citasServicios';
    protected static $columnsDB = ['id', 'time', 'customer', 'email', 'telephone', 'service', 'price'];

    public $id;
    public $time;
    public $customer;
    public $email;
    public $telephone;
    public $service;
    public $price;

    public function __construct() {
        $this->id = $args['id'] ?? null;
        $this->time = $args['time'] ?? '';
        $this->customer = $args['customer'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telephone = $args['telephone'] ?? '';
        $this->service = $args['service'] ?? '';
        $this->price = $args['price'] ?? '';
    }
}
