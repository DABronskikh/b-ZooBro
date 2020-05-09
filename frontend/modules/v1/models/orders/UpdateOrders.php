<?php

namespace frontend\modules\v1\models\orders;

use app\models\Order;
use frontend\modules\v1\models\GetInfoByEntity;
use frontend\modules\v1\models\ValidationModel;
use Yii;

class UpdateOrders extends ValidationModel implements GetInfoByEntity
{
    private $user_id;

    public $id;
    public $pet_id;
    public $price_id;
    public $size;
    public $status_id;
    public $address;
    public $date_create;
    public $date_delivery;
    public $time_delivery;
    public $cost;
    public $comment;

    public function __construct()
    {
        $this->user_id = Yii::$app->user->identity->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pet_id', 'price_id', 'size', 'status_id', 'address', 'date_create', 'date_delivery', 'time_delivery', 'cost', 'comment'], 'safe']
        ];
    }

    // Запрос
//      {
//      "id" : "14",
//      "price_id" : "1",
//      "user_name": "Цобака-покусака",
//      "phone": 9001001010,
//      "address": "Новый Арбат 10",
//      "date_delivery" : "2020-01-01",
//      "time_delivery" : "23:45",
//      "status_id": "1",
//      "comment": "Комментарий"
//      }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $order = Order::findOne($this->id);

        if ($this->price_id) {
            $order->price_id = $this->price_id;
        }
        if ($this->address) {
            $order->address = $this->address;
        }
        if ($this->date_delivery) {
            $order->date_delivery = $this->date_delivery;
        }
        if ($this->time_delivery) {
            $order->time_delivery = $this->time_delivery;
        }
        if ($this->status_id) {
            $order->status_id = $this->status_id;
        }
        if ($this->comment) {
            $order->comment = $this->comment;
        }

        return ($order->save()) ? true : false;

    }
}

