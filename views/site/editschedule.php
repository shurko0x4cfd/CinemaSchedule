<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Edit or create schedule items';
?>

<div class="site-contact">
    <h1>Edit schedule</h1>

    <p> You can edit any schedule item, remove or create a new one
    </p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'editschedule', 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form
                ->field($model, 'list')
                ->dropdownList($model->session_list_array,  ['options' => [$model->list => ['Selected' => true]]])->label('Session id'); ?>

            <?= $form
                ->field($model, 'film')
                ->dropdownList($model->film_list_array,  ['options' => [$model->film => ['Selected' => true]]])->label('Film'); ?>

            <div class="text-danger font-weight-bold">
                <?= $model->too_near; ?>
            </div>

            <?= $form->field($model, 'datetime')->textInput()->label('Date & time as yyyy-mm-dd hh:mm:ss'); ?>

            <?= $form->field($model, 'price')->textInput(['type' => 'number'])->label('Price'); ?>

            <?= $form->field($model, 'chckbox')->checkbox(['uncheck' => 'uncheck'])->label('Remove it'); ?>

            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']); ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>


</div>