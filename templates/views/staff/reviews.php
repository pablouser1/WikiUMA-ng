<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var array $query
 * @var \Illuminate\Support\Collection<\App\Models\Review> $reviews
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Valoraciones',
    'uri' => $uri,
    'withReviews' => true,
    'withForm' => true,
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
