<?php
$color = $withColor ? $this->color($value) : 'primary'
?>

<div class="control">
    <div class="tags has-addons">
        <span class="tag is-dark"><?= $this->e($title) ?></span>
        <span class="tag is-<?= $this->e($color) ?>"><?= $this->e($value) ?></span>
    </div>
</div>
