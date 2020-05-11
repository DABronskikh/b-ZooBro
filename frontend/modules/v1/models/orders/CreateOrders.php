<?php

namespace frontend\modules\v1\models\orders;

use app\models\Order;
use app\models\Pet;
use app\models\Price;
use common\models\User;
use frontend\modules\v1\models\GetInfoByEntity;
use frontend\modules\v1\models\user\RegistrationUser;
use frontend\modules\v1\models\ValidationModel;

class CreateOrders extends ValidationModel implements GetInfoByEntity
{
    public $pet_id;
    public $price_id;
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

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // ToDo дописать валидаторы для обязательных полей
            [['email'], 'trim'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'required', 'message' => 'email не может быть пустым'],

            ['time_delivery', 'required', 'message' => 'укажи время доставки'],
            ['date_delivery', 'required', 'message' => 'укажи дату доставки'],
            ['address', 'required', 'message' => 'укажи адрес доставки'],
            ['phone', 'required', 'message' => 'укажи контактный телефон'],
            ['size', 'required', 'message' => 'укажи размер питомца'],
            ['price_id', 'required', 'message' => 'укажи тип коробки'],

            ['phone', 'integer', 'max' => 10],
            ['date_delivery', 'date'],
            ['time_delivery', 'date', 'format'=>'H:i'],
            [['address', 'size'], 'string', 'max' => '255'],
            ['price_id', 'integer'],

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

        // проверяем есть ли пользователь, если нет, регистрируем его по email
        $this->_user = User::findByEmail($this->email);

        if ($this->_user) {
            $rez[] = 'пользователь найден';
        } else {
            $rez[] = ' нужно создать пользователя';
            //$password = $this->gen_password(8);
            $password = 'password';

            // ToDo отправить пароль в сообщении (Выполнено. Пароль отправляется в письме с верификацией.)
            $rez['password'] = $password;

            $user = new User();
            $user->email = $this->email;
            $user->setPassword($password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->status = User::STATUS_ACTIVE;
            $user->name = $this->user_name;
            $user->phone = $this->phone;
            $user->save() && RegistrationUser::sendVerifyEmail('emailVerify', $user, $this->email, $password);

            // забираем нового пользователя для формирования заказа
            $this->_user = User::findByEmail($this->email);
        }

        // проверяем наличие данных для нового питомца
        if ($this->pet_name && $this->gender && $this->size) {
            $rez[] = 'нужно создать питомца';

            $pet = new Pet([
                'gender' => $this->gender,
                'birthday_date' => $this->birthday_date,
                'name' => $this->pet_name,
                'size' => $this->size,
                'breed' => $this->breed,
                'birthday_years' => $this->birthday_years,
                'food_exceptions' => $this->food_exceptions,
                'user_id' => $this->_user->id,
                'type' => 'dog',
            ]);
            $pet->save();
            $this->pet_id = $pet->id;
            //$rez['$pet'] = $pet;
        }

        $price = Price::findOne($this->price_id);
        //$rez['$price'] = $price;

        $order = new Order([
            'pet_id' => $this->pet_id,
            'price_id' => $this->price_id,
            'size' => $this->size,
            'status_id' => 1,
            'address' => $this->address,
            'date_delivery' => $this->date_delivery,
            'time_delivery' => $this->time_delivery,
            'user_id' => $this->_user->id,
            'cost' => $price->cost,
            'comment' => 'Новый заказ',
        ]);

        
        <<<<<<< Updated upstream
        //$rez['$order'] = $order;
        return ($order->save()) ? ['id' => $order->id] : false;
=======
        if ($this->pet_id == "null") {
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

>>>>>>> Stashed changes
    }

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    function gen_password($length = 6)
    {
        $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
        $size = strlen($chars) - 1;
        $password = '';
        while ($length--) {
            $password .= $chars[random_int(0, $size)];
        }
        return $password;
    }

}
