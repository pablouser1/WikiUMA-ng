<script defer src="<?=$this->url('/js/search.js')?>"></script>

<div class="field mb-4">
	<div class="control has-icons-left">
		<input id="search" type="text" class="input is-rounded" placeholder="Filtrar" />
        <span class="icon is-small is-left">
            <?= $this->insert('components/icon', ['icon' => 'search']) ?>
        </span>
	</div>
</div>
