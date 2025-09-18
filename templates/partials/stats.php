<div class="tags is-centered mt-2">
    <?php foreach ($stats->tags as $tag): ?>
        <?php $this->insert('partials/tag', ['tag' => $tag]) ?>
    <?php endforeach ?>
</div>

<ul>
    <li>Nº de valoraciones: <?= $this->e($stats->total) ?></li>
    <li>Nota media: <?= $this->e($stats->avg) ?></li>
    <li>Nota más baja: <?= $this->e($stats->min) ?></li>
    <li>Nota más alta: <?= $this->e($stats->max) ?></li>
</ul>
