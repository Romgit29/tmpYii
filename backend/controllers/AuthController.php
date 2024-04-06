<?php

namespace backend\controllers;

use frontend\models\SignupForm;
use yii\web\Controller;

/**
 * Registration controller
 */
class AuthController extends Controller
{

    /**
     * Registration action.
     *
     * @return string|Response
     */
    public function actionSignup()
    {
        dd('action registration');
    }
}