Hola <?= $this->e($user->first_name) ?>,

Ha llegado un informe a WikiUMA al usuario <?= $this->e($report->review->username) ?>.

Motivo: <?= $report->message ?>
