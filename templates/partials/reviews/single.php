<?php
$isAdmin ??= false;
$linkToOriginal ??= false;
?>

<section class="section">
    <nav class="level">
        <div class="level-left">
            <div class="level-item">
                <div class="note has-background-<?= $this->color($review->note) ?>">
                    <p><?= $this->e($review->note) ?></p>
                </div>
            </div>
            <div class="level-item">
                <div>
                    <p class="is-size-6" style="text-overflow: ellipsis;">
                        <strong>
                            <?php if ($review->accepted_report !== null): ?>
                                <span class="tag is-danger">No disponible</span>
                            <?php endif ?>
                            <?php if ($review->accepted_report === null || $isAdmin): ?>
                                <?= $this->e($review->username) ?>
                            <?php endif ?>
                        </strong>
                    </p>
                    <p class="heading">
                        <small><?= $this->e($review->created_at) ?></small>
                    </p>
                </div>
            </div>
        </div>
        <div class="level-right">
            <div class="level-item">
                <div class="buttons">
                    <?php if ($review->accepted_report === null): ?>
                        <a class="button is-small is-rounded is-link" href="<?= $this->url('/reviews/' . $review->id) ?>">
                            <span class="icon">
                                <?= icon('fa7-solid:link') ?>
                            </span>
                        </a>
                        <a class="button is-small is-rounded is-danger"
                            href="<?= $this->url('/reviews/' . $review->id . '/report') ?>">
                            <span class="icon">
                                <?= icon('fa7-solid:flag') ?>
                            </span>
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </nav>
    <div class="content pl-2 mb-0">
        <?php if ($review->accepted_report !== null && !$isAdmin): ?>
            <p>
                <i>Este comentario ha sido eliminado por la administración.</i>
            </p>
            <?php if ($review->accepted_report->reason !== null): ?>
                <p><b>Motivo</b>: <?= $this->e($review->accepted_report->reason) ?></p>
            <?php endif ?>
        <?php else: ?>
            <div style="white-space: pre-wrap;"><?= $review->message ?></div>
        <?php endif ?>
    </div>
    <nav class="level mt-1">
        <div class="level-left">
            <p class="level-item">
                <span class="icon" style="color: #e25555;">&#9829;</span>
                <span><?= $this->e($review->votes) ?></span>
            </p>
            <?php if ($review->accepted_report === null): ?>
                <div class="level-item">
                    <nav class="breadcrumb has-bullet-separator is-small" aria-label="breadcrumbs">
                        <ul>
                            <li>
                                <a
                                    href="<?= $this->url('/reviews/' . $review->id . '/like', ['back' => $this->pathWithQuery($uri)]) ?>">
                                    Me gusta
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?= $this->url('/reviews/' . $review->id . '/dislike', ['back' => $this->pathWithQuery($uri)]) ?>">
                                    No me gusta
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            <?php endif ?>
        </div>
        <div class="level-right">
            <?php if ($linkToOriginal): ?>
                <p class="level-item">
                    <a class="button is-small is-rounded is-primary"
                        href="<?= $this->url('/redirect', ['target' => $review->target, 'type' => $review->type]) ?>">
                        Ver contexto original
                    </a>
                </p>
            <?php endif ?>
        </div>
    </nav>
</section>
