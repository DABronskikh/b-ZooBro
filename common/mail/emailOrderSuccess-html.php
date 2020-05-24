<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/** @var TYPE_NAME $password */

?>
<div class="verify-email">
    <p>Привет <?= Html::encode($user->email) ?>!</p>
    <p>Вы успешно создали заказ Zoobro №<?= $order->id ?>!</p>
</div>