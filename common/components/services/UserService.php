<?php
namespace common\components\services;

use backend\models\AccessToken;
use common\models\User;
use Yii;

class UserService 
{
    /**
     * Signs user up via api.
     *
     * @return string
     */
    public function signupApi(): array
    {   
        $request = Yii::$app->request->post();
        $user = new User();
        $accessToken = new AccessToken();
        
        $transaction = Yii::$app->db->beginTransaction();
        
        $user->username = trim($request['username']);
        $user->email = trim($request['email']);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->setPassword($request['password']);
        $user->save();

        $accessToken->setAccessToken();
        $accessToken->user_id = $user->id;
        $accessToken->save();

        $transaction->commit();

        $this->sendSuccessfullRegistrationEmail($user);

        return [
            'message' => 'Thank you for registration. Please check your inbox for verification email.',
            'accessToken' => $accessToken->access_token
        ];
    }

    /**
     * Logins user via api.
     *
     * @return string
     */
    public function loginApi(): array
    {
        $request = Yii::$app->request->post();
        $user = User::findByEmail($request['email']);
        $accessToken = new AccessToken();
        
        if(!$user || !$user->validatePassword($request['password'])) {
            return ['success' => false];
        }

        $transaction = Yii::$app->db->beginTransaction();

        AccessToken::deleteAll(['user_id' => $user->id]);
        $accessToken->user_id = $user->id;
        $accessToken->setAccessToken();
        $accessToken->save();

        $transaction->commit();
        
        return [
            'success' => true,
            'accessToken' => $accessToken->access_token
        ];
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    private function sendSuccessfullRegistrationEmail(User $user): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
?>