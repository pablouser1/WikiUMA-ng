<section class="hero is-small is-info">
    <div class="hero-body">
        <div class="container has-text-centered">
            <p class="title">Resumen</p>
            <?php if ($stats->total != 0) : ?>
                <div class="columns is-centered is-vcentered is-mobile">
                    <div class="column is-narrow">
                        <p>Media</p>
                        <div class="note has-background-<?= $this->color($stats->med) ?>">
                            <p><?= $this->e($stats->med) ?></p>
                        </div>
                    </div>
                    <div class="column is-narrow">
                        <p>Votos totales: <?= $this->e($stats->total) ?></p>
                        <p>Nota mínima: <?= $this->e($stats->min) ?></p>
                        <p>Nota máxima: <?= $this->e($stats->max) ?></p>
                    </div>
                </div>
                <?php if(count($stats->tags) > 0): ?>
                    <p>Etiqutas más usadas</p>
                    <div class="tags is-centered">
                        <?php foreach ($stats->tags as $tag): ?>
                            <span class="tag is-medium is-<?= $this->tag($tag->type) ?> is-rounded">
                                <?= $this->insert('components/tag', ['tag' => $tag]) ?>
                            </span>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            <?php else : ?>
                <p>No hay ninguna reseña. ¡Se el primero en escribir una!
            <?php endif ?>
        </div>
    </div>
</section>
