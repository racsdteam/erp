<?php

namespace frontend\modules\operations\controllers;

use Yii;
use frontend\modules\operations\models\AerodromeConditionReport;
use frontend\modules\operations\models\AerodromeSegmentReport;
use frontend\modules\operations\models\AerodromeSegment;
use frontend\modules\operations\models\AerodromeInfo;
use common\models\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * AerodromeConditionReportController implements the CRUD actions for AerodromeConditionReport model.
 */
class AerodromeConditionReportController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            
             'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                 [
                        'actions' => ['last-report','check-last-report'],
                        'allow' => true,
                    ],
                   [
        'actions' => ['index'],
        'allow' => true,
        'matchCallback' => function ($rule, $action) {
            return \Yii::$app->user->identity->isAdmin();
        },
    ],
                ],
                 ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AerodromeConditionReport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AerodromeConditionReport::find()->orderBy([ 'date' => SORT_DESC]),
             'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
          public function actionLastReport($aerodrome)
    {
         $model= AerodromeConditionReport::find()->where(["status"=>AerodromeConditionReport::SHARED,"aerodrome"=>$aerodrome])
            ->orderBy([ 'date' => SORT_DESC])->one();
        return $this->render('atc', [
            'model' => $model,
        ]);
    }
    
       public function actionCheckLastReport($aerodrome)
    {
         $model= AerodromeConditionReport::find()->where(["status"=>AerodromeConditionReport::SHARED,"aerodrome"=>$aerodrome])
            ->orderBy([ 'date' => SORT_DESC])->one();
            $data["id"]=$model->id;
        return json_encode($data);
    }
      public function actionNotShared()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AerodromeConditionReport::find()->where(["status"=>AerodromeConditionReport::NOT_SHARED])
            ->orderBy([ 'date' => SORT_DESC]),
        ]);

        return $this->render('not-shared', [
            'dataProvider' => $dataProvider,
        ]);
    }
 public function actionShared()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AerodromeConditionReport::find()->where(["status"=>AerodromeConditionReport::SHARED])
            ->orderBy([ 'date' => SORT_DESC]),
             'pagination' => false,
        ]);

        return $this->render('shared', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AerodromeConditionReport model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
           $aerodromeSegmentReport=new AerodromeSegmentReport;
        return $this->render('view', [
            'model' => $this->findModel($id), 'aerodromeSegmentReport' => $aerodromeSegmentReport
        ]);
    }
   
        public function actionAddSegmentReport($id)
    {
        
         $aerodromeSegmentReports = [new AerodromeSegmentReport];
         
        if (Yii::$app->request->post()) {
            
               $aerodromeSegmentReports= Model::createMultiple(AerodromeSegmentReport::classname());
                 Model::loadMultiple($aerodromeSegmentReports , Yii::$app->request->post()); 
  
  if(count($aerodromeSegmentReports)==3){
  //---------------------------------check items------------------------------------------------------               
                 if(!empty($aerodromeSegmentReports)){
                     
                     
                 
                    $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                     
                        foreach ($aerodromeSegmentReports as $model) {
                           
                               
                                 if($model !=new AerodromeSegmentReport()){
                                
                                $model->report_id =$id ;
                                $model->user_id=Yii::$app->user->identity->user_id;
                            if (! ($flag = $model->save(false))) {
                                $transaction->rollBack();
                               
                                Yii::$app->session->setFlash('failure',Html::errorSummary($model));  
                                  
                            }
                        }
                    
                }
                    if ($flag) {
                        $transaction->commit();
                      
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
                  }
        }
  else {
 
      Yii::$app->session->setFlash('failure',"Report all the Sequements of the Runway");               
  };
          
        }
        return $this->redirect(['view',"id"=>$id]);
    }
    
    /**
     * Creates a new AerodromeConditionReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AerodromeConditionReport();
        $aerodromes= AerodromeInfo::find()->all();
if(Yii::$app->request->post()){
                $exclude_weekens=true;
              $user_id=Yii::$app->user->identity->user_id;
             $model->attributes=$_POST['AerodromeConditionReport'];
               $date = new \DateTime($model->date);
               $date->modify('-2 hours');
               $model->date= $date->format('Y-m-d H:i:s'); 
              $model->user_id=$user_id;
              $flag=$model->save();
             if($flag)
            return $this->redirect(['not-shared']);
        }
if(Yii::$app->request->isAjax){
        return $this->renderAjax('create', [
            'model' => $model, 'aerodromes'=>$aerodromes
        ]);
}
  return $this->render('create', [
            'model' => $model, 'aerodromes'=>$aerodromes,
        ]);
    }

    /**
     * Updates an existing AerodromeConditionReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $aerodromes= AerodromeInfo::find()->all();
       if(Yii::$app->request->post()){
                $exclude_weekens=true;
              $user_id=Yii::$app->user->identity->user_id;
             $model->attributes=$_POST['AerodromeConditionReport'];
               $date = new \DateTime($model->date);
               $date->modify('-2 hour');
               $model->date= $date->format('Y-m-d H:i:s'); 
              $model->user_id=$user_id;
              $flag=$model->save();
               if($flag)
            return $this->redirect(['not-shared']);
        }
if(Yii::$app->request->isAjax){
        return $this->renderAjax('update', [
            'model' => $model, 'aerodromes'=>$aerodromes,
        ]);
}
return $this->render('update', [
            'model' => $model, 'aerodromes'=>$aerodromes,
        ]);
    }


    public function actionShare($id)
    {
        $model = $this->findModel($id);
         $tos=[["atm@rac.co.rw"=>"ATC Rwanda"],["notam@rac.co.rw"=>"NOTAM Rwanda"],["grf@rac.co.rw"=>"GRF Rwanda"],["operations@rac.co.rw"=>"Operations Rwanda"],["abahati@caa.gov.rw"=>"Bahati Alexander"],["kiaatm@asecna.org"=>"ATC ASECNA"]];
    
    foreach($tos as $to)
    {
       $this->sendEmail($to,$model);
    }
         $model->status="shared";
          $flag= $model->save();
      return $this->redirect(['shared']);
        
    }

    public function actionDelete($id)
    {
        $model= $this->findModel($id)->delete();
        return $this->redirect(['not-shared']);
    }

    /**
     * Finds the AerodromeConditionReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AerodromeConditionReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AerodromeConditionReport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
   
   
   protected function sendEmail($to,$model){
    $segments=ArrayHelper::map(AerodromeSegment::find()->where(["aerodrome"=>$model->aerodrome])->all(), 'id','segment_name') ;
    $flag1= Yii::$app->mailer->compose( ['html' =>'rcrEmail-html'],
    [
    'model'=>$model,'segments'=>$segments
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo($to)
->setSubject('Runway Condition Report Email')
->send();
   return $flag1;
     
     
 }
 
 
}
