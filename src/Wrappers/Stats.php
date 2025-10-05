<?php

namespace App\Wrappers;

use App\Cache;
use App\Enums\ReportStatusEnum;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use Illuminate\Support\Collection as SupportCollection;

class Stats
{
    private const array STOP_WORDS = [
        'el', 'la', 'los', 'las', 'un', 'una', 'unos', 'unas', 'mi', 'tu', 'su', 'nuestro',
        'vuestro', 'mi', 'tu', 'sus', 'nuestros', 'vuestros',
        'de', 'a', 'en', 'por', 'para', 'con', 'sobre', 'bajo', 'entre', 'hacia', 'hasta',
        'desde', 'durante', 'mediante', 'segun', 'sin', 'tras',
        'y', 'o', 'u', 'e', 'ni', 'que', 'pero', 'aunque', 'porque', 'si',
        'es', 'son', 'esta', 'este', 'estos', 'estas', 'ser', 'estar', 'haber', 'hay', 'tener',
        'yo', 'tu', 'el', 'ella', 'usted', 'nosotros', 'vosotros', 'ellos', 'ellas', 'ustedes',
        'me', 'te', 'se', 'nos', 'os', 'lo', 'le', 'les', 'la', 'los', 'del', 'al',
        'mas', 'mas', 'muy', 'tan', 'tanto', 'tambien', 'ademas', 'sino', 'solo', 'ya', 'aqui', 'ahi',
        'alla', 'poco', 'mucho', 'otro', 'algún', 'algo', 'nada', 'todo', 'cualquier', 'cada',
        'mas', 'asi', 'como', 'cuando', 'donde', 'quien', 'que', 'cuyo', 'cuyas',
        // Single letters and common short words often extracted by word counters
        'd', 'l', 'c'
    ];

    private const int MAX_REPEATED_WORDS = 5;

    public static function all(): object
    {
        $reviews = Review::all();
        $count = $reviews->count();

        return (object) [
            'total' => $count,
        ];
    }

    public static function fromTarget(string $target, ReviewTypesEnum $type, Cache $cache): object
    {
        $reviews = Review::where('target', '=', $target)
            ->where('type', '=', $type)
            ->whereDoesntHave('reports', function ($query) {
                $query->where('status', ReportStatusEnum::ACCEPTED);
            });

        $total = $reviews->count();
        $avg = round($reviews->avg('note'), 2);
        $min = $reviews->min('note');
        $max = $reviews->max('note');
        $words = self::__getMostUsedWords($reviews->pluck('message'), self::__getMustUsedWordsCacheKey($target, $type), $cache);

        return (object) [
            'total' => $total,
            'avg' => $avg,
            'min' => $min,
            'max' => $max,
            'words' => $words,
        ];
    }

    private static function __getMostUsedWords(SupportCollection $messages, string $cacheKey, Cache $cache): array
    {
        if ($cache->exists($cacheKey)) {
            return (array) $cache->get($cacheKey, true)->data;
        }

        $gluedMessage = '';

        // Remove html tags, join all messages in one string and transliterate
        foreach ($messages as $message) {
            if ($message !== null) {
                $gluedMessage .= strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', strip_tags($message))) . ' ';
            }
        }

        // Extract all words into an array
        $words = str_word_count($gluedMessage, 1);

        // Remove stop words
        $filtered_words = array_diff($words, self::STOP_WORDS);

        // Count frequency of remaining words
        if (empty($filtered_words)) {
            return [];
        }

        $word_counts = array_count_values($filtered_words);
        arsort($word_counts);

        $words_final = array_slice($word_counts, 0, self::MAX_REPEATED_WORDS, true);

        // 1 week cache
        $cache->set($cacheKey, json_encode($words_final), 604800);

        return array_slice($word_counts, 0, self::MAX_REPEATED_WORDS, true);
    }

    private static function __getMustUsedWordsCacheKey(string $target, ReviewTypesEnum $type): string
    {
        return "words|$target|{$type->value}";
    }
}
