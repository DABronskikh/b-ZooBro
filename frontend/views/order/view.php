<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'pet_id',
            //'price_id',

            [
                'attribute' => 'price_id',
                'value' => function ($data) {
                    return "{$data->price->id} | {$data->price->cost} | {$data->price->title}";
                },
            ],
            [
                'attribute' => 'size',
                'value' => function ($data) {
                    return "{$data->getSize()[$data->size]}";
                },
            ],
//            'size',
            //'status_id',
            [
                'attribute' => 'status_id',
                'value' => function ($data) {
                    return "{$data->status->id} | {$data->status->title}";
                },
            ],

            'address',
            'date_create',
            'date_delivery',
            'time_delivery',
            'user_id',
            'cost',
            'phone',
            'comment',
        ],
    ]) ?>


</div>
