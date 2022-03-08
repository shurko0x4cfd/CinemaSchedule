<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;


$this->title = 'Edit or create film items';
/* $this->params['breadcrumbs'][] = $this->title; */
?>

<div class="d-flex flex-row flex-wrap">
    <div class="d-flex flex-column col-sm-5 col-12">

        <h1>Edit films</h1>

        <p> You can edit any film item, remove or create a new one </p>

        <?php $form = ActiveForm::begin(['id' => 'editfilms', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form
            ->field($model, 'list')
            ->dropdownList($model->film_list_array,  ['options' => [$model->list => ['Selected' => true]]]); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]); ?>

        <?= $form->field($model, 'image')->fileInput(); ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]); ?>

        <?= $form->field($model, 'duration')->textInput(['type' => 'number']); ?>

        <?= $form->field($model, 'limits')->textInput(['type' => 'number'])->label('Age restrictions'); ?>

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