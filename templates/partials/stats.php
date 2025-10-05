<div class="tags is-centered mt-2">
    <?php foreach ($stats->tags as $tag): ?>
        <?php $this->insert('partials/tag', ['tag' => $tag]) ?>
    <?php endforeach ?>
</div>

<div class="field is-grouped is-grouped-multiline is-grouped-centered">
    <?php $this->insert('partials/stat', ['title' => 'Nº de valoraciones', 'value' => $stats->total]) ?>
    <?php $this->insert('partials/stat', ['title' => 'Nota media', 'value' => $stats->avg, 'withColor' => true]) ?>
</div>
<div class="field is-grouped is-grouped-multiline is-grouped-centered">
    <?php $this->insert('partials/stat', ['title' => 'Nota más baja', 'value' => $stats->min, 'withColor' => true]) ?>
    <?php $this->insert('partials/stat', ['title' => 'Nota más alta', 'value' => $stats->max, 'withColor' => true]) ?>
</div>
