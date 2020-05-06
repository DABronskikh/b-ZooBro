<?php

namespace frontend\modules\v1\models\orders;

use app\models\Order;
use frontend\modules\v1\models\GetInfoByEntity;
use Yii;
use frontend\modules\v1\models\ValidationModel;

class GetOrders extends ValidationModel implements GetInfoByEntity
{
    private $user_id;

    public function __construct()
    {
        $this->user_id = Yii::$app->user->identity->getId();
    }

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

        return Order::findAll(['user_id' => $this->user_id]);

    }
}
