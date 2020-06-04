<?php

namespace frontend\modules\v1\models\pets;

use app\models\Pet;
use frontend\modules\v1\models\GetInfoByEntity;
use Yii;
use frontend\modules\v1\models\ValidationModel;

class UpdatePets extends ValidationModel implements GetInfoByEntity
{
    private $user_id;

    public $id;
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
            ['id', 'required', 'message' => 'Не указан идентификатор питомца'],
            ['id', 'integer', 'message' => 'Идентификатор питомца должен быть числом'],
            ['size', 'integer', 'message' => 'Размер питомца должен быть числом'],

            [['name', 'gender', 'type', 'breed', 'birthday_years', 'food_exceptions'], 'trim'],

            ['name', 'string', 'min' => 3, 'tooShort' => 'Минимальная длина имени 3 символа.'],
            ['name', 'string', 'max' => 50, 'tooLong' => 'Максимальная длина имени 50 символов.'],

            [['name', 'gender', 'type', 'breed', 'birthday_years', 'food_exceptions', 'birthday_date'], 'string', 'max' => 255],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $pet = Pet::findOne($this->id);

        if ($this->gender) {
            $pet->gender = $this->gender;
        }

        if ($this->birthday_date) {
            $pet->birthday_date = $this->birthday_date;
        }

        if ($this->name) {
            $pet->name = $this->name;
        }

        if ($this->size) {
            $pet->size = $this->size;
        }

        if ($this->breed) {
            $pet->breed = $this->breed;
        }

        if ($this->birthday_years) {
            $pet->birthday_years = $this->birthday_years;
        }

        if ($this->food_exceptions) {
            $pet->food_exceptions = $this->food_exceptions;
        }

        return ($pet->save()) ? true : false;

    }
}
