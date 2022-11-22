<?php
namespace App\Controllers;

use App\DB;
use App\Helpers\Misc;
use App\Helpers\Wrappers;

class AdminController {
    static public function get() {
        if (!isset($_SESSION['loggedin'])) {
            Misc::redirect('/admin/login');
            exit;
        }

        $db = new DB;

        $reports = $db->getReports();

        Wrappers::plates('dashboard', [
            'reports' => $reports
        ]);
    }

    static public function loginGet() {
        if (isset($_SESSION['loggedin'])) {
            Misc::redirect('/admin');
            exit;
        }

        Wrappers::plates('login');
    }

    static public function loginPost() {
        if (isset($_POST['username'], $_POST['password'])) {
            $db = new DB;
            $username = $_POST['username'];
            $plain_password = $_POST['password'];
            $admin = $db->getAdmin($username);
            if ($admin) {
                // Admin exists
                if (password_verify($plain_password, $admin->password)) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $admin->username;
                    Misc::redirect('/admin');
                }
            }
            echo 'That user does not exist or the password is incorrect';
        }
    }

    static public function logout() {
        session_destroy();
        Misc::redirect('/admin/login');
    }
}
