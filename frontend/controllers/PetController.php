<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 20.04.2020
 * Time: 14:11
 */

namespace frontend\controllers;
use yii\rest\ActiveController;

class PetController extends ActiveController
{
    public $modelClass = 'app\models\Pet';
}

