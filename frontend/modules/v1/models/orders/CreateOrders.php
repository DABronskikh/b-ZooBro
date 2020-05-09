<?php

namespace frontend\modules\v1\models\orders;

use app\models\Order;
use app\models\Pet;
use frontend\modules\v1\models\GetInfoByEntity;
use frontend\modules\v1\models\ValidationModel;
use Yii;

class CreateOrders extends ValidationModel implements GetInfoByEntity
{
    public $user_id;
    public $pet_id;
    public $price_id;
    public $status_id;
    public $pet_name;
    public $gender;
    public $size;
    public $breed;
    public $birthday_date;
    public $birthday_years;
    public $food_exceptions;
    public $user_name;
    public $email;
    public $phone;
    public $address;
    public $date_delivery;
    public $time_delivery;
    public $cost;
    public $comment;
    public $type;

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
//            [['pet_id', 'price_id', 'user_id', 'status_id'], 'integer', 'max' => 11],
//            ['phone', 'integer', 'max' => 10],
//            [['size', 'address', 'date_create', 'user_name', 'email', 'date_delivery', 'time_delivery', 'cost', 'comment', 'pet_name', 'gender', 'breed', 'birthday_years', 'food_exceptions'], 'string', 'max' => 255],
//            [['birthday_date'], 'safe']
            [['pet_id', 'price_id', 'pet_name', 'gender', 'size', 'breed', 'birthday_date', 'birthday_years', 'food_exceptions', 'user_name', 'email', 'phone', 'address', 'date_delivery', 'time_delivery', 'cost', 'comment', 'type'], 'safe']
        ];
    }


    //Запрос
//      {
//      "price_id" : "1",
//      "pet_name" : "Цобака-покусака",
//      "gender" : "m",
//      "size" : "1",
//      "type" : "1",
//      "breed" : "null",
//      "birthday_date" : "2019-02-05",
//      "birthday_years" : "4-7",
//      "food_exceptions" : "null",
//      "user_name": "name",
//      "email": "shurikoz@ya.ru",
//      "phone": 9001001010,
//      "address": "address 10",
//      "date_delivery" : "2019-02-05",
//      "time_delivery" : "23:45"
//      }
    /**
     * @return array|bool
     * @throws \Exception
     */
    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        //генерация случайного пароля
        //$password => $this->gen_password(8),
//
//        //TODO временный пароль
//        $password = 'password';
//
//        $user = new User();
//        $user->email = $this->email;
//        $user->setPassword($password);
//        $user->generateAuthKey();
//        $user->generateEmailVerificationToken();
//        $user->status = User::STATUS_ACTIVE;
//        $user->name = $this->user_name;
//        $user->phone = $this->phone;


        // данные для запроса
        //  {
        //      "pet_id": "10",
        //
        //      "pet_name" : "Цобака-покусака",
        //      "gender" : "m",
        //      "size" : "1",
        //      "type" : "dog",
        //      "breed" : "null",
        //      "birthday_date" : "2019-02-05",
        //      "birthday_years" : "4-7",
        //      "food_exceptions" : "null",
        //
        //      "price_id" : "1",
        //      "user_name" : "name",
        //      "email" : "yandex@yandex.ru",
        //      "phone" : 9001001010,
        //      "status_id" : "0",
        //      "address" : "address 10",
        //      "date_delivery" : "2019-02-05",
        //      "time_delivery" : "23:45",
        //      "cost" : "false",
        //      "comment" : "Комментарий"
        //  }

        $pet = new Pet([
            'gender' => $this->gender,
            'birthday_date' => $this->birthday_date,
            'name' => $this->pet_name,
            'size' => $this->size,
            'breed' => $this->breed,
            'birthday_years' => $this->birthday_years,
            'food_exceptions' => $this->food_exceptions,

            'user_id' => $this->user_id,
            'type' => $this->type,
        ]);


        $order = new Order([
            'pet_id' => $this->pet_id,
            'price_id' => $this->price_id,
            'size' => $this->size,
            'status_id' => $this->status_id,
            'address' => $this->address,
            'date_delivery' => $this->date_delivery,
            'time_delivery' => $this->time_delivery,
            'user_id' => $this->user_id,
            'cost' => $this->cost,
            'comment' => $this->comment,
        ]);

        if ($this->pet_id != "null") {
            if ($pet->save()) {
                return ($order->save()) ? ['pet_id' => $pet->id, 'order_id' => $order->id] : false;
            } else{
                return false;
            }
        } else {
            return ($order->save()) ? ['id' => $order->id] : false;
        }

//                return ($order->save()) ? ['id' => $order->id] : false;





//        if ($this->pet_id) {
//            if ($pet->save()) {
//                $order->save() ? (['pet_id' => $pet->id, 'order_id' => $order->id]) : false;
//            } else {
//                return false;
//            }
//        } else {
//            return $order->save() ? ['pet_id' => $pet->id] : false;
//        }

        //если есть данные о питомце, то сохраним питомца
//        return ($pet->save()) ? ['id' => $pet->id] : false;
//        return ($pet->save()) ? true : false;

//        if ($pet->save()) {
//            $this->pet_id = $pet->id;
//            return $order->save() ? true : false;
//        } //            $order->save() ? true : false;
//        else {
//            return $order->save() ? ['pet_id' => $pet->id] : false;
//        }


//            $pet->user_id = $this->user_id;
//            $order->user_id = $this->user_id;
//            if ($pet->save()) {
//                $order->pet_id = $pet->id;
//                $order->save() ? true : false;
//            } else {
//                return false;
//            }


//        return ($order->save()) ? ['id' => $order->id] : false;
//        return ($pet->save()) ? ['id' => $pet->id] : false;

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
