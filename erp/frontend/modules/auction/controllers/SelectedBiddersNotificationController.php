<?php

namespace frontend\modules\auction\controllers;

use Yii;
use frontend\modules\auction\models\SelectedBiddersNotification;
use frontend\modules\auction\models\SelectedBiddersNotificationSearch;
use frontend\modules\auction\models\Bids;
use frontend\modules\auction\models\Lots;
use frontend\modules\auction\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SelectedBiddersNotificationController implements the CRUD actions for SelectedBiddersNotification model.
 */
class SelectedBiddersNotificationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
      public function actionNotify(){
      
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
        
        if(Yii::$app->request->isAjax){
          
          $selected=json_decode($_POST['selected']);
          $lotNo=$_POST['lot'];
          $lot=Lots::find()->where(['lot'=>$lotNo])->One();
          
        
          
          if(!empty( $selected)){
              
            foreach($selected as $index=>$bidder){
            
         
              $bid=Bids::find()->where(['user'=>$bidder->user_id,'item'=>$lot->id])->One();
              
            
              $notif['recipient_name']=$bidder->first_name." ".$bidder->last_name; 
              $notif['recipient_email']=$bidder->email;
              $notif['bidder']=$bidder->user_id; 
              $notif['lot']=$lotNo; 
              $notif['bid_code']=$bid->bid_code;
              $notif['auction_date']=$lot->auction_date;
              $notif['auction_location']=$lot->Location();
              
               if(!$this->notifyBidder($notif)){
                 break;  
                 return ['flag'=>false,'msg'=>'bidder '.$notif['recipient_name'].' could not be notified !'];  
                }
                 
                 $bid->selected=1;
                 $bid->notified=1;
                 $bid->save(false);
                 
                 $this->logNotification($notif) ;
                 
                 
                    
               
             
           }
          
          return ['flag'=>true,'msg'=>'Selected bidders have been  notified !'];  
              
          }
        
         
            
            
        }
       
  }
  
public function notifyBidder($notif){
    
    $sent= Yii::$app->mailer->compose( ['html' =>'selbidderNotification-hml'],
    [
        'recipient' =>$notif['recipient_name'],
        'lot'=>$notif['lot'],
        'bid_code'=>$notif['bid_code'],
        'auction_date'=>$notif['auction_date'],
        'auction_location'=>$notif['auction_location'],
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC AUCTION SYSTEM'])
->setTo([$notif['recipient_email']])
->setSubject('RAC AUCTION Notification')
->send();

return $sent;
}

public function logNotification($notif){
                   $model=new SelectedBiddersNotification();
                   $model->bidder=$notif['bidder'];
                   $model->lot=$notif['lot'];
                   $model->notified=1;
                   $model->notifier=Yii::$app->user->identity->user_id; 
                  
                   if(!$model->save()){
                        return false;
                   }else{
                        return true;
                   }
                  
                  
}






    /**
     * Lists all SelectedBiddersNotification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SelectedBiddersNotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SelectedBiddersNotification model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SelectedBiddersNotification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SelectedBiddersNotification();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SelectedBiddersNotification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SelectedBiddersNotification model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SelectedBiddersNotification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SelectedBiddersNotification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SelectedBiddersNotification::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
