<?php $this->layout('layouts/default', [
    'title' => 'Panel de control',
    'withReviews' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Panel de control',
])
?>

<section class="section">
    <div class="container">
        <?php $this->insert('partials/reports/index', [
            'reports' => $reports,
            'uri' => $uri,
            'query' => $query,
        ]) ?>
    </div>
</section>
