<?php

namespace Controllers;

use Model\AdminAppointment;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        createSession();
        isAdmin();

        $date = $_GET['date'] ?? date('Y-m-d');
        $dates = explode('-', $date);

        if (!checkdate($dates[1], $dates[2], $dates[0])) {
            header('Location: /404');
        }

        // consultar BD
        $query = "SELECT citas.id, citas.time, CONCAT( usuarios.name, ' ', usuarios.lastname) as customer, ";
        $query .= " usuarios.email, usuarios.telephone, servicios.name as service, servicios.price  ";
        $query .= " FROM citas  ";
        $query .= " LEFT OUTER JOIN usuarios ";
        $query .= " ON citas.userId=usuarios.id  ";
        $query .= " LEFT OUTER JOIN citasServicios ";
        $query .= " ON citasServicios.appointmentId=citas.id ";
        $query .= " LEFT OUTER JOIN servicios ";
        $query .= " ON servicios.id=citasServicios.serviceId ";
        $query .= " WHERE date = '$date' ";

        $appointments = AdminAppointment::SQL($query);

        $router->render('admin/index', [
            'name' => $_SESSION['name'],
            'appointments' => $appointments,
            'date' => $date
        ]);
    }
}
