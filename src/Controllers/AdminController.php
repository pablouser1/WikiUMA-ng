<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Items\Report;
use App\Items\Review;

class AdminController {
    static public function dashboard() {
        if (!Misc::isLoggedIn()) {
            Misc::redirect('/login');
            return;
        }

        $review = new Review();
        $stats = $review->statsTotal();

        Wrappers::plates('admin/dashboard', ['stats' => $stats]);
    }

    static public function reports() {
        if (!Misc::isLoggedIn()) {
            Misc::redirect('/login');
            return;
        }
        $report = new Report;
        $reports = $report->getAll();

        Wrappers::plates('admin/reports', [
            'reports' => $reports
        ]);
    }

    static public function reviews() {
        if (!Misc::isLoggedIn()) {
            Misc::redirect('/login');
            return;
        }

        $page = Misc::getPage();
        $sort = $_GET['sort'] ?? 'created_at';
        $order = $_GET['order'] ?? 'desc';

        $review = new Review();
        $reviews = $review->getAll($page, $sort, $order);

        Wrappers::plates('admin/reviews', [
            'reviews' => $reviews
        ]);
    }
}
