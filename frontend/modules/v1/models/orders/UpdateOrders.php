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
    public $name;
    public $gender;
    public $type;
    public $size;
    public $breed;
    public $birthday_date;
    public $birthday_years;
    public $food_exceptions;

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
            ['id', 'required', 'message' => 'Не указан идентификатор питомца'],
            ['id', 'integer', 'message' => 'Идентификатор питомца должен быть числом'],

            [['name', 'gender', 'type', 'breed', 'birthday_years', 'food_exceptions'], 'trim'],

            ['name', 'string', 'min' => 3, 'tooShort' => 'Минимальная длина имени 3 символа.'],
            ['name', 'string', 'max' => 50, 'tooLong' => 'Максимальная длина имени 50 символов.'],

            [['name', 'gender', 'type', 'breed', 'birthday_years', 'food_exceptions'], 'string', 'max' => 255],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $order = Order::findOne($this->id);

//        if ($this->gender) {
//            $order->gender = $this->gender;
//        }

        return ($order->save()) ? true : false;

    }
}

