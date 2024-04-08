<?php

namespace backend\controllers;

use backend\models\GetOwnPostForm;
use backend\models\GetPostForm;
use common\components\services\PostService;
use common\components\traits\Auth;
use common\components\traits\ApiResponse;
use backend\models\StorePostForm;

class PostsController extends \yii\web\Controller
{
    use ApiResponse, Auth;

    private $user;
    private $postService;

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        $this->user = $this->authApi();
        $this->postService = new PostService;

        return parent::beforeAction($action);
    }

    public function actionStore()
    {
        if(!$this->user) return $this->accessErrorResponse();
        $storePostForm = new StorePostForm();

        $storePostForm->setAttributes($_POST);
        if ($storePostForm->validate()) {
            $this->postService->store($this->user);

            return $this->jsonSuccessResponse();
        } else {
            return $this->jsonValidationResponse($storePostForm->errors);
        };
    }

    public function actionGet()
    {
        $getPostForm = new GetPostForm();
        if(!$this->user) return $this->accessErrorResponse();

        $getPostForm->setAttributes($_GET);
        if (empty($_GET) || $getPostForm->validate()) {
            $result = $this->postService->get($this->user, $getPostForm->getAttributes());

            return $this->jsonSuccessResponse(['data' => $result]);
        } else {
            return $this->jsonValidationResponse($getPostForm->errors);
        };
    }

    public function actionGetOwn()
    {
        $getOwnPostForm = new GetOwnPostForm();
        if(!$this->user) return $this->accessErrorResponse();

        $getOwnPostForm->setAttributes($_GET);
        if (empty($_GET) || $getOwnPostForm->validate()) {
            $result = $this->postService->get($this->user, array_merge($getOwnPostForm->getAttributes(), ['currentUserPosts' => true]));

            return $this->jsonSuccessResponse(['data' => $result]);
        } else {
            return $this->jsonValidationResponse($getOwnPostForm->errors);
        };
    }
}