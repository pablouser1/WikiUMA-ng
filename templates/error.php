<?php $this->layout('layouts/hero', ['title' => 'Error']) ?>

<p class="title">Error <?=$this->e($code)?></p>
<p><?=$this->e($body)?></p>
