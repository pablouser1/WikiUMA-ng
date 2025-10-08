<?php $this->layout('layouts/default', [
    'title' => 'Valoraciones',
    'withReviews' => true,
    'withMaxChars' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Valoraciones',
])
?>

<section class="section">
    <div class="container">
        <?php $this->insert('partials/reviews/index', [
            'reviews' => $reviews,
            'uri' => $uri,
            'query' => $query,
            'solo' => true,
        ]) ?>
    </div>
</section>
