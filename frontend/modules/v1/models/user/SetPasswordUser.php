<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 26.05.2020
 * Time: 9:10
 */

namespace frontend\modules\v1\models\user;

use common\models\User;
use frontend\modules\v1\models\GetInfoByEntity;
use frontend\modules\v1\models\ValidationModel;
use Yii;

class SetPasswordUser extends ValidationModel implements GetInfoByEntity
{

    public $token;
    public $password;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'password'], 'trim'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Минимальная длина пароля 6 символов.'],
            ['token', 'required', 'message' => 'Не передан токен'],
            ['password', 'required', 'message' => 'Не указан пароль'],
        ];
    }

    /**
     * @throws \yii\base\Exception
     */
    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_user = User::findByPasswordResetToken($this->token);

        if (!$this->_user) {
            $rez[] = 'пользователь не найден';
            return false;
        } else {
            $rez[] = ' пользователь найден';
            //$this->_user->password_hash = $this->setPassword($this->password);
            $this->_user->setPassword($this->password);
            return $this->_user->save();
        }
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}
