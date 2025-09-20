<div class="block">
    <?php if ($reviews->isEmpty()): ?>
        <?php $this->insert('partials/reviews-empty') ?>
    <?php else: ?>
        <div class="box">
            <?php foreach ($reviews as $review): ?>
                <?php $this->insert('partials/review', ['review' => $review, 'voting' => true, 'controls' => true]) ?>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <?php $this->insert('partials/reviews-pagination', ['uri' => $uri, 'query' => $query, 'hasNext' => $reviews->isNotEmpty()]) ?>
</div>
<div class="block">
    <?php $this->insert('partials/review-new', ['tags' => $tags ?? null, 'target' => $target, 'type' => $type]) ?>
</div>
