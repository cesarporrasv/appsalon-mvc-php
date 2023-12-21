<?php

namespace Controllers;

use Model\Appointment;
use Model\AppointmentService;
use Model\Service;

class APIController {
    public static function index() {
        $services = Service::all();
        echo json_encode($services);
    }

    public static function save() {

        // almacena la cita y devuelve el ID
        $appointment = new Appointment($_POST);
        $output = $appointment->save();

        $id = $output['id'];

        // almacena los servicios con el id de la cita
        $idServices = explode(",", $_POST['services']);
        foreach($idServices as $idService) {
            $args = [
                'appointmentId' => $id,
                'serviceId' => $idService
            ];
            $appointmentService = new AppointmentService($args);
            $appointmentService->save();
        }

        echo json_encode(['output' => $output]);
    }

    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $appointment = Appointment::find($id);
            $appointment->delete();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        };
    }
}
