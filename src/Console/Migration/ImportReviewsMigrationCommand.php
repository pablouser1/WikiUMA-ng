<?php
namespace App\Console\Migration;

use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\Storage;

class ImportReviewsMigrationCommand extends BaseMigration
{

    public function __construct()
    {
        parent::__construct(
            'migration:import-reviews',
            'Write all importable reviews'
        );
    }

    /**
     * @return int Return code
     */
    public function execute()
    {
        $io = $this->app()->io();
        $w = $io->writer();

        $relationsIdnc = json_decode(Storage::get('relations-idnc.json'), true);
        if ($relationsIdnc === false) {
            $w->error('Could not get json from last step', true);
            return 1;
        }

        $reviews = $this->__getReviewsDbByIds($relationsIdnc);
        if ($reviews === null) {
            $w->error('Could not get reviews from db', true);
            return 1;
        }

        Review::insert($reviews);

        return 0;
    }

    /**
     * Get reviews from linked teachers.
     */
    private function __getReviewsDbByIds(array $relationsIdnc): ?array
    {
        $db = $this->db();
        $reviews = [];
        $idsStr = implode(',', array_keys($relationsIdnc));
        $stmt = $db->prepare('SELECT * FROM valoraciones WHERE ID_Profesor IN (:ids)');
        $stmt->bindValue(':ids', $idsStr, SQLITE3_TEXT);
        $res = $stmt->execute();
        if ($res === false) {
            return null;
        }

        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $reviews[] = (object) [
                'created_at' => $row['Fecha'],
                'target' => $relationsIdnc[$row['ID_Profesor']],
                'type' => ReviewTypesEnum::TEACHER,
                'username' => $row['Nick'] !== '' ? trim($row['Nick']) : null,
                'note' => $row['Valoracion'],
                'message' => trim($row['Comentario']),
                'votes' => $row['VotosPositivos'] - $row['VotosNegativos'],
            ];
        }

        return $reviews;
    }
}
