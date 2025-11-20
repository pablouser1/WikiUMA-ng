<?php $this->layout('layouts/default', [
    'title' => $profesor->nombre,
    'uri' => $uri,
    'withReviews' => true,
]) ?>

<section class="hero is-small has-text-centered">
    <div class="hero-body">
        <p class="title"><?= $this->e($profesor->nombre) ?></p>
        <?php if (isset($profesor->departamentos[0])): ?>
            <span class="tag is-info"><?= $this->e($profesor->departamentos[0][0]->nombre) ?></span>
        <?php endif ?>
        <?php if ($stats->total > 0): ?>
            <?php $this->insert('partials/stats', ['stats' => $stats]) ?>
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
                'target' => $profesor->idnc,
                'type' => \App\Enums\ReviewTypesEnum::TEACHER,
            ],
        ]) ?>
    </div>
</section>
