<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\filters\order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">

        <div class="col-sm-3">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->field($model, 'price_id')->dropDownList($price, ['prompt' => 'Выберите товар',]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'size')->dropDownList($size, ['prompt' => 'Выберите размер',]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status_id')->dropDownList($status, ['prompt' => 'Выберите статус',]) ?>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-5">
            <?php echo $form->field($model, 'date_create')->textInput(['type' => 'date']) ?>
        </div>
        <div class="col-sm-5">
            <?php echo $form->field($model, 'date_delivery')->textInput(['type' => 'date']) ?>
        </div>
        <div class="col-sm-2">
            <?php echo $form->field($model, 'time_delivery')->textInput(['type' => 'time']) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->field($model, 'comment')->textarea() ?>

        </div>
    </div>

    <? //= $form->field($model, 'pet_id') ?>
    <?php // $form->field($model, 'price_id') ?>
    <?php // echo $form->field($model, 'address') ?>
    <?php // echo $form->field($model, 'user_id') ?>
    <?php // echo $form->field($model, 'cost') ?>

    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Очистить', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
