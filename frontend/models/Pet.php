<?php

namespace app\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "pet".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $gender
 * @property string $type
 * @property string $size
 * @property string|null $breed
 * @property string|null $birthday_date
 * @property string|null $birthday_years
 * @property int|null $food_exceptions
 */
class Pet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'gender', 'type', 'size'], 'required'],
            [['user_id', 'food_exceptions'], 'integer'],
            [['birthday_date'], 'safe'],
            [['name', 'gender', 'type', 'size', 'breed', 'birthday_years'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'gender' => 'Gender',
            'type' => 'Type',
            'size' => 'Size',
            'breed' => 'Breed',
            'birthday_date' => 'Birthday Date',
            'birthday_years' => 'Birthday Years',
            'food_exceptions' => 'Food Exceptions',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOrder()
    {
        return $this->hasMany(Order::className(), ['id' => 'pet_id']);
    }

}
