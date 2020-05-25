<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 18.05.2020
 * Time: 20:30
 */

namespace frontend\modules\v1\controllers;

use Yii;
use frontend\modules\v1\models\user\PasswordResetUser;

class PasswordController extends ApiController
{

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {

//        $model = new PasswordResetUser();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendPasswordResetEmail()) {
//
//            }
//        }
        return true;
    }

    public function actionPassword()    {
        return 'password';
    }


        /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        return $token;

//        try {
//            $model = new ResetPasswordForm($token);
//        } catch (InvalidArgumentException $e) {
//            throw new BadRequestHttpException($e->getMessage());
//        }
//
//        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
//            Yii::$app->session->setFlash('success', 'New password saved.');
//
//            return $this->goHome();
//        }
//
//        return $this->render('resetPassword', [
//            'model' => $model,
//        ]);
    }


}
