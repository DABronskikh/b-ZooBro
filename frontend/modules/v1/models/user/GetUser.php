<?php

namespace frontend\modules\v1\models\user;

use frontend\modules\v1\models\GetInfoByEntity;
use Yii;
use common\models\User;
use frontend\modules\v1\models\ValidationModel;

class GetUser extends ValidationModel implements GetInfoByEntity
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $id = Yii::$app->user->identity->getId();
        $user = User::find()
            ->select(['name', 'email', 'is_admin', 'phone', 'address'])
            ->where(['id' => $id])
            ->one();

        return $user;
    }
}
