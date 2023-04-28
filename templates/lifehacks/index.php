<?php $this->layout('layouts/default', ['title' => 'Lifehacks']) ?>

<?php $this->start('header') ?>
<p class="title">Lifehacks de la UMA</p>
<?php $this->stop() ?>

<div class="content">
    <p>Esta es una lista con "tips" para ayudarte a sobrevivir ligeramente mejor en esta universidad</p>
    <ul>
        <?php foreach($this->lifehacks() as $lifehack): ?>
        <li>
            <a href="<?=$this->url("/lifehacks" . $lifehack['endpoint'])?>">
                <?= $this->insert('components/icon/main', ['icon' => $this->e($lifehack['icon']), 'text' => $this->e($lifehack['name'])]) ?>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</div>
