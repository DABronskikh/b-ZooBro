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
     * @throws \yii\base\Exception
     */
    public function getInfo()
    {
        $this->_user = User::findByPasswordResetToken($this->token);

        if (!$this->_user) {
            $rez[] = 'пользователь не найден';
            return false;
        } else {
            $rez[] = ' пользователь найден';
            $this->_user->password_hash = $this->setPassword($this->password);
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