<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \App\Models\Legend $legend
 * @var \App\Dto\StatsData $stats
 */
?>

<?php $this->layout('layouts/default', [
    'title' => $legend->full_name,
    'uri' => $uri,
    'withReviews' => true,
]) ?>

<section class="hero is-small has-text-centered">
    <div class="hero-body">
        <p class="title"><?= $this->e($legend->full_name) ?></p>
        <?php if ($stats->total > 0): ?>
            <?php $this->insert('partials/stats/index', ['stats' => $stats]) ?>
        <?php endif ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php $this->insert('partials/reviews/index', [
            'reviews' => $reviews,
            'uri' => $uri,
            'query' => $query,
            'from' => [
                'target' => $legend->id,
                'type' => \App\Enums\ReviewTypesEnum::LEGEND,
            ],
        ]) ?>
    </div>
</section>
