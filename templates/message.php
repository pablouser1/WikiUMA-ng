<?php $this->layout('layouts/hero', ['title' => isset($title) ? $title : 'Error']) ?>

<p class="title"><?= isset($title) ? $this->e($title) : 'HTTP ' . $this->e($code) ?></p>
<p><?=$this->e($body)?></p>
