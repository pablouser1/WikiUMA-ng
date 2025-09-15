<?php $this->layout('layouts/default', [
    'title' => $profesor->nombre,
    'withReviews' => true,
])
?>

<?php $this->insert('partials/hero', ['title' => $profesor->nombre]) ?>

<section class="section">
    <?php if($reviews->isNotEmpty()): ?>
        <?php foreach ($reviews as $review): ?>
            <?php $this->insert('partials/review', ['review' => $review, 'voting' => true, 'controls' => true]) ?>
        <?php endforeach ?>
    <?php endif ?>
</section>
