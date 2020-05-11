<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\orders\CreateOrders;
use frontend\modules\v1\models\orders\GetOrders;
use frontend\modules\v1\models\orders\UpdateOrders;

class OrdersController extends ApiController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['only'] = [
            'index',
            'update',
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->getInfoByEntity(new GetOrders());
    }

    public function actionCreate()
    {
        return $this->doActionByEntity(new CreateOrders());
    }

    public function actionUpdate()
    {
        return $this->doActionByEntity(new UpdateOrders());
    }

}
