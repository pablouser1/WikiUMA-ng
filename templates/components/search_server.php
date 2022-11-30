<form method="GET" action="<?= $this->url('/search') ?>">
    <div class="field has-addons has-addons-centered">
    	<div class="control">
    		<input name="nombre" type="text" class="input" placeholder="Nombre" />
    	</div>
    	<div class="control">
    		<input name="apellido_1" type="text" class="input" placeholder="Primer apellido" />
    	</div>
    	<div class="control">
    		<input name="apellido_2" type="text" class="input" placeholder="Segundo apellido" />
    	</div>
        <div class="control">
            <button class="button is-info" type="submit">Buscar</button>
        </div>
    </div>
</form>
