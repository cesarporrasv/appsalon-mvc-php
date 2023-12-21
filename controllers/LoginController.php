<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController {

    public static function login(Router $router) {
        $alerts = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alerts = $auth->validateLogin();

            if(empty($alerts)) {
                // Comprobar que esxista usuario
                $user = User::where('email', $auth->email);
                
                if($user) {
                    // Verificar Password
                    if($user->validateVerifiedAndPassword($auth->password)) {
                        // Autenticar al Usuario
                        session_start();

                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name . " " . $user->lastname;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if($user->admin === "1") {
                            $_SESSION['admin'] = $user->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /appointment');
                        }
                    }
                } else {
                    User::setAlert('error', 'Usuario no Encontrado');
                }
            }
        }

        $alerts = User::getAlerts();
        
        $router->render('auth/login', [
            'alerts' => $alerts
        ]);
    }

    public static function logout() {
        session_start();

        $_SESSION = [];

        header('Location: /');
    }

    public static function forgot(Router $router) {

        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alerts = $auth->validateEmail();

            if (empty($alerts)) {
                $user = User::where('email', $auth->email);

                if($user && $user->confirmed === "1") {
                    
                    // Generar un Token
                    $user->createToken();
                    $user->save();

                    // Enviar Email
                    $email = new Email($user->name, $user->email, $user->token);
                    $email->sendInstructions();

                    // Alerta de exito
                    User::setAlert('success', 'Revisa tu Email');

                } else {
                    user::setAlert('error', 'Email no Existe o no Confirmado');
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/forgot-password', [
            'alerts' => $alerts
        ]);
    }

    public static function reset(Router $router) {

        $alerts = [];
        $error = false;
        $token = snz($_GET['token']);

        // Buscar usuario por su token
        $user = User::where('token', $token);

        if(empty($user)) {
            User::setAlert('error', 'Token no Válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo
            $password = new User($_POST);
            $alerts = $password->validatePassword();

            if(empty($alerts)) {
                $user->password = null;

                $user->password = $password->password;
                $user->hashPassword();
                $user->token = null;
                $output = $user->save();

                if($output) {
                    header('Location: /');
                }
            }
        }

        $alerts = User::getAlerts();
        $router->render('auth/reset-password', [
            'alerts' => $alerts,
            'error' => $error
        ]);
        
    }

    public static function create(Router $router) {

        $user = new User;

        // Alertas Vacias
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sync($_POST);
            $alerts = $user->validateNewAccount();

            // Revisar que alertas esté vacío
            if(empty($alerts)) {
                // Verificar que el usuario no este ya registrado
                $output = $user->userExists();

                if($output->num_rows) {
                    $alerts = User::getAlerts();
                } else {
                    // Hashear Password
                    $user->hashPassword();

                    // Crear Token
                    $user->createToken();

                    // Enviar el Email
                    $email = new Email($user->name, $user->email, $user->token);
                    $email->sendConfirmation();

                    // Crear el usuario
                    $output = $user->save();
                    if($output) {
                        header('Location: /message');
                    }
                }
            }
        }
        
        $router->render('auth/create-account', [
            'user' => $user,
            'alerts' => $alerts
        ]);
    }
 
        public static function message(Router $router) {

            $router->render('auth/message');
        }

        public static function verify(Router $router) {

            $alerts = [];
            $token = ($_GET['token']);
            $user = User::where('token', $token);

            if(empty($user) || $user->token === '') {
                // Mostrar mensaje de error
                User::setAlert('error', 'Token no válido');
            } else {
                // Modificar a usuario confirmado
                $user->confirmed = "1";
                $user->token = '';
                $user->save();
                User::setAlert('success', 'Cuenta Comprobada Correctamente');
            }

            // Obtener Alertas
            $alerts = User::getAlerts();

            // Renderizar la Vista
            $router->render('auth/verify-account', [
                'alerts' => $alerts
            ]);
        }
}