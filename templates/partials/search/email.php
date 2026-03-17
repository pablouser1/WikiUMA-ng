<form method="GET" action="<?= $this->url('/profesores') ?>">
    <label class="label">Buscar por correo electrónico</label>
    <div class="field has-addons has-addons-centered">
        <div class="control">
            <input name="email" type="email" class="input is-rounded" placeholder="Correo electrónico" />
        </div>
        <div class="control">
            <button class="button is-info is-rounded" type="submit">
                <span class="icon">
                    <?= icon('fa7-solid:search') ?>
                </span>
            </button>
        </div>
    </div>
</form>
