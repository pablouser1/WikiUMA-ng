<?php $this->layout('layouts/default', [
    'title' => $profesor->nombre,
    'withReviews' => true,
    'withCaptcha' => true,
])
?>

<?php $this->insert('partials/hero', ['title' => $profesor->nombre]) ?>

<section class="section">
    <div class="container">
        <?php $this->insert('partials/reviews', [
            'reviews' => $reviews,
            'tags' => $tags,
            'target' => $profesor->idnc,
            'type' => \App\Enums\ReviewTypesEnum::TEACHER,
        ]) ?>
    </div>
</section>
