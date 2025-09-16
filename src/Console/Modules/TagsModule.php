<?php
namespace App\Console\Modules;

use App\Console\Base;
use App\Console\IModule;
use App\Enums\TagTypesEnum;
use App\Models\Tag;

class TagsModule extends Base implements IModule {
  public function entrypoint(): void {
    $this->cli->bold()->out("Tags");
    $this->radioSection();
  }

  public function list(): void {
    $tags = Tag::all();

    foreach ($tags as $i => $tag) {
      $this->cli->inline($i + 1);
      $this->cli->inline(". ");
      $this->cli->out($tag->name);
    }
  }

  public function add(): void {
    // Location
    $in = $this->cli->input("Choose a name");
    $name = $in->prompt();

    // Short name
    $type = $this->radioEnum(TagTypesEnum::cases());

    $tag = new Tag([
        'name' => $name,
        'type' => TagTypesEnum::tryFrom($type),
    ]);
    $ok = $tag->save();
    if ($ok) {
      $this->cli->backgroundGreen()->out("Tag created!");
    } else {
      $this->cli->backgroundRed()->error("Could not create tag!");
    }
  }

  public function delete(): void {
    $rooms = Tag::all();
    $index = $this->radioModel($rooms, "name");
    $room = $rooms[$index];
    $ok = $room->delete();
    if ($ok) {
      $this->cli->backgroundGreen()->out("Deleted!");
    } else {
      $this->cli->backgroundRed()->error("Could not delete tag!");
    }
  }
}
