<?php

namespace crm\front\controllers;

use yii\web\Controller;

class EventController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
