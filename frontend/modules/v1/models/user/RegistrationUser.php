<?php

namespace frontend\modules\v1\models\user;

use Yii;
use frontend\modules\v1\models\GetInfoByEntity;
use common\models\User;
use frontend\modules\v1\models\ValidationModel;

class RegistrationUser extends ValidationModel implements GetInfoByEntity
{
    public $email;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email не может быть пустым.'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'string', 'max' => 100, 'tooLong' => 'Email может содержать максимум 100 символов.'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Данный email уже используется.'],

            ['password', 'required', 'message' => 'Пароль не может быть пустым.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Минимальная длина пароля 6 символов.'],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = User::STATUS_ACTIVE;

        return $user->save() && $this->sendVerifyEmail('emailVerify', $user, $this->email, $this->password);

        // TODO: Добавить отправку сообщения о регистрации

    }


    /**
     * Send email user
     *
     * @param string $viewEmail
     * @param User $user
     * @param string $email
     * @return bool whether message is sent successfully.
     */
    public static function sendVerifyEmail($viewEmail, $user,  $email, $password)
    {

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => $viewEmail . '-html', 'text' => $viewEmail . '-text'],
                ['user' => $user, 'password' => $password]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject('Подтверждение e-mail')
            ->send();
    }

}
