<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Items\Report;
use App\Items\Review;
use App\Items\Tag;

class AdminController {
    static public function dashboard() {
        if (!Misc::isLoggedIn(true)) {
            Misc::redirect('/login');
            return;
        }

        $review = new Review();
        $stats = $review->statsTotal();

        Wrappers::plates('admin/dashboard', ['stats' => $stats]);
    }

    static public function reports() {
        if (!Misc::isLoggedIn(true)) {
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
        if (!Misc::isLoggedIn(true)) {
            Misc::redirect('/login');
            return;
        }

        $page = Misc::getPage();
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
        $order = isset($_GET['order']) ? $_GET['order'] : 'desc';

        $review = new Review();
        $reviews = $review->getAll($page, $sort, $order);

        Wrappers::plates('admin/reviews', [
            'reviews' => $reviews
        ]);
    }

    static public function tags() {
        if (!Misc::isLoggedIn(true)) {
            Misc::redirect('/login');
            return;
        }

        $tag = new Tag();
        $tags = $tag->getAll();

        Wrappers::plates('admin/tags', [
            'tags' => $tags
        ]);
    }
}
