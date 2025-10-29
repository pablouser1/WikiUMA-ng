<form method="GET" action="<?= $this->url('/search') ?>">
    <label class="label">Buscar profesor</label>
    <div class="field has-addons has-addons-centered">
    	<div class="control">
    		<input name="nombre" type="text" class="input is-rounded" placeholder="Nombre" />
    	</div>
    	<div class="control">
    		<input name="apellido_1" type="text" class="input is-rounded" placeholder="1º apellido" />
    	</div>
    	<div class="control">
    		<input name="apellido_2" type="text" class="input is-rounded" placeholder="2º apellido" />
    	</div>
        <div class="control">
            <button class="button is-info is-rounded" type="submit">
                <?php $this->insert('partials/icon', ['icon' => 'search', 'width' => 24, 'height' => 24]) ?>
            </button>
        </div>
    </div>
    <p class="help">Sólo es obligatorio rellenar un campo</p>
</form>
