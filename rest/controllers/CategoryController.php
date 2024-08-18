<?php

namespace rest\controllers;

class CategoryController extends BaseController
{

    public function actionIndex(): \yii\web\Response
    {
        return $this->asJson([
            ['title' => 'Everest 1'],
            ['title' => 'Everest 2']
        ]);
    }
}
