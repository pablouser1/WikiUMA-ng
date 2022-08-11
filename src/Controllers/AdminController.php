<?php
namespace App\Controllers;

use App\DB;
use App\Helpers\Misc;
use App\Helpers\Wrappers;

class AdminController {
    static public function get() {
        session_start();
        if (!isset($_SESSION['loggedin'])) {
            Misc::redirect('/admin/login');
            exit;
        }

        $db = new DB;

        $reports = $db->getReports();

        Wrappers::latte('admin/dashboard', [
            'title' => 'Dashboard',
            'reports' => $reports
        ]);
    }

    static public function loginGet() {
        session_start();
        if (isset($_SESSION['loggedin'])) {
            Misc::redirect('/admin');
            exit;
        }

        Wrappers::latte('admin/login', [
            'title' => 'Login'
        ]);
    }

    static public function loginPost() {
        session_start();

        if (isset($_POST['username'], $_POST['password'])) {
            $db = new DB;
            $username = $_POST['username'];
            $plain_password = $_POST['password'];
            $admin = $db->getAdmin($username);
            if ($admin) {
                // Admin exists
                if (password_verify($plain_password, $admin->password)) {
                    $_SESSION['loggedin'] = true;
                    Misc::redirect('/admin');
                }
            }
            echo 'That user does not exist or the password is incorrect';
        }
    }

    static public function logout() {
        session_start();
        session_destroy();
        Misc::redirect('/admin/login');
    }
}
