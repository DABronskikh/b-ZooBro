<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/** @var TYPE_NAME $password */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Привет <?= Html::encode($user->email) ?>!</p>
    <p>Вы успешно зарегистрировались на сайте Zoobro!</p>
    <p>Ваш пароль: <b><?= $password?></b></p>
    <p>Дело осталось за малым - подвердить адрес электронной почты, <br>
    для этого перейдите по ссылке:
    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>