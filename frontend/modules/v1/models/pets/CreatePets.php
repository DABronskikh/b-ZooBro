<?php

namespace frontend\modules\v1\models\pets;

use app\models\Pet;
use frontend\modules\v1\models\GetInfoByEntity;
use Yii;
use frontend\modules\v1\models\ValidationModel;

class CreatePets extends ValidationModel implements GetInfoByEntity
{
    private $user_id;

    public $gender;
    public $birthday_date;
    public $name;
    public $type;
    public $size;
    public $breed;
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
            ['name', 'required', 'message' => 'Заполните имя питомца'],
            ['gender', 'required', 'message' => 'Укажите пол питомца'],
            ['size', 'required', 'message' => 'Укажите размер питомца'],
            [['name', 'gender', 'type', 'size', 'breed', 'birthday_years', 'food_exceptions', 'birthday_date'], 'string', 'max' => 255],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $pet = new Pet([
            'gender' => $this->gender,
            'birthday_date' => $this->birthday_date,
            'name' => $this->name,
            'size' => $this->size,
            'breed' => $this->breed,
            'birthday_years' => $this->birthday_years,
            'food_exceptions' => $this->food_exceptions,

            'user_id' => $this->user_id,
            'type' => 'dog',
        ]);

        return ($pet->save()) ? ['id' => $pet->id] : false;
    }
}
