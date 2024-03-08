<?php

namespace frontend\modules\racdms\controllers;

use yii\web\Controller;

/**
 * Default controller for the `dms` module
 */
class DefaultController extends Controller
{
    
    public $showSideMenu=false;
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {   
        $this->view->params['showSideMenu'] =$showSideMenu;
        return $this->render('index');
    }
   
    public function actionAdmin()
    {
       
       $this->view->params['showSideMenu'] =true;
       return $this->render('admin-tools');
    }
}
