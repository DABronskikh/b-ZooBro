<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $pet_id
 * @property string|null $purchase
 * @property string $size
 * @property int|null $status
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
            [['pet_id', 'size'], 'required'],
            [['pet_id', 'status'], 'integer'],
            [['purchase', 'size', 'address'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'address' => 'Address',
        ];
    }

    public function getPet()
    {
        return $this->hasOne(Pet::className(), ['pet_id' => 'id']);
    }

}
