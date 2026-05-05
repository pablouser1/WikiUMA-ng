<?php
namespace App\Console\Migration;

use App\Enums\ReviewTypesEnum;
use App\Models\Legend;
use App\Models\Review;

class DbToLegendMigrationCommand extends BaseMigration
{

    public function __construct()
    {
        parent::__construct(
            'migration:db2legend',
            'Add teacher and associated reviews to legend'
        );

        $this->argument('<id>', 'Teacher id');
    }

    /**
     * @param string id
     * @return int Return code
     */
    public function execute($id)
    {
        $io = $this->app()->io();
        $w = $io->writer();

        if (!($id !== '' && is_numeric($id))) {
            $w->error('No ID provided', true);
            return 1;
        }
        $id = (int) $id;

        $db = $this->db();

        // -- Teacher info -- //
        $stmt = $db->prepare('SELECT * FROM profesor WHERE ID=:id');
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $res = $stmt->execute();
        if ($res === false) {
            $w->error('Db error', true);
            return 1;
        }

        $row = $res->fetchArray(SQLITE3_ASSOC);
        if ($row === false) {
            $w->error('ID Not found', true);
            return 1;
        }

        // Copy teacher name to new db
        $legend = new Legend();
        $legend->full_name = $row['Nombre'];
        $legend->save();

        // -- Reviews info -- //
        $stmt = $db->prepare('SELECT * FROM valoraciones WHERE ID_Profesor=:id');
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $res = $stmt->execute();
        if ($res === false) {
            $w->error('Db error', true);
            return 1;
        }

        $reviews = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $reviews[] = [
                'created_at' => $row['Fecha'],
                'target' => $legend->id,
                'type' => ReviewTypesEnum::LEGEND,
                'username' => $row['Nick'] !== '' ? trim($row['Nick']) : null,
                'note' => $row['Valoracion'],
                'message' => trim($row['Comentario']),
                'votes' => $row['VotosPositivos'] - $row['VotosNegativos'],
            ];
        }

        Review::insert($reviews);
        return 0;
    }
}
