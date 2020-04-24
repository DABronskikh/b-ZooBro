<?php

namespace frontend\modules\v1\models\user;

use frontend\modules\v1\models\GetInfoByEntity;
use Yii;
use common\models\User;
use frontend\modules\v1\models\ValidationModel;

class AuthenticationUser extends ValidationModel implements GetInfoByEntity
{
    public $email;
    public $password;
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'trim'],
            ['email', 'required', 'message' => 'email не может быть пустым'],
            ['password', 'required', 'message' => 'Пароль не может быть пустым'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Минимальная длина пароля - 6 символов'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = User::findByEmail($this->email);
            if (!$this->_user || !$this->_user->validatePassword($this->password)) {
                $this->addError($attribute, 'Некорректный email или пароль.');
            }
        }
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_user;
        Yii::$app->response->headers->set('Authorization', $user->auth_key);
        $rez['Authorization'] = 'Bearer ' . $user->auth_key;

        return $rez;
    }
}
