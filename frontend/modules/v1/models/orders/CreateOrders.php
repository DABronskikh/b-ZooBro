<?php

namespace frontend\modules\v1\models\orders;

use Yii;
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
            [['email'], 'trim'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'required', 'message' => 'email не может быть пустым'],

            ['time_delivery', 'required', 'message' => 'укажи время доставки'],
            ['date_delivery', 'required', 'message' => 'укажи дату доставки'],
            ['address', 'required', 'message' => 'укажи адрес доставки'],
            ['phone', 'required', 'message' => 'укажи контактный телефон'],

            ['size', 'required', 'message' => 'укажи размер питомца'],

            ['price_id', 'required', 'message' => 'укажи тип коробки'],

            ['phone', 'integer', 'max' => 9999999999, 'min' => 9000000000],
            [['date_delivery', 'time_delivery', 'pet_name', 'gender'], 'safe'],
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
            $rez['$pet'] = $pet;
        }

        $price = Price::findOne($this->price_id);
        $rez['$price'] = $price;

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

        //$rez['$order'] = $order;
        return ($order->save() && $this->sendEmailOrderSuccess('emailOrderSuccess', $this->_user, $this->email, $order)) ? ['id' => $order->id] : false;
    }

    /**
     * Send email user
     *
     * @param string $viewEmail
     * @param User $user
     * @param string $email
     * @param $order
     * @return bool whether message is sent successfully.
     */
    public static function sendEmailOrderSuccess($viewEmail, $user, $email, $order)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => $viewEmail . '-html', 'text' => $viewEmail . '-text'],
                ['user' => $user, 'order' => $order]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject('Ваш заказ создан')
            ->send();
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
