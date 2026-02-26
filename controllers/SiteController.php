<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * Health check
     * @return array
     */
    public function actionHealth()
    {
        return ['success' => true];
    }
}
