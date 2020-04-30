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

            ['phone', 'trim'],
            ['phone', 'integer', 'message' => 'номер должен быь числом'],
            ['phone', 'string', 'min' => 10, 'tooShort' => 'Некорретная длина номера'],
            ['phone', 'string', 'max' => 10, 'tooLong' => 'Некорретная длина номера'],
        ];
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

        $this->user;

        if ($this->email){
            $this->user->email = $this->email;
        }

        if ($this->name){
            $this->user->name = $this->name;
        }

        if ($this->phone){
            $this->user->phone = $this->phone;
        }

        if ($this->password){
            $this->user->setPassword($this->password);
        }

        return $this->user->save();

    }
}

