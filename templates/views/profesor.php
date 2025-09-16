<?php $this->layout('layouts/default', [
    'title' => $profesor->nombre,
    'withReviews' => true,
    'withCaptcha' => true,
])
?>

<?php $this->insert('partials/hero', ['title' => $profesor->nombre]) ?>

<section class="section">
    <div class="container">
        <div class="block">
            <?php if ($reviews->isEmpty()): ?>
                <?php $this->insert('partials/reviews-empty') ?>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                    <?php $this->insert('partials/review', ['review' => $review, 'voting' => true, 'controls' => true]) ?>
                <?php endforeach ?>
            <?php endif ?>
        </div>
        <div class="block">
            <?php $this->insert('partials/review-new', ['tags' => $tags, 'target' => $profesor->idnc, 'type' => \App\Enums\ReviewTypesEnum::TEACHER]) ?>
        </div>
    </div>
</section>
