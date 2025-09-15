<?php $this->layout('layouts/default', ['title' => 'Resultados']) ?>

<?php $this->insert('partials/hero', ['title' => 'Resultados']) ?>

<div class="columns is-centered is-vcentered is-multiline">
    <?php foreach($results as $result): ?>
        <div class="column is-narrow">
            <?=$this->insert('partials/card', [
                'name' => $result->name,
                'url' => $this->url('/profesores', ['idnc' => $result->idnc])
            ])?>
        </div>
    <?php endforeach ?>
    <?php if (empty($results)): ?>
        <p class="has-text-centered">¡No hay resultados!</p>
    <?php endif ?>
</div>
