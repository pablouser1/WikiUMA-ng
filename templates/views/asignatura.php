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
            <?php $this->insert('partials/stats/index', ['stats' => $stats]) ?>
        <?php endif ?>
    </div>
</section>

<section class="section">
    <div class="container">
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
