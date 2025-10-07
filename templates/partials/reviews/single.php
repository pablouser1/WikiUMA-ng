<article class="media">
    <figure class="media-left">
        <div class="note has-background-<?= $this->color($review->note) ?>">
            <p><?= $this->e($review->note) ?></p>
        </div>
    </figure>
    <div class="media-content">
        <div class="content">
            <p>
                <strong>
                    <?php if ($review->accepted_report === null): ?>
                        <?= $this->e($review->username) ?>
                    <?php else: ?>
                        <span class="tag is-danger">No disponible</span>
                    <?php endif ?>
                </strong>
                <small><?= $this->e($review->created_at) ?></small>
            </p>
            <?php if ($review->accepted_report !== null): ?>
                <p>
                    <i>Este comentario ha sido eliminado por la administración.</i>
                </p>
                <?php if ($review->accepted_report->reason !== null): ?>
                    <p><b>Motivo</b>: <?= $this->e($review->accepted_report->reason) ?></p>
                <?php endif ?>
            <?php else: ?>
                <?= $review->message ?>
            <?php endif ?>
        </div>
        <nav class="level is-mobile">
            <div class="level-left">
                <p class="level-item">
                    <span class="icon" style="color: #e25555;">&#9829;</span>
                    <span><?= $this->e($review->votes) ?></span>
                </p>
                <?php if (isset($voting) && $voting && $review->accepted_report === null): ?>
                    <div class="level-item">
                        <nav class="breadcrumb has-bullet-separator is-small" aria-label="breadcrumbs">
                            <ul>
                                <li><a href="<?= $this->url('/reviews/' . $review->id . '/like', ['back' => $this->pathWithQuery($uri)]) ?>">Me gusta</a></li>
                                <li><a href="<?= $this->url('/reviews/' . $review->id . '/dislike', ['back' => $this->pathWithQuery($uri)]) ?>">No me gusta</a></li>
                            </ul>
                        </nav>
                    </div>
                <?php endif ?>
            </div>
            <?php if (isset($controls) && $controls && $review->accepted_report === null): ?>
                <div class="level-right">
                    <div class="level-item">
                        <div class="buttons">
                            <a class="button is-small is-rounded is-link" href="<?= $this->url('/reviews/' . $review->id) ?>">
                                <span class="icon">
                                    <?php $this->insert('partials/icon', ['icon' => 'link', 'width' => 24, 'height' => 24]) ?>
                                </span>
                            </a>
                            <a class="button is-small is-rounded is-danger" href="<?= $this->url('/reviews/' . $review->id . '/report') ?>">
                                <span class="icon">
                                    <?php $this->insert('partials/icon', ['icon' => 'white-flag', 'width' => 24, 'height' => 24]) ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </nav>
    </div>
</article>
