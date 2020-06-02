<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->field($model, 'price_id')->dropDownList($price, ['prompt' => 'Выберите товар',]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'size')->dropDownList($size, ['prompt' => 'Выберите размер',]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status_id')->dropDownList($status) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'user_id')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'cost')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'phone')?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'date_delivery')->textInput(['type' => 'date']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'time_delivery')->textInput(['type' => 'time']) ?>
        </div>
    </div>

    <?//= $form->field($model, 'pet_id')->textInput() ?>
    <?//= $form->field($model, 'price_id')->textInput() ?>
    <?//= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>
    <?//= $form->field($model, 'status_id')->textInput() ?>
    <?//= $form->field($model, 'date_create')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'comment')->textInput(['maxlength' => true])->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
