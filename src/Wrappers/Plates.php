<?php

namespace App\Wrappers;

use App\Constants\Links;
use App\Enums\TagTypesEnum;
use League\Plates\Engine;

class Plates
{
    public static function render(string $template, array $data = []): string
    {
        $engine = new Engine(__DIR__ . '/../../templates');

        $engine->registerFunction('url', fn(string $path, ?array $query = null) => Env::app_url($path, $query));
        $engine->registerFunction('links', fn() => Links::LIST);

        // -- STYLING -- //
        $engine->registerFunction('color', function (float $note, bool $isComment = false): string {
            $type = '';
            if ($isComment) {
                if ($note < 0) $type = 'danger';
                elseif ($note === 0) $type = 'primary';
                elseif ($note > 0) $type = 'success';
            } else {
                if ($note < 5) $type = 'danger';
                elseif ((5 <= $note) && ($note < 7)) $type = 'warning';
                elseif ($note >= 7) $type = 'success';
            }
            return $type;
        });

        $engine->registerFunction('tag', function (TagTypesEnum $type): string {
            return match ($type) {
                TagTypesEnum::POSITIVE => 'success',
                TagTypesEnum::NEUTRAL => 'primary',
                TagTypesEnum::NEGATIVE => 'danger',
            };
        });

        return $engine->render($template, $data);
    }

    public static function renderError(string $title, ?string $body): string
    {
        return self::render('views/error', [
            'title' => $title,
            'body' => $body,
        ]);
    }
}
