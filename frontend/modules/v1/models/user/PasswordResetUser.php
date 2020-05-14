<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 11.05.2020
 * Time: 18:15
 */

namespace frontend\modules\v1\models\user;

use Yii;
use frontend\modules\v1\models\GetInfoByEntity;
use common\models\User;
use frontend\modules\v1\models\ValidationModel;

class PasswordResetUser extends ValidationModel implements GetInfoByEntity
{
    public $email;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'trim'],
        ];
    }

    public function getInfo()
    {
        $this->_user = User::findByEmail($this->email);

        if (!$this->_user) {
            $rez[] = 'пользователь не найден';
            return false;
        } else {
            $rez[] = ' пользователь найден';
            return $this->sendPasswordResetEmail('passwordResetToken', $this->_user, $this->email);
        }
    }

    /**
     * Send email user
     *
     * @param string $viewEmail
     * @param User $user
     * @param string $email
     * @return bool whether message is sent successfully.
     */

    public static function sendPasswordResetEmail($viewEmail, $user, $email)
    {

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => $viewEmail . '-html', 'text' => $viewEmail . '-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject('Восстановление пароля')
            ->send();
    }



}