<?php

namespace common\components\traits;

use Yii;
use yii\web\Response;

trait ApiResponse {
    private function getResponse(bool $success, array|string $message = '', int $code = 200) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $code;

        $response = [
            'success' => $success
        ];
        
        if($message) {
            if(is_array($message)) {
                $response = array_merge($response, $message);
            } else {
                $response['message'] = $message;
            }
        };
        
        return $response;
    }

    private function jsonSuccessResponse($message = '') {
        return $this->getResponse(true, $message);
    }

    private function jsonFailureResponse($message = false, $code = 500) {
        return $this->getResponse(false, $message, $code);
    }

    private function accessErrorResponse() {
        return $this->getResponse(false, 'Access error', 403);
    }

    private function jsonValidationResponse($errors) {
        if(!$errors) $errors = 'No request fields provided';
        return $this->getResponse(false, ['errors' => $errors], 403);
    }
}
?>