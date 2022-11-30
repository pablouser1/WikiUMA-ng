<?php $this->layout('layouts/default', ['title' => 'Resultados']) ?>

<?php $this->start('header') ?>
    <p class="title">Resultados</p>
<?php $this->stop() ?>

<div class="columns is-centered is-vcentered is-multiline">
    <?php foreach($results as $result): ?>
        <div class="column item is-narrow">
            <?=$this->insert('components/card', [
                'name' => $result->name,
                'url' => $this->url('/profesores', ['idnc' => $result->idnc])
            ])?>
        </div>
    <?php endforeach ?>
    <?php if (empty($results)): ?>
        <p class="has-text-centered">¡No hay resultados!</p>
    <?php endif ?>
</div>
