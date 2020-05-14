<?php

namespace frontend\modules\v1\models\orders;

use app\models\Order;
use app\models\OrderStatus;
use app\models\Pet;
use app\models\Price;
use common\models\User;
use frontend\modules\v1\models\GetInfoByEntity;
use frontend\modules\v1\models\ValidationModel;
use Yii;
use yii\web\NotFoundHttpException;

class UpdateOrders extends ValidationModel implements GetInfoByEntity
{
    public $id;
    public $pet_id;
    public $price_id;
    public $size;
    public $status_id;
    public $address;
    public $date_create;
    public $date_delivery;
    public $time_delivery;
    public $user_id;
    public $cost;
    public $comment;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pet_id', 'price_id', 'status_id', 'user_id'], 'integer'],
            [['id', 'size', 'address', 'date_delivery', 'time_delivery', 'user_id', 'cost', 'comment'], 'required'],
            [['date_create', 'date_delivery', 'time_delivery'], 'safe'],
            [['cost'], 'number'],
            [['size', 'address'], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 1500],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['pet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::className(), 'targetAttribute' => ['pet_id' => 'id']],
            [['price_id'], 'exist', 'skipOnError' => true, 'targetClass' => Price::className(), 'targetAttribute' => ['price_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $model = Order::findOne($this->id);
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
        return  $model;
        }

        return false;
    }

}

