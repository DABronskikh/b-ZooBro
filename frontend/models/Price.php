<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string|null $title
 * @property float|null $cost
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cost'], 'number'],
            [['title'], 'string', 'max' => 255],
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
            'cost' => 'Cost',
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['price_id' => 'id']);
    }
}
