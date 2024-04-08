<?php

namespace common\components\traits;

use backend\models\AccessToken;
use common\models\User;
use Yii;
use yii\web\NotFoundHttpException;

trait Auth {
    private function authApi() {
        $accessToken = Yii::$app->request->headers->get('Access-Token');
        $accessToken = AccessToken::findByToken($accessToken);
        if(!$accessToken) return false;
        $user = User::findIdentity($accessToken->user_id);
        if(!$user) return false;

        return $accessToken->user;
    }

    private function currentUserIsAdminCheck() {
        $identity = Yii::$app->user->identity;
        if(!$identity || $identity->role !== 'admin') throw new NotFoundHttpException('The requested page does not exist.');
    }
}
?>