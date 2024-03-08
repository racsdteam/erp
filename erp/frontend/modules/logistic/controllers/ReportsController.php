<?php

namespace frontend\modules\logistic\controllers;

class ReportsController extends \yii\web\Controller
{
    public function actionActualStock()
    {
             if(!empty($_POST))
       {
           $date=$_POST['date'];
       }else{
            $date=date("Y-m-d");
       }
        return $this->render('actual',['date' => $date,]);
    }
      public function actionItemHistory()
    {
             if(!empty($_POST))
       {
          
           $item=$_POST['item'];
           $sdate=$_POST['sdate'];
           $edate=$_POST['edate'];
           
       }
        return $this->render('itemhistory',['edate' => $edate,'sdate' => $sdate,'item' => $item,]);
    }
    
       public function actionFuel()
    {
             if(!empty($_POST))
       {
          
           $sdate=$_POST['sdate'];
           $edate=$_POST['edate'];
           
       }
        return $this->render('fuel',['edate' => $edate,'sdate' => $sdate,]);
    }
    
       public function actionReceived()
    {
             if(!empty($_POST))
       {
          
           $sdate=$_POST['sdate'];
           $edate=$_POST['edate'];
           
       }
        return $this->render('received',['edate' => $edate,'sdate' => $sdate,]);
    }
    
          public function actionDistributed()
    {
             if(!empty($_POST))
       {
          
           $sdate=$_POST['sdate'];
           $edate=$_POST['edate'];
           
       }
        return $this->render('distributed',['edate' => $edate,'sdate' => $sdate,]);
    }
            public function actionInventory()
    {
             if(!empty($_POST))
       {
          
           $sdate=$_POST['sdate'];
           $edate=$_POST['edate'];
           
       }
        return $this->render('inventory',['edate' => $edate,'sdate' => $sdate,]);
    }
}
