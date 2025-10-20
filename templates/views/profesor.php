<?php $this->layout('layouts/default', [
    'title' => $profesor->nombre,
    'uri' => $uri,
    'withMaxChars' => true,
    'withReviews' => true,
    'withCaptcha' => true,
]) ?>

<section class="hero is-small has-text-centered">
    <div class="hero-body">
        <p class="title"><?= $this->e($profesor->nombre) ?></p>
        <div class="tags is-centered">
            <?php foreach ($profesor->departamentos as $departamento): ?>
                <span class="tag is-info"><?= $this->e($departamento[0]->nombre) ?></span>
            <?php endforeach ?>
        </div>
        <?php if (isset($profesor->departamentos[0])): ?>
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
