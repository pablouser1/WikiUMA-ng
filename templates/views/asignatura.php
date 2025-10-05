<?php $this->layout('layouts/default', [
    'title' => $asignatura->nombre,
    'withSearch' => true,
    'withReviews' => true,
    'withCaptcha' => true,
])
?>

<section class="hero is-small has-text-centered">
    <div class="hero-body">
        <p class="title"><?= $this->e($asignatura->nombre) ?></p>
        <p class="subtitle"><?= $this->e($asignatura->curso) ?> año - <?= $this->e($asignatura->cuatrimestre) ?> cuatrimestre</p>
        <?php if ($stats->total > 0): ?>
            <?php $this->insert('partials/stats', ['stats' => $stats]) ?>
        <?php endif ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (is_array($asignatura->grupos) && count($asignatura->grupos) > 0): ?>
            <div class="block">
                <p class="title has-text-centered">Profesores</p>
                <?php $this->insert('partials/search-client') ?>
                <div class="columns is-centered is-vcentered is-multiline">
                    <?php foreach ($asignatura->grupos as $grupo): ?>
                        <div class="column is-narrow">
                            <?php $this->insert('partials/panel', [
                                'title' => "Grupo {$grupo->nombre}",
                                'items' => array_map(fn(object $profesor) => (object) [
                                    'name' => $profesor->nombre,
                                    'url' => $this->url('/profesores', ['email' => $profesor->email]),
                                ], $grupo->profesores)
                            ]);
                            ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endif ?>
        <div class="block">
            <?php $this->insert('partials/reviews/index', [
                'reviews' => $reviews,
                'tags' => $tags,
                'target' => $this->planAsignaturaJoin($plan_id, $asignatura->cod_asig),
                'type' => \App\Enums\ReviewTypesEnum::SUBJECT,
                'uri' => $uri,
                'query' => $query,
            ]) ?>
        </div>
    </div>
</section>
