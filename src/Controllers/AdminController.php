<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Items\Admin;
use App\Items\Report;
use App\Items\Review;

class AdminController {
    static public function dashboard() {
        if (!Misc::isLoggedIn()) {
            Misc::redirect('/admin/login');
            exit;
        }

        $review = new Review();
        $stats = $review->statsTotal();

        Wrappers::plates('dashboard', ['stats' => $stats]);
    }

    static public function reports() {
        if (!Misc::isLoggedIn()) {
            Misc::redirect('/admin/login');
            exit;
        }
        $report = new Report;
        $reports = $report->getAll();

        Wrappers::plates('reports', [
            'reports' => $reports
        ]);
    }

    static public function reviews() {
        if (!Misc::isLoggedIn()) {
            Misc::redirect('/admin/login');
            exit;
        }

        $page = Misc::getPage();
        $sort = $_GET['sort'] ?? 'created_at';
        $order = $_GET['order'] ?? 'desc';

        $review = new Review();
        $reviews = $review->getAll($page, $sort, $order);

        Wrappers::plates('reviews', [
            'reviews' => $reviews
        ]);
    }

    static public function loginGet() {
        if (Misc::isLoggedIn()) {
            Misc::redirect('/admin');
            exit;
        }

        Wrappers::plates('login');
    }

    static public function loginPost() {
        if (isset($_POST['username'], $_POST['password'])) {
            $adminDb = new Admin;
            $username = $_POST['username'];
            $plain_password = $_POST['password'];
            $admin = $adminDb->get($username);
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
