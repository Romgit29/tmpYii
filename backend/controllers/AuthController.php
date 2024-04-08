<?php

namespace backend\controllers;

use common\components\services\UserService;
use common\components\traits\ApiResponse;
use backend\models\LoginForm;
use backend\models\SignupForm;
use yii\web\Controller;

/**
 * Registration controller
 */
class AuthController extends Controller
{
    use ApiResponse;

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Registration action.
     *
     * @return string|Response
     */
    public function actionSignup()
    {
        $signupForm = new SignupForm();
        $userService = new UserService;
        
        $signupForm->setAttributes($_POST);
        if ($signupForm->validate()) {
            $result = $userService->signupApi();

            return $this->jsonSuccessResponse($result);
        } else {
            return $this->jsonValidationResponse($signupForm->errors);
        };
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        $loginForm = new LoginForm();
        $userService = new UserService;
        
        $loginForm->setAttributes($_POST);
        if ($loginForm->validate()) {
            $result = $userService->loginApi();
            if($result['success']) {
                return $this->jsonSuccessResponse($result);
            } else {
                return $this->accessErrorResponse();
            }
        } else {
            return $this->jsonValidationResponse($loginForm->errors);
        };
    }
}