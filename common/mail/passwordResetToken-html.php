<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['reset-password', 'token' => $user->password_reset_token]);
$resetLink = "https://zoobro.ru/?reset-password={$user->password_reset_token}";
?>
<div class="password-reset">
    <p>Привет <?= Html::encode($user->email) ?>!</p>
    <p>Для восстановления пароля перейдите по <?= Html::a(Html::encode('ссылке'), $resetLink) ?></p>
</div>
