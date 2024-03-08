<?php
namespace console\controllers;

use Yii;
use yii\web\Controller;



/**
 * Site controller
 */
class DocExpiryController extends Controller
{
     
    

    public function actionSetExpiry()
    {
        
        
     //---------------------------------------memo-------------------------------------------------------------------  
              $today=date('Y-m-d');
             
             $condition = ['and',
    
    ['<>','expiration_date',null],
    ['<', 'expiration_date', $today],
    ['<>', 'status', 'approved']
   
];

              Yii::$app->db->createCommand()
            ->update('erp_memo', ['status' =>'expired'], $condition)->execute();
            
           

           

            echo "service running";
            
    //-----------------------------------------doc---------------------------------------------------------- 
    
   
              Yii::$app->db->createCommand()
            ->update('erp_document', ['status' =>'expired'], $condition)->execute();  


            
            echo "service running";
       
    }
//-----------------disable csrf validation-------------------------------------------
    public function beforeAction($action)
{      
    if ($this->action->id == 'set-expiry') {
        $this->enableCsrfValidation = false;
    }
    return true;
}

   
}