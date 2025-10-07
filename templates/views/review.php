<?php $this->layout('layouts/hero', [
    'title' => "Valoración de {$review->username}",
    'withReviews' => true,
]) ?>

<div class="box">
    <?php $this->insert('partials/reviews/single', [
        'review' => $review,
        'voting' => true,
        'controls' => true,
        'uri' => $uri,
    ]) ?>
    <a class="button is-link" href="<?= $this->url('/redirect', ['target' => $review->target, 'type' => $review->type]) ?>">Ver en contexto original</a>
</div>
