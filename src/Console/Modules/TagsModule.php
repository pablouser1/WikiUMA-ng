<?php

namespace App\Console\Modules;

use App\Console\Base;
use App\Console\IModule;
use App\Enums\ReviewTypesEnum;
use App\Enums\TagTypesEnum;
use App\Models\Tag;

class TagsModule extends Base implements IModule
{
    public function entrypoint(): void
    {
        $this->cli->bold()->out("Tags");
        $this->radioSection();
    }

    public function list(): void
    {
        $tags = Tag::all();

        foreach ($tags as $i => $tag) {
            $this->cli->inline($i + 1);
            $this->cli->inline(". ");
            $this->cli->out($tag->name);
        }
    }

    public function add(): void
    {
        // Name
        $in = $this->cli->input("Choose a name:");
        $name = $in->prompt();

        // Type
        $type = $this->radioEnum(TagTypesEnum::cases());

        // Review type
        $for = $this->radioEnum(ReviewTypesEnum::cases());

        // Emoji
        $in = $this->cli->input("Choose an emoji (leave empty for none):");
        $emoji = $in->prompt();

        $tag = new Tag([
            'name' => $name,
            'type' => TagTypesEnum::tryFrom($type),
            'icon' => !empty($emoji) ? $emoji : null,
            'for' => ReviewTypesEnum::tryFrom($for),
        ]);

        $ok = $tag->save();
        if (!$ok) {
            $this->cli->backgroundRed()->error("Could not create tag!");
            return;
        }

        $this->cli->backgroundGreen()->out("Tag created!");
    }

    public function delete(): void
    {
        $tags = Tag::all();
        $index = $this->radioModel($tags, "name");
        $tag = $tags[$index];
        $ok = $tag->delete();
        if (!$ok) {
            $this->cli->backgroundRed()->error("Could not delete tag!");
        }

        $this->cli->backgroundGreen()->out("Deleted!");
    }
}
