<?php

namespace frontend\modules\v1\controllers;


use frontend\modules\v1\models\pets\CreatePets;
use frontend\modules\v1\models\pets\GetPets;
use frontend\modules\v1\models\pets\UpdatePets;

class PetsController extends ApiController
{

    public function actionIndex()
    {
        return $this->getInfoByEntity(new GetPets());
    }


    public function actionUpdate()
    {
        return $this->doActionByEntity(new UpdatePets());
    }

    public function actionCreate()
    {
        return $this->doActionByEntity(new CreatePets());
    }

}
