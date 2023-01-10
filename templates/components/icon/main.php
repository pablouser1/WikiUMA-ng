<?php if(isset($text)): ?>
    <span class="icon-text">
        <?php $this->insert('components/icon/common', ['icon' => $icon])?>
	    <span><?=$this->e($text)?></span>
    </span>
<?php else: ?>
    <?php $this->insert('components/icon/common', ['icon' => $icon])?>
<?php endif ?>
