<?php

namespace frontend\modules\v1\models\user;

use Yii;
use frontend\modules\v1\models\GetInfoByEntity;
use common\models\User;
use frontend\modules\v1\models\ValidationModel;

class UpdateUser extends ValidationModel implements GetInfoByEntity
{
    public $email;
    public $password;
    public $phone;
    public $name;
    public $address;

    /*@var User */
    private $user;

    public function __construct()
    {
        $user = Yii::$app->user->identity;
        parent::__construct();
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'string', 'max' => 50, 'tooLong' => 'Email может содержать максимум 50 символов.'],
            ['email', 'validateNewEmail'],

            ['password', 'string', 'min' => 6, 'tooShort' => 'Минимальная длина пароля 6 символов.'],

            ['name', 'trim'],
            ['name', 'string', 'min' => 3, 'tooShort' => 'Минимальная длина имени 3 символа.'],
            ['name', 'string', 'max' => 50, 'tooLong' => 'Максимальная длина имени 50 символов.'],

            ['address', 'trim'],
            ['address', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина адреса 255 символов.'],

            ['phone', 'integer', 'message' => 'номер должен быь числом'],
            ['phone', 'validatePhone'],
        ];
    }

    public function validatePhone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->phone < 1000000000 || $this->phone > 9999999999) {
                $this->addError($attribute, 'Некорректная длина номера');
            }
        }
    }

    public function validateNewEmail($attribute)
    {
        if (!$this->hasErrors()) {
            $id = Yii::$app->user->identity->getId();
            $count = User::find()
                ->select(['email'])
                ->where(['or', "id={$id}", " email = '{$this->email}' "])
                ->count();

            if ($count != 1) {
                $this->addError($attribute, 'Данный email уже используется.');
            }
        }
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        //$opdateUser = User::findOne($this->user->getId());
        //return $opdateUser;

        if ($this->email) {
            $this->user->email = $this->email;
        }

        if ($this->name) {
            $this->user->name = $this->name;
        }

        if ($this->phone > 1) {
            $this->user->phone = $this->phone;
        }

        if ($this->address) {
            $this->user->address = $this->address;
        }

        if ($this->password) {
            $this->user->setPassword($this->password);
        }

        //return $this->phone;
        return $this->user->save();
        //return $this->user->phone;

    }
}

