<?php

namespace frontend\modules\v1\models\user;

use frontend\modules\api\v1\service\SendVerifyEmailUser;
use frontend\modules\v1\models\GetInfoByEntity;
use common\models\User;
use frontend\modules\v1\models\ValidationModel;

class RegistrationUser extends ValidationModel implements GetInfoByEntity
{
    public $email;
    public $password;

    private const VIEW_EMAIL_REGISTRATION = 'emailVerify';

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

        return $user->save() &&
            SendVerifyEmailUser::sendVerifyEmail(self::VIEW_EMAIL_REGISTRATION, $user);
        // TODO: Добавить отправку сообщения о регистрации

    }

}
