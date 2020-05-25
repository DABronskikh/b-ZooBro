<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $pet_id
 * @property int|null $price_id
 * @property string $size
 * @property int|null $status_id
 * @property string $address
 * @property string|null $date_create
 * @property string $date_delivery
 * @property string $time_delivery
 * @property int $user_id
 * @property float $cost
 * @property string $comment
 * @property int|null $phone
 * @property string|null $name
 *
 * @property OrderStatus $status
 * @property Pet $pet
 * @property Price $price
 * @property User $user
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
            [['pet_id', 'price_id', 'status_id', 'user_id', 'phone'], 'integer'],
            [['size', 'address', 'date_delivery', 'time_delivery', 'user_id', 'cost', 'comment'], 'required'],
            [['date_create', 'date_delivery', 'time_delivery'], 'safe'],
            [['cost'], 'number'],
            [['size', 'address'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 50],
            [['comment'], 'string', 'max' => 1500],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['pet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::className(), 'targetAttribute' => ['pet_id' => 'id']],
            [['price_id'], 'exist', 'skipOnError' => true, 'targetClass' => Price::className(), 'targetAttribute' => ['price_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'price_id' => 'Price ID',
            'size' => 'Size',
            'status_id' => 'Status ID',
            'address' => 'Address',
            'date_create' => 'Date Create',
            'date_delivery' => 'Date Delivery',
            'time_delivery' => 'Time Delivery',
            'user_id' => 'User ID',
            'cost' => 'Cost',
            'comment' => 'Comment',
            'name' => 'Name',
            'phone' => 'phone',
        ];
    }

    public function extraFields()
    {
        return [
            'pet',
            'status',
            'user',
        ];
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[Pet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPet()
    {
        return $this->hasOne(Pet::className(), ['id' => 'pet_id']);
    }

    /**
     * Gets query for [[Price]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['id' => 'price_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
