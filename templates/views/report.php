<?php $this->layout('layouts/default', [
    'title' => 'Nueva queja a opinión de ' . $this->e($review->username),
    'withReviews' => true,
    'withCaptcha' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Nueva queja a opinión de ' . $this->e($review->username),
])
?>

<section class="section">
    <div class="container">
        <?php $this->insert('partials/review', ['review' => $review]) ?>
        <div class="box">
            <form action="<?= $this->url('/reviews/' . $review->id . '/report') ?>" method="POST">
                <div class="field">
                    <label class="label">
                        <span class="icon-text">
                            <span class="icon">
                                <?php $this->insert('partials/icon', ['icon' => 'empty-page']) ?>
                            </span>
                            <span>Mensaje</span>
                        </span>
                    </label>
                    <div class="control">
                        <textarea name="message" class="textarea" required></textarea>
                    </div>
                    <p class="help">Pssst... Puedes usar Markdown.</p>
                </div>
                <div class="field">
                    <label class="label">
                        <span class="icon-text">
                            <span class="icon">
                                <?php $this->insert('partials/icon', ['icon' => 'user']) ?>
                            </span>
                            <span>Correo electrónico (opcional)</span>
                        </span>
                    </label>
                    <div class="control">
                        <input name="email" class="input" type="email" autocomplete="off" />
                    </div>
                    <p class="help">Lo usamos para contactarte en caso de necesitar información adicional.</p>
                </div>
                <div class="field">
                    <label class="checkbox">
                        <input name="accepted" type="checkbox" required>
                        He leído y acepto los <a href="<?= $this->url('/legal') ?>">términos de uso</a>
                    </label>
                </div>
                <div class="field">
                    <altcha-widget challengeurl="<?= $this->url('/challenge') ?>"></altcha-widget>
                </div>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-success">
                            <span class="icon-text">
                                <span class="icon">
                                    <?php $this->insert('partials/icon', ['icon' => 'send']) ?>
                                </span>
                                <span>Enviar</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
