<article class="media">
    <figure class="media-left">
        <div class="note has-background-<?= $this->color($review->note) ?>">
            <p><?= $this->e($review->note) ?></p>
        </div>
    </figure>
    <div class="media-content">
        <div class="content">
            <p>
                <strong><?= $this->e($review->username) ?></strong>
                <br>
                <span style="white-space:pre-wrap;"><?= $this->e($review->message) ?></span>
            </p>
            <?php if (isset($review->tags) && count($review->tags) > 0): ?>
                <div class="tags">
                    <?php foreach ($review->tags as $tag): ?>
                        <span class="tag is-rounded is-<?= $this->tag($tag->type) ?>">
                            <?php $this->insert('partials/tag', ['tag' => $tag]) ?>
                        </span>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
        <nav class="level is-mobile">
            <div class="level-left">
                <p class="level-item">
                    <span class="icon" style="color: #e25555;">&#9829;</span>
                    <span><?= $this->e($review->votes) ?></span>
                </p>
                <?php if (isset($voting) && $voting): ?>
                    <div class="level-item">
                        <nav class="breadcrumb has-bullet-separator is-small" aria-label="breadcrumbs">
                            <ul>
                                <li><a href="<?= $this->url('/reviews/' . $review->id . '/like') ?>">Me gusta</a></li>
                                <li><a href="<?= $this->url('/reviews/' . $review->id . '/dislike') ?>">No me gusta</a></li>
                            </ul>
                        </nav>
                    </div>
                <?php endif ?>
            </div>
            <?php if (isset($controls) && $controls): ?>
                <div class="level-right">
                    <a href="<?= $this->url('/reviews/' . $review->id . '/report') ?>" class="level-item is-size-7 has-text-danger">
                        <?php $this->insert('partials/icon', ['icon' => 'white-flag', 'text' => 'Reportar']) ?>
                    </a>
                </div>
            <?php endif ?>
        </nav>
    </div>
</article>
