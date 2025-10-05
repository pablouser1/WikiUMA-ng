<?php $this->layout('layouts/default', [
    'title' => $profesor->nombre,
    'withReviews' => true,
    'withCaptcha' => true,
])
?>

<section class="hero is-small has-text-centered">
    <div class="hero-body">
        <p class="title"><?=$this->e($profesor->nombre)?></p>
        <?php if ($stats->total > 0): ?>
            <?php $this->insert('partials/stats', ['stats' => $stats]) ?>
        <?php endif ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php $this->insert('partials/reviews/index', [
            'reviews' => $reviews,
            'target' => $profesor->idnc,
            'type' => \App\Enums\ReviewTypesEnum::TEACHER,
            'uri' => $uri,
            'query' => $query,
        ]) ?>
    </div>
</section>
