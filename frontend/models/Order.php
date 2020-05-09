<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $pet_id
 * @property string|null $purchase
 * @property string $size
 * @property string|null $address
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pet_id' => 'Pet ID',
            'purchase' => 'Purchase',
            'size' => 'Size',
            'address' => 'Address',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPet()
    {
        return $this->hasOne(Pet::className(), ['user_id' => 'pet_id']);
    }

    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['id' => 'price_id']);
    }

    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status_id']);
    }

}
