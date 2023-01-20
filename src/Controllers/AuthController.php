<?php
namespace App\Controllers;

use App\Helpers\Captcha;
use App\Helpers\MsgHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Items\User;
use App\Items\Verify;
use App\Mail;

class AuthController {
    const DOMAIN = '@uma.es';

    static public function loginGet() {
        if (Misc::isLoggedIn()) {
            Misc::redirect('/');
            return;
        }

        Wrappers::plates('login');
    }

    static public function loginPost() {
        if (isset($_POST['niu'], $_POST['password'])) {
            $userDb = new User;
            $niu = $_POST['niu'];
            $plain_password = $_POST['password'];
            $user = $userDb->get($niu);
            if ($user) {
                // User exists
                if (password_verify($plain_password, $user->password)) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['niu'] = $user->niu;
                    $_SESSION['admin'] = boolval($user->admin);
                    Misc::redirect('/');
                }
            }
            echo 'That user does not exist or the password is incorrect';
        }
    }

    static public function registerGet() {
        if (Misc::isLoggedIn()) {
            Misc::redirect('/');
            return;
        }

        Wrappers::plates('register');
    }

    static public function registerPost() {
        if (!isset($_POST['niu'], $_POST['captcha'])) {
            MsgHandler::show(400, 'Cuerpo inválido');
            return;
        }

        $niu = trim($_POST['niu']);

        // https://www.uma.es/servicio-central-de-informatica/cms/menu/catalogo/mensajeria-electronica/
        if (substr($niu, 0, 3) !== '061') {
            MsgHandler::show(400, 'NIU Inválido');
            return;
        }

        $valid = Captcha::validate($_POST['captcha']);
        if (!$valid) {
            MsgHandler::show(400, 'Captcha inválido');
            return;
        }

        $db = Wrappers::db();

        $userDb = new User($db);
        $user = $userDb->get($niu);

        if ($user) {
            MsgHandler::show(400, 'Este usuario ya está registrado');
            return;
        }

        $code = bin2hex(random_bytes(64));

        $mail = new Mail;
        $address = $niu . self::DOMAIN;

        $verifyDb = new Verify($db);

        $sent = $mail->sendCode($address, $code);
        if (!$sent) {
            MsgHandler::show(500, 'Error al enviar el correo electrónico');
            return;
        }

        if ($verifyDb->exists($niu)) {
            $verifyDb->update($niu, $code);
        } else {
            $verifyDb->add($niu, $code);
        }

        MsgHandler::show(200, 'Si ese NIU realmente existe, debes haber recibido un correo electrónico en tu correo corporativo (@uma.es o @alu.uma.es) con más instrucciones. Si no has recibido el correo comprueba que el NIU sea válido o que tu bandeja de entrada no esté llena', '¡Éxito!');
    }

    static public function verifyGet() {
        if (!isset($_GET['code'])) {
            MsgHandler::show(400, 'Falta un código');
            return;
        }

        $verify = new Verify();

        $data = $verify->get($_GET['code']);

        if (!$data) {
            MsgHandler::show(400, 'Código inválido');
            return;
        }

        Wrappers::plates('verify', [
            'verify' => $data
        ]);
    }

    static public function verifyPost() {
        if (!isset($_POST['code'])) {
            MsgHandler::show(400, 'Falta un código');
            return;
        }

        if (!isset($_POST['password'], $_POST['password_repeat'])) {
            MsgHandler::show(400, 'Falta la contraseña');
            return;
        }

        $password = trim($_POST['password']);
        $password_repeat = trim($_POST['password_repeat']);
        if ($password !== $password_repeat) {
            MsgHandler::show(400, 'Las contraseñas no coinciden');
            return;
        }

        $db = Wrappers::db();

        $verify = new Verify($db);
        $data = $verify->get($_POST['code']);
        if (!$data) {
            MsgHandler::show(400, 'Código inválido');
            return;
        }

        $niu = $data->niu;

        $user = new User($db);
        $success = $user->add($niu, $password);
        if (!$success) {
            MsgHandler::show(500, 'Error al crear tu usuario');
            return;
        }

        // Remove verify
        $verify->delete($data->id);
        // Login user
        $_SESSION['loggedin'] = true;
        $_SESSION['niu'] = $niu;
        $_SESSION['admin'] = false;
        Misc::redirect('/');
    }

    static public function logout() {
        session_destroy();
        Misc::redirect('/login');
    }
}
