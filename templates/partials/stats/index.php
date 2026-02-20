<label class="label">Estadísticas</label>
<div class="field is-grouped is-grouped-multiline is-grouped-centered">
    <?php $this->insert('partials/stats/single', ['title' => 'Nº de valoraciones', 'value' => $stats->total]) ?>
    <?php $this->insert('partials/stats/single', ['title' => 'Nota media', 'value' => $stats->avg, 'withColor' => true]) ?>
</div>
<div class="field is-grouped is-grouped-multiline is-grouped-centered">
    <?php $this->insert('partials/stats/single', ['title' => 'Nota más baja', 'value' => $stats->min, 'withColor' => true]) ?>
    <?php $this->insert('partials/stats/single', ['title' => 'Nota más alta', 'value' => $stats->max, 'withColor' => true]) ?>
</div>
