<div class="box">
    <p class="title has-text-centered">Escribe tu opinión</p>
    <form action="<?= $this->url('/reviews') ?>" method="POST">
        <input name="target" value="<?= $this->e($target) ?>" type="hidden" hidden readonly />
        <input name="type" value="<?= $this->e($type->value) ?>" type="hidden" hidden readonly />
        <div class="field">
            <label class="label">
                <span class="icon-text">
                    <span class="icon">
                        <?php $this->insert('partials/icon', ['icon' => 'empty-page']) ?>
                    </span>
                    <span>Opinión</span>
                </span>
            </label>
            <div class="control">
                <textarea name="message" class="textarea" maxlength="<?= $this->e(\App\Models\Review::MESSAGE_MAX_LENGTH) ?>" required></textarea>
            </div>
            <p class="help">Pssst... Puedes usar Markdown.</p>
        </div>
        <div class="field">
            <label class="label">
                <span class="icon-text">
                    <span class="icon">
                        <?php $this->insert('partials/icon', ['icon' => 'user']) ?>
                    </span>
                    <span>Nombre de usuario (opcional)</span>
                </span>
            </label>
            <div class="control">
                <input name="username" class="input" type="text" autocomplete="off" maxlength="<?= $this->e(\App\Models\Review::USERNAME_MAX_LENGTH) ?>" />
            </div>
        </div>
        <div class="field">
            <label class="label">
                <span class="icon-text">
                    <span class="icon">
                        <?php $this->insert('partials/icon', ['icon' => 'emoji']) ?>
                    </span>
                    <span>Valoración (sobre 10)</span>
                </span>
            </label>
            <div class="control">
                <input name="note" class="input" type="number" min="0" max="10" step=".01" required
                    placeholder="Escribe tu valoración del 0 al 10" />
            </div>
        </div>
        <div class="field">
            <altcha-widget challengeurl="<?= $this->url('/challenge') ?>"></altcha-widget>
        </div>
        <div class="field">
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        <label class="checkbox">
                            <input name="accepted" type="checkbox" required>
                            He leído y acepto los <a target="_blank" href="<?= $this->url('/legal') ?>">términos de uso</a>
                        </label>
                    </div>
                </div>
                <div class="level-right">
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
            </nav>
        </div>
    </form>
</div>
