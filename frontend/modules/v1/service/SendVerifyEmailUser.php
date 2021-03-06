<?php

namespace frontend\modules\api\v1\service;

use Yii;
use common\models\User;

class SendVerifyEmailUser
{
    /**
     * Send email user
     *
     * @param string $viewEmail
     * @param User $user
     * @param string $subjectEmail
     * @return bool whether message is sent successfully.
     */
    public static function sendVerifyEmail($viewEmail, $user,  $email = "")
    {
        if ($email == "") 
            $email = $user->email;
            
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => $viewEmail . '-html', 'text' => $viewEmail . '-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject('Подтверждение e-mail')
            ->send();
    }
}
