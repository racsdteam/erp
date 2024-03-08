<?php

namespace frontend\modules\assets0\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `hr` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
   
}
