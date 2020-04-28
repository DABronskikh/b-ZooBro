<?php

namespace frontend\modules\v1\controllers;

use frontend\modules\v1\models\user\GetUser;
use frontend\modules\v1\models\user\RegistrationUser;
use frontend\modules\v1\models\user\AuthenticationUser;

class UserController extends ApiController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['only'] = [
            'index',
            'update',
            'change-password',
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->getInfoByEntity(new GetUser());
    }

    public function actionAuth()
    {
        return $this->doActionByEntity(new AuthenticationUser(), true);
    }

    public function actionRegister()
    {
        return $this->doActionByEntity(new RegistrationUser(), true);
    }

}
