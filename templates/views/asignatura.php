<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var array $query
 * @var \UMA\Models\Asignatura $asignatura
 * @var \App\Models\Review[] $reviews
 * @var \App\Dto\StatsData $stats
 */
?>

<?php $this->layout('layouts/default', [
    'title' => $asignatura->nombre,
    'uri' => $uri,
    'withSearch' => true,
    'withReviews' => true,
]) ?>

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
                                'items' => array_map(fn ($profesor) => (object) [
                                    'name' => $profesor->nombre,
                                    'url' => $this->url('/profesores', ['email' => $this->encrypt($profesor->email)]),
                                ], $grupo->profesores)
                            ]) ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <hr />
        <?php endif ?>
        <div class="block">
            <?php $this->insert('partials/reviews/index', [
                'reviews' => $reviews,
                'uri' => $uri,
                'query' => $query,
                'from' => [
                    'target' => $this->planAsignaturaJoin($plan_id, $asignatura->codAsig),
                    'type' => \App\Enums\ReviewTypesEnum::SUBJECT,
                ],
            ]) ?>
        </div>
    </div>
</section>
