<label class="label">Palabras más usadas</label>
<div class="field is-grouped is-grouped-multiline is-grouped-centered">
    <?php foreach ($stats->words as $name => $repeats): ?>
        <?php $this->insert('partials/stat', ['title' => $name, 'value' => $repeats]) ?>
    <?php endforeach ?>
</div>

<label class="label">Estadísticas</label>
<div class="field is-grouped is-grouped-multiline is-grouped-centered">
    <?php $this->insert('partials/stat', ['title' => 'Nº de valoraciones', 'value' => $stats->total]) ?>
    <?php $this->insert('partials/stat', ['title' => 'Nota media', 'value' => $stats->avg, 'withColor' => true]) ?>
</div>
<div class="field is-grouped is-grouped-multiline is-grouped-centered">
    <?php $this->insert('partials/stat', ['title' => 'Nota más baja', 'value' => $stats->min, 'withColor' => true]) ?>
    <?php $this->insert('partials/stat', ['title' => 'Nota más alta', 'value' => $stats->max, 'withColor' => true]) ?>
</div>
