<?php
$size ??= 'small';
$color = isset($withColor) && $withColor ? $this->color($value) : 'primary'
?>

<div class="control">
    <div class="tags has-addons are-<?= $this->e($size) ?>">
        <span class="tag is-dark"><?= $this->e($title) ?></span>
        <span class="tag is-<?= $this->e($color) ?>"><?= $this->e($value) ?></span>
    </div>
</div>
