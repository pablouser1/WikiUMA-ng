<?php $this->layout('layouts/hero', ['title' => $title ? $title : 'Error']) ?>

<p class="title"><?= $title ? $this->e($title) : 'HTTP ' . $this->e($code) ?></p>
<p><?=$this->e($body)?></p>
