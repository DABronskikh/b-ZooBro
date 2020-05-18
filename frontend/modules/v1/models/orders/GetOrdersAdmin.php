<?php

namespace frontend\modules\v1\models\orders;

use app\models\Order;
use app\models\OrderStatus;
use common\models\User;
use frontend\modules\v1\models\GetInfoByEntity;
use Yii;
use frontend\modules\v1\models\ValidationModel;
use yii\data\ActiveDataProvider;

class GetOrdersAdmin extends ValidationModel implements GetInfoByEntity
{
    public $is_admin;
    private $user_id;

    public function __construct()
    {
        $this->user_id = Yii::$app->user->identity->getId();
    }

    public function rules()
    {
        return [];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

//        $user = User::findOne($this->user_id);
//        if ($user->is_admin !== 1) {
//            $this->addError( null,'У вас нет админских прав');
//            return false;
//        }

        $queryParams = Yii::$app->request->queryParams;
        unset($queryParams['page']);
        unset($queryParams['expand']);
        unset($queryParams['sort']);

        $query = Order::find()
            ->where($queryParams);

        $rez['orders'] = new ActiveDataProvider([
            'query' => $query,
        ]);

        $rez['order_status'] = OrderStatus::find()->all();
        return $rez;

    }
}
