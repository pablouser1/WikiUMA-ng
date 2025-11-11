<div class="card">
    <div class="card-content">
        <nav class="level">
            <div class="level-left">
                <div class="level-item">
                    <div>
                        <p class="title is-4">Informe <?= $this->e($report->uuid) ?></p>
                        <p class="subtitle is-6">
                           <?= $this->e($report->email === null ? 'No se ha especificado correo electrónico' : $report->email) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <a href="<?= $this->url('/redirect', ['target' => $report->review->target, 'type' => $report->review->type]) ?>" target="_blank">Consultar reseñado</a>
                </div>
            </div>
        </nav>
        <?php $this->insert('partials/reviews/single', [
            'review' => $report->review,
            'isAdmin' => true,
            'linkOriginal' => true,
            'uri' => $uri,
        ]) ?>

        <p class="title is-4">Informe</p>
        <div class="content">
            <?= $report->message ?>
        </div>
        <hr />
        <form action="<?= $this->url('/staff/reports/' . $report->id . '/status') ?>" method="POST">
            <div class="field">
                <label class="label">Estado</label>
                <div class="control">
                    <div class="select">
                        <select name="status" required>
                            <?php foreach (\App\Enums\ReportStatusEnum::cases() as $status): ?>
                                <option <?= $report->status === $status ? 'selected' : '' ?> value="<?= $this->e($status->value) ?>"><?= $this->e($status->displayName()) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Razón (opcional)</label>
                <div class="control">
                    <input class="input" type="text" name="reason" maxlength="<?= $this->e(\App\Models\Report::REASON_MAX_LENGTH) ?>">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
