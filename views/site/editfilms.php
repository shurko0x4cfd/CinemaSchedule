<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;


$this->title = 'Edit or create film items';
/* $this->params['breadcrumbs'][] = $this->title; */
?>

<div class="site-contact">
    <h1>Edit films</h1>

    <p> You can edit any film item, remove or create a new one </p>

    <div class="row">
        <div class="col-lg-5">

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
    </div>
</div>