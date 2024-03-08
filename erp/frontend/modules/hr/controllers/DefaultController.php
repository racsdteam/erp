<?php

namespace frontend\modules\hr\controllers;

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
    
    public function actionTest(){
        
       $arr=array("niyonizera Norbert","Mugisha Janvier");
       if (in_array("Niyonizera Norbert", $arr)) {
    var_dump("Got him") ;
}else{
    
    var_dump("not in ") ;
}
        
    }
}
