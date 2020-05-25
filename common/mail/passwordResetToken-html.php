<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['v1/password/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Привет <?= Html::encode($user->email) ?>!</p>
    <p>Для восстановления пароля перейдите по ссылке:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
