<?php

namespace frontend\modules\v1\models\pets;

use app\models\Pet;
use frontend\modules\v1\models\GetInfoByEntity;
use Yii;
use frontend\modules\v1\models\ValidationModel;

class GetPets extends ValidationModel implements GetInfoByEntity
{
    private $user_id;

    public function __construct()
    {
        $this->user_id = Yii::$app->user->identity->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $res['pets'] = Pet::findAll(['user_id' => $this->user_id]);
        //$res['pets'] = Pet::find()->where(['user_id' => $this->user_id])->all();
        return $res;


//        return new ActiveDataProvider([
//            'query' => Pet::find()->where(['user_id' => $this->user_id]),
//        ]);
    }
}
