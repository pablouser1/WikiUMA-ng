Hola <?= $this->e($user->first_name) ?>,

Ha llegado un informe a WikiUMA al usuario <?= $this->e($report->review->username) ?> con el ID <?= $this->e($report->uuid) ?>.

Motivo: <?= $report->message ?>
