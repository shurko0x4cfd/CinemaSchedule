<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Edit or create schedule items';
?>

<div class="d-flex flex-row flex-wrap">
    <div class="d-flex flex-column col-sm-5 col-12">

        <h1>Edit schedule</h1>

        <p> You can edit any schedule item, remove or create a new one </p>

        <?php $form = ActiveForm::begin(['id' => 'editschedule', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form
            ->field($model, 'list')
            ->dropdownList($model->session_list_array,  ['options' => [$model->list => ['Selected' => true]]])->label('Session id'); ?>

        <?= $form
            ->field($model, 'film')
            ->dropdownList($model->film_list_array,  ['options' => [$model->film => ['Selected' => true]]])->label('Film'); ?>

        <div class="text-danger text-center fw-bold">
            <?= $model->too_near; ?>
        </div>

        <?= $form->field($model, 'datetime')->textInput()->label('Date & time as yyyy-mm-dd hh:mm:ss'); ?>

        <?= $form->field($model, 'price')->textInput(['type' => 'number'])->label('Price'); ?>

        <?= $form->field($model, 'checkbox_remove')->checkbox(['uncheck' => 'uncheck'])->label('Remove it'); ?>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="d-flex flex-column col-1">&nbsp;</div>

    <div class="d-flex flex-column rounded-3 col-sm-6 col-12 bg-secondary border border- border-dark text-light text-center">
        Place for list
    </div>
</div>
