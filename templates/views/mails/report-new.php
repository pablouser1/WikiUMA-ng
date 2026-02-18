<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \App\Models\User $user
 * @var \App\Models\Report $report
 */
?>

Hola <?= $this->e($user->first_name) ?>,

Ha llegado un informe a WikiUMA al usuario "<?= $this->e($report->review->username) ?>" con el ID <?= $this->e($report->uuid) ?>.

Motivo: <?= $report->message ?>
