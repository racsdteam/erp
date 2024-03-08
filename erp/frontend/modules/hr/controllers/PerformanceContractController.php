<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PerformanceContract;
use frontend\modules\hr\models\PcTarget;
use frontend\modules\hr\models\PcCompanyTarget;
use frontend\modules\hr\models\PcUnitTarget;
use frontend\modules\hr\models\PcEmployeeTarget;
use frontend\modules\hr\models\PcTargetLevelScore;
use common\models\UserHelper;
use common\models\ErpPersonInterim;
use common\models\ErpUnitsPositions;
use common\models\ApprovalRequest ;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * PerformanceAppraisalController implements the CRUD actions for PerformanceAppraisal model.
 */
class PerformanceContractController extends Controller
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

    /**
     * Lists all PerformanceAppraisal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PerformanceContract::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PerformanceAppraisal model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewPdf($id)
    {
        $model=$this->findModel($id);
        $wf=Yii::$app->wfManager->findWorkFlow($model);
        return $this->render('page-viewer1', [
            'model' => $model,'wf' => $wf,
        ]);
    }
   public function actionView($id)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
  public function actionDraft()
    {
        return $this->render('draft');
    }
      public function actionPending()
    {
        return $this->render('pending');
    }
       public function actionApproved()
    {
        return $this->render('approved');
    }
         public function actionMyPc()
    {
        return $this->render('my_pc');
    }
      public function actionPdfData($id)
    {
   $url = "css/kv-mpdf-bootstrap.min.css";
          $stylesheet = file_get_contents($url);
          
          $url1 = "css/mpdf.css";
          $stylesheet1 = file_get_contents($url1);
           
          //$url2 = "css/prince-bootstrap-grid-fix.css";
         // $stylesheet2 = file_get_contents($url2);
          
        $mpdf = new \Mpdf\Mpdf(['format' =>'A4']);
        //----------------------------add bootsrap classes---------------------------
       $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
       //------------------------bootsr grid system---------------------------------
        $mpdf->WriteHTML($stylesheet1, \Mpdf\HTMLParserMode::HEADER_CSS);
       //---------------------make us eof font awesome----------------------------
       $mpdf->WriteHTML('.fa { font-family: fontawesome;}',1);
        //-----------------prevent body overlapping footer-----------------------------------------     
         
         $mpdf->setAutoBottomMargin = 'stretch';
         
     //------------------fix image not showing---------------------------------------------------    
         //$mpdf->showImageErrors = true;
         $mpdf->curlAllowUnsafeSslRequests = true;
       //-----------------sett footer------------------------------
        $mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
        $mpdf->SetCompression(false);
        $mpdf->autoPageBreak = true;
         $mpdf->WriteHTML($this->renderPartial('view2', [
            'model' => $this->findModel($id),]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
    
 public function actionStartApproval($id){
    
       //-----------Payload---------------
       $model= PerformanceContract::findOne($id); 
       //----------find workflow definition----------
       $approvalRequest=new ApprovalRequest();
       
      
      $goBack=function()use($model){
        return  $this->redirect(['view', 'id'=>$model->id]);
      }; 
       
        if(Yii::$app->request->post()){
         
         //-----inputs----------------------------------------   
        $approvalRequest->attributes=$_POST['ApprovalRequest'];
        $approvalRequest->entityRecord=$model;
        $approvalRequest->initiator=Yii::$app->user->identity->user_id;
     
         
         //----------wf instance--------------------------------------
         $wfInstance =Yii::$app->wfManager->createWorkflowInstance($approvalRequest);
         if($wfInstance==null){
          Yii::$app->session->setFlash('error',"Unable to  start approval ! , please contact administrator"); 
          return $goBack();    
          }
         
         
         if(!$wfInstance->isRunning()){
             
             
             $res=$wfInstance->run();
            
             if($res['status']!='success'){
              
               Yii::$app->session->setFlash('error',$res['error']); 
              
               
             }
             else{
                $model->status='processing';
                $model->save(false);
                Yii::$app->session->setFlash('success',"Imihigo form has been submited for approval !");  
             }
              
             
         }   
            else{
               
                Yii::$app->session->setFlash('error',"Imihigo form already submited for approval !"); 
              
           }    
           
           
            return $goBack();
          
          
         
          
           }
      
       
    if(Yii::$app->request->isAjax){
         
         return $this->renderAjax('start-approval', [
            'approvalRequest' =>$approvalRequest,'model'=>$model
        ]);   
           
       }
        return $this->render('start-approval', [
            'approvalRequest' =>$approvalRequest,'model'=>$model
        ]);  
        
    }
    
    public function actionApprovalHistory($id){
        
 $request=Yii::$app->request;
 
 if ($request->isAjax) {
       
       
            return   $this->renderAjax('approval-history',['model' => $this->findModel($id),'wf'=>$request->get('wf')]);
     
     
         }
         else{
             
              return $this->render('approval-history',['model' => $this->findModel($id),'wf'=>$request->get('wf')]);
         }

    } 
     
    /**
     * Creates a new PerformanceAppraisal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
          $model = new PerformanceContract();
          $companyTargetModels = [new PcCompanyTarget];
          $unitTargetModels = [new PcUnitTarget];
         $employeeTargetModels  = [new PcEmployeeTarget];
          $scoretModel = new PcTargetLevelScore;
         
      if (Yii::$app->request->post()) {
            $data=Yii::$app->request->post();
               
            $levelScores=$data['PcTargetLevelScore'];
           
            
            
            $companyTargets=$data['PcCompanyTarget'];
            // var_dump($companyTargets);die();
            $unitTargets=$data['PcUnitTarget'];
            $employeeTargets=$data['PcEmployeeTarget'];
            
            
            $user=Yii::$app->user->identity->user_id;
            $position=UserHelper::getPositionInfo($user);
            $userLevel= ErpUnitsPositions::find()->where(["position_id"=>$position['id']])->one();
            $this_year=date("Y");
            $next_year=$this_year+1;
            
            
            $model->user_id=$user;
            $model->emp_pos=$position['position_code'];
            $model->financial_year=$this_year.'-'.$next_year;
            $model->position_level=$userLevel->position_level;
            $model->created=date("Y-m-d");
         
             if($model->save(false))
             {
                 if(!empty($levelScores))
                 {
                     foreach($levelScores as $levelScore)
                     {
                         $modelscore= new PcTargetLevelScore;
                         $modelscore->pc_id =$model->id;
                         $modelscore->score_percentage =$levelScore['score_percentage'];
                         $modelscore->type =$levelScore['type'];
                         $modelscore->save(false);
                     }
                 }
                 
                  if(!empty($companyTargets))
                 {
                     foreach($companyTargets as $companyTarget)
                     {
                         $modelTarget= new PcTarget;
                         $modelTarget->pa_id =$model->id;
                         $modelTarget->output =$companyTarget['output'];
                         $modelTarget->indicator =$companyTarget['indicator'];
                         $modelTarget->type="organisation level";
                         $modelTarget->kpi_weight=$companyTarget['PKI'];
                         $modelTarget->save(false);
                     }
                 }
                   if(!empty($unitTargets))
                 {
                     foreach($unitTargets as $unitTarget)
                     {
                         $modelTarget= new PcTarget;
                         $modelTarget->pa_id =$model->id;
                         $modelTarget->output =$unitTarget['output'];
                         $modelTarget->indicator =$unitTarget['indicator'];
                         $modelTarget->type='department level';
                         $modelTarget->kpi_weight=$unitTarget['PKI'];
                         $modelTarget->save(false);
                     }
                 }
                    if(!empty($employeeTargets))
                 {
                     foreach($employeeTargets as $employeeTarget)
                     {
                         $modelTarget= new PcTarget;
                         $modelTarget->pa_id =$model->id;
                         $modelTarget->output =$employeeTarget['output'];
                         $modelTarget->indicator =$employeeTarget['indicator'];
                         $modelTarget->type='employee level';
                          $modelTarget->kpi_weight=$employeeTarget['PKI'];
                         $modelTarget->save(false);
                     }
                 }
             }
            return $this->redirect(['view', 'id' => $model->id]);
            
            
        }

        return $this->render('create', [
            'model' => $model,'companyTargetModels' => $companyTargetModels,'unitTargetModels' => $unitTargetModels,
            'employeeTargetModels' => $employeeTargetModels, 'scoretModel' => $scoretModel,
        ]);
    }

    /**
     * Updates an existing PerformanceAppraisal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            
            
            var_dump(Yii::$app->request->post());die();
            return $this->redirect(['view', 'id' => $model->id]);
            
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PerformanceAppraisal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['draft']);
    }

    /**
     * Finds the PerformanceAppraisal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PerformanceAppraisal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PerformanceContract::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
