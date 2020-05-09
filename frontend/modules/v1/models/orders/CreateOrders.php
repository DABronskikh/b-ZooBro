<?php

namespace frontend\modules\v1\models\orders;

use app\models\Order;
use app\models\Pet;
use common\models\User;
use frontend\modules\v1\models\GetInfoByEntity;
use frontend\modules\v1\models\ValidationModel;
use Yii;

class CreateOrders extends ValidationModel implements GetInfoByEntity
{
    private $pet_id;
    private $price_id;
    private $user_id;

    public $id;
    public $size;
    public $status_id;
    public $address;
    public $date_create;
    public $date_delivery;
    public $time_delivery;
    public $cost;
    public $comment;

    //user
    public $user_name;
    public $email;
    public $phone;
    public $password;

    //pet
    public $pet_name;
    public $gender;
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
            [['pet_id', 'user_id', 'price_id', 'status_id'], 'integer', 'max' => 11],
            [['size', 'address', 'date_create', 'date_delivery', 'time_delivery', 'cost', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array|bool
     * @throws \Exception
     */
    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User([
            'email' => $this->email,
            //сгенерируем случайный пароль
            //'password' => $this->gen_password(8),

            //TODO временный пароль
            'password' => 'password',

            'phone' => $this->phone,
            'name' =>  $this->user_name
        ]);

        $pet = new Pet([
            'pet_name' => $this->pet_name,
            'gender' => $this->gender,
            'breed' => $this->breed,
            'birthday_date' => $this->birthday_date,
            'birthday_years' => $this->birthday_years,
            'food_exceptions' => $this->food_exceptions,
        ]);

        $order = new Order([
            'price_id' => $this->price_id,
            'size' => $this->size,
            'status_id' => $this->status_id,
            'address' => $this->address,
            'date_create' => $this->date_create,
            'date_delivery' => $this->date_delivery,
            'time_delivery' => $this->time_delivery,
            'cost' => $this->cost,
            'comment' => $this->comment,
        ]);

        if ($user->save()){
            $pet->user_id = $user->id;
            $order->user_id = $user->id;
            if ($pet->save()){
                $order->pet_id = $pet->id;
            }

        }

        return ($order->save()) ? ['id' => $order->id] : false;

    }

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    function gen_password($length)
    {
        $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
        $size = strlen($chars) - 1;
        $password = '';
        while($length--) {
            $password .= $chars[random_int(0, $size)];
        }
        return $password;
    }

}
