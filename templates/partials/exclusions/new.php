<form id="data-form" action="<?= $this->url('/staff/exclusions') ?>" method="POST">
    <div class="field">
        <label class="label">
            <span class="icon-text">
                <span class="icon">
                    <?= icon('fa7-solid:envelope') ?>
                </span>
                <span>Correo electrónico</span>
            </span>
        </label>
        <div class="control">
            <input name="email" class="input" type="email" required />
        </div>
    </div>
    <div class="control">
        <button id="data-submit" type="submit" class="button is-success">
            <span class="icon-text">
                <span class="icon">
                    <?= icon('fa7-solid:paper-plane') ?>
                </span>
                <span>Enviar</span>
            </span>
        </button>
    </div>
</form>
