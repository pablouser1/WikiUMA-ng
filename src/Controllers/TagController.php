<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Helpers\MsgHandler;
use App\Items\Tag;

class TagController {
    static public function create() {
        if (!Misc::isLoggedIn(true)) {
            Misc::redirect('/login');
            return;
        }

        self::__handleBody();

        $name = htmlspecialchars(trim($_POST['name']), ENT_COMPAT);
        $type = intval($_POST['type']);
        $icon = isset($_POST['icon']) ? htmlspecialchars(trim($_POST['icon'])) : null;

        $tag = new Tag();
        $success = $tag->add($name, $type, $icon);
        if (!$success) {
            MsgHandler::show(400, 'Error al agregar etiqueta');
            return;
        }

        Misc::redirect('/admin/tags');
    }

    static public function edit(int $id) {
        if (!Misc::isLoggedIn(true)) {
            Misc::redirect('/login');
            return;
        }

        self::__handleBody();

        $name = htmlspecialchars(trim($_POST['name']), ENT_COMPAT);
        $type = intval($_POST['type']);
        $icon = isset($_POST['icon']) ? htmlspecialchars(trim($_POST['icon'])) : null;

        $tag = new Tag();
        $success = $tag->edit($id, $name, $type, $icon);
        if (!$success) {
            MsgHandler::show(400, 'Error al editar etiqueta');
            return;
        }

        Misc::redirect('/admin/tags');
    }

    static public function delete(int $id) {
        if (!Misc::isLoggedIn(true)) {
            Misc::redirect('/login');
            return;
        }

        $tag = new Tag();
        $success = $tag->delete($id);
        if (!$success) {
            MsgHandler::show(400, 'Error al editar etiqueta');
            return;
        }

        Misc::redirect('/admin/tags');
    }

    static private function __handleBody() {
        if (!(isset($_POST['name']) && !empty($_POST['name']))) {
            MsgHandler::show(400, 'No hay nombre');
            return;
        }

        if (!(isset($_POST['type']) && is_numeric($_POST['type']))) {
            MsgHandler::show(400, 'No hay tipo o es inválido');
            return;
        }
    }
}
