<article class="media">
    <figure class="media-left">
        <div class="note has-background-<?= $this->color($note) ?>">
            <p><?= $this->e($note) ?></p>
        </div>
    </figure>
    <div class="media-content">
        <div class="content">
            <p>
                <strong><?= $this->e($username) ?></strong>
                <br>
                <span style="white-space:pre-wrap;"><?= $this->e($message) ?></span>
            </p>
            <?php if(isset($tags) && count($tags) > 0): ?>
                <div class="tags">
                    <?php foreach($tags as $tag): ?>
                        <span class="tag is-rounded is-<?= $this->tag($tag->type) ?>">
                            <?= $this->insert('components/tag', ['tag' => $tag]) ?>
                        </span>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
        <nav class="level is-mobile">
            <div class="level-left">
                <p class="level-item">
                    <span class="icon" style="color: #e25555;">&#9829;</span>
                    <span><?= $this->e($votes) ?></span>
                </p>
                <?php if (isset($voting)): ?>
                    <div class="level-item">
                        <nav class="breadcrumb has-bullet-separator is-small" aria-label="breadcrumbs">
                            <ul>
                                <li><a href="<?= $this->url('/reviews/' . $id . '/like', ['back' => $this->current_url(true)]) ?>">Me gusta</a></li>
                                <li><a href="<?= $this->url('/reviews/' . $id . '/dislike', ['back' => $this->current_url(true)]) ?>">No me gusta</a></li>
                            </ul>
                        </nav>
                    </div>
                <?php endif ?>
            </div>
            <?php if (isset($controls)): ?>
                <div class="level-right">
                    <a href="<?= $this->url('/reports/new/' . $id) ?>" class="level-item is-size-7 has-text-danger">
                        <?= $this->insert('components/icon/main', ['icon' => 'flag', 'text' => 'Reportar']) ?>
                    </a>
                </div>
            <?php endif ?>
        </nav>
    </div>
</article>
