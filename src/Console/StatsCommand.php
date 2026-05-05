<?php
namespace App\Console;

use Ahc\Cli\Input\Command;
use App\Wrappers\Stats;

class StatsCommand extends Command
{
    public function __construct()
    {
        parent::__construct('stats', 'Show stats');

        $this->option('-l --lowest', 'Sort by lowest', 'boolval', false);
    }

    /**
     * @param bool $lowest
     */
    public function execute($lowest)
    {
        $w = $this->app()->io()->writer();
        $weighted = Stats::weighted(!$lowest);
        if ($weighted->lastRes !== null && !$weighted->lastRes->success) {
            $w->error($weighted->lastRes->error);
        }

        $data = [];
        foreach ($weighted->data as $item) {
            $data[] = [
                'nombre' => $item->for->nombre,
                'avg' => $item->avg,
                'total' => $item->total,
            ];
        }

        $w->table($data);
    }
}
