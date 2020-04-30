<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_status".
 *
 * @property int $id
 * @property string|null $title
 */
class OrderStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['status_id' => 'id']);
    }

}
