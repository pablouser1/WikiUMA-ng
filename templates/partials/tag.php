<?php if ($tag->icon): ?>
    <span class="icon is-small">
        <?= $this->e($tag->icon)  ?>
    </span>
<?php endif ?>
<span><?= $this->e($tag->name) ?></span>
