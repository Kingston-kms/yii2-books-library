<?php

namespace rest\controllers;

use rest\components\CustomCors;

class BaseController extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => CustomCors::class,
            'cors' => [
                'Origin' => ['*']
            ]
        ];
        return $behaviors;
    }

    public function actionError(): \yii\web\Response
    {
        return $this->asJson(['status' => 'error', 'message' => 'error']);
    }
}
