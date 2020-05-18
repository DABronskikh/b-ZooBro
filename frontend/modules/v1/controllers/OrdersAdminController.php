<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\orders\GetOrdersAdmin;

class OrdersAdminController extends ApiController
{

    public function actionIndex()
    {
        return $this->getInfoByEntity(new GetOrdersAdmin());
    }

}
