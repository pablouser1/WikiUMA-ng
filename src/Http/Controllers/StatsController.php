<?php

namespace App\Http\Controllers;

use App\Dto\FromDto;
use App\Enums\ReviewTypeEnum;
use App\Models\Review;
use App\Wrappers\UMA;
use Bbsnly\ChartJs\Chart;
use Bbsnly\ChartJs\Config\Data;
use Bbsnly\ChartJs\Config\Dataset;
use Bbsnly\ChartJs\Config\Options;
use Illuminate\Support\Collection;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Stats Controller.
 */
class StatsController extends Controller
{
    /**
     * Main site.
     *
     * Route: `/stats`
     * Method: `GET`
     */
    public static function index(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();

        if (!isset($query['target'], $query['type'])) {
            throw self::__invalidParams();
        }

        $type = ReviewTypeEnum::tryFrom($query['type']);
        if ($type === null) {
            throw self::__invalidParams();
        }

        $target = $query['target'];

        if (!$type->isValidTarget($target)) {
            throw self::__inconsistentData();
        }

        if ($type === ReviewTypeEnum::TEACHER && UMA::isExcluded($target)) {
            throw self::__invalidParams();
        }

        $distribution = Review::where('target', $target)
            ->selectRaw('note, count(*) as count')
            ->groupBy('note')
            ->pluck('count', 'note');

        $distChart = self::__buildDistributionChart($distribution);

        $popular = Review::where('target', $target)->orderByDesc('votes')->first();
        $unpopular = Review::where('target', $target)->orderBy('votes')->first();

        return self::__render('views/stats', $request, [
            'distribution' => $distChart,
            'popular' => $popular,
            'unpopular' => $unpopular,
            'from' => new FromDto($target, $type),
        ]);
    }

    private static function __buildDistributionChart(Collection $dist): Chart
    {
        $labels = range(0, 10);
        $dataPoints = array_map(fn($note) => $dist->get($note, 0), $labels);

        $chart = new Chart();
        $chart->type = 'bar';

        // Setup Data
        $data = new Data();
        $data->labels($labels);

        $dataset = new Dataset();
        $dataset->data($dataPoints);

        $data->datasets([$dataset]);

        $options = self::__buildOptions('Nota', 'Valoraciones totales');

        $chart->data($data);
        $chart->options($options);

        return $chart;
    }

    private static function __buildOptions(string $x, string $y): Options
    {
        $options = new Options();
        $options->responsive(true);
        $options->scales([
            'x' => [
                'title' => [
                    'display' => true,
                    'text' => $x,
                    'color' => '#666',
                    'font' => [
                        'family' => 'Arial',
                        'size' => 14,
                        'weight' => 'bold',
                    ],
                    'padding' => ['top' => 10, 'bottom' => 0],
                ],
            ],
            'y' => [
                'title' => [
                    'display' => true,
                    'text' => $y,
                    'color' => '#666',
                    'font' => [
                        'family' => 'Arial',
                        'size' => 14,
                        'weight' => 'bold',
                    ],
                    'padding' => ['top' => 0, 'bottom' => 10],
                ],
            ],
        ]);

        $options->plugins([
            'legend' => [
                'display' => false,
            ],
        ]);

        return $options;
    }
}
