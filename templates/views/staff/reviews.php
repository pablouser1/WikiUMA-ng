<?php $this->layout('layouts/default', [
    'title' => 'Valoraciones',
    'uri' => $uri,
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
            'linkToOriginal' => true,
        ]) ?>
    </div>
</section>
