<div class="block">
    <?php $this->insert('partials/reviews/filter', [
        'uri' => $uri,
        'query' => $query,
    ]) ?>
    <?php if ($reviews->isEmpty()): ?>
        <?php $this->insert('partials/reviews/empty') ?>
    <?php else: ?>
        <div class="box">
            <?php foreach ($reviews as $review): ?>
                <?php $this->insert('partials/reviews/single', [
                    'review' => $review,
                    'voting' => true,
                    'controls' => true,
                    'solo' => $solo ?? false,
                    'uri' => $uri,
                ]) ?>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <?php $this->insert('partials/pagination', [
        'uri' => $uri,
        'query' => $query,
        'hasNext' => $reviews->isNotEmpty(),
    ]) ?>
</div>
<div class="block">
    <?php if(isset($from) && !empty($from)): ?>
        <?php $this->insert('partials/reviews/new', [
            'target' => $from['target'],
            'type' => $from['type'],
        ]) ?>
    <?php endif ?>
</div>
