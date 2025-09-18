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
    <?php $this->insert('partials/review-new', ['tags' => $tags ?? null, 'target' => $target, 'type' => $type]) ?>
</div>
