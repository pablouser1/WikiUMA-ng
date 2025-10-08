<?php $this->layout('layouts/hero', [
    'title' => "Valoración de {$review->username}",
    'withReviews' => true,
]) ?>

<div class="box">
    <?php $this->insert('partials/reviews/single', [
        'review' => $review,
        'voting' => true,
        'controls' => true,
        'solo' => true,
        'uri' => $uri,
    ]) ?>
</div>
