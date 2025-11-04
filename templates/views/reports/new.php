<?php $this->layout('layouts/default', [
    'title' => 'Nuevo informe a opinión de ' . $this->e($review->username),
    'uri' => $uri,
    'withMaxChars' => true,
    'withReviews' => true,
    'withCaptcha' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Nuevo informe a opinión de ' . $this->e($review->username),
])
?>

<section class="section">
    <div class="container">
        <?php $this->insert('partials/reviews/single', ['review' => $review]) ?>
        <div class="box">
            <form action="<?= $this->url('/reviews/' . $review->id . '/report') ?>" method="POST">
                <div class="field">
                    <label class="label">
                        <span class="icon-text">
                            <span class="icon">
                                <?= icon('fa7-solid:pencil') ?>
                            </span>
                            <span>Informe</span>
                        </span>
                    </label>
                    <div class="control">
                        <textarea name="message" class="textarea" maxlength="<?= $this->e(\App\Models\Report::MESSAGE_MAX_LENGTH) ?>" required></textarea>
                    </div>
                    <p class="help">Pssst... Puedes usar Markdown.</p>
                </div>
                <div class="field">
                    <label class="label">
                        <span class="icon-text">
                            <span class="icon">
                                <?= icon('fa7-solid:envelope') ?>
                            </span>
                            <span>Correo electrónico (opcional)</span>
                        </span>
                    </label>
                    <div class="control">
                        <input name="email" class="input" type="email" autocomplete="off" maxlength="<?= $this->e(\App\Models\Report::EMAIL_MAX_LENGTH) ?>" />
                    </div>
                    <p class="help">Lo usamos para mantenerte informad@ acerca de tu informe.</p>
                </div>
                <div class="field">
                    <?php $this->insert('partials/captcha') ?>
                </div>
                <div class="field">
                    <nav class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <label class="checkbox">
                                    <input name="accepted" type="checkbox" required>
                                    He leído y acepto los <a href="<?= $this->url('/legal') ?>">términos de uso</a>
                                </label>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="control">
                                <button type="submit" class="button is-success">
                                    <span class="icon-text">
                                        <span class="icon">
                                            <?= icon('fa7-solid:paper-plane') ?>
                                        </span>
                                        <span>Enviar</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </nav>
                </div>
            </form>
        </div>
    </div>
</section>
