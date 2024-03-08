<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\ProcurementPlans;
use frontend\modules\procurement\models\ProcurementActivityDates;
use frontend\modules\procurement\models\ProcurementPlansSearch;
use common\models\ApprovalRequest ;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\filters\AccessControl;
date_default_timezone_set('Africa/Cairo');
/**
 * ProcurementPlansController implements the CRUD actions for ProcurementPlans model.
 */
class ProcurementPlansController extends Controller
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
                     'delete-fuel-out' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProcurementPlans models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcurementPlansSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
   
     public function actionPlanning()
    {
        $searchModel = new ProcurementPlansSearch();
        $dataProvider = $searchModel->search([$searchModel->formName()=>['status'=>'Planning']]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
     public function actionSubmitted()
    {
        $searchModel = new ProcurementPlansSearch();
        $params=[];
        if(!Yii::$app->user->identity->isAdmin())
        $params['user']=Yii::$app->user->identity->user_id;
        $params['status']='Pending Approval';
        $dataProvider = $searchModel->search([$searchModel->formName()=>$params]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
     
     
      
     public function actionApproved()
    {
        $searchModel = new ProcurementPlansSearch();
        $params=[];
        if(!Yii::$app->user->identity->isAdmin())
        $params['user']=Yii::$app->user->identity->user_id;
        $params['status']='Approved';
        $dataProvider = $searchModel->search([$searchModel->formName()=>$params]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
     

  public function actionTest(){
      
      $currentYear=date('Y');
      $dates=range($currentYear,$currentYear+10);
      
      foreach($dates as $date){
          
           if (date('m', strtotime($date)) <= 7) {//Upto July
        $year = ($date-1) . '-' . $date;
    } else {//After July
        $year = $date . '-' . ($date + 1);
    }
    
    var_dump($year);
      } 
      
  }
  
     
    
    /**
     * Displays a single ProcurementPlans model.
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
  public function actionViewPdf($id)
    {
        $request=Yii::$app->request;
        $approval_id=$request->get("approval_id");
        
        if($request->isAjax){
            $html= $this->renderAjax('view-pdf', [
            'model' => $this->findModel($id),"approval_id"=>$approval_id
        ]);
        return Json::encode($html);
        }
        
      return   $this->render('view-pdf', [
            'model' => $this->findModel($id),"approval_id"=>$approval_id
        ]);
    }
    
    
      public function actionPdfData($id)
    {    $request=Yii::$app->request;
         $approval_id=$request->get("approval_id");
          $cssFile = file_get_contents("css/mpdf-proc-app.css");
          $htmlHeader='<table style="width:100%;" id="maintable" cellspacing="0" cellpadding="0">
<tr>
<td align="left"><img src="img/logo.png" height="100px"></td>
<td style="padding:20 0px" align="right"><img src="img/rightlogo.png" height="100px"></td>

</tr>
</table>';

$footerHtml='<div style="text-align: center;">{PAGENO}</div>';
           
        $mpdf = new \Mpdf\Mpdf(['format' =>'A4','orientation'=>'L','mode' => 'UTF-8',]);
        //----------------------------add bootsrap classes---------------------------
        $mpdf->WriteHTML($cssFile, \Mpdf\HTMLParserMode::HEADER_CSS);
       //---------------------make us eof font awesome----------------------------
      
      //---------prevent body overlapping footer----------------
         $mpdf->setAutoBottomMargin = 'stretch';
       //---------prevent body overlapping header----------------  
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->SetCompression(false);
        $mpdf->autoPageBreak = true;
        $mpdf->shrink_tables_to_fit=0;
       
       //-----------------sett footer------------------------------
      //$mpdf->SetHTMLFooter('<div style="text-align:center"><img src="img/footer.png"/></div>');
        //$mpdf->SetHTMLHeader($htmlHeader);
       // $mpdf->SetHTMLFooter($footerHtml);
       
      //hack display header on the first page only 
        $mpdf->WriteHTML(' ');

        $mpdf->SetHTMLHeader(''); 
       //set your footer
       $mpdf->SetHTMLFooter($footerHtml);
        
        $mpdf->WriteHTML($this->renderPartial('_pdf-content', [
            'model' => $this->findModel($id),"approval_id"=>$approval_id]));
      $fileName=$model->name.'pdf';    
       $content= $mpdf->Output($fileName,'S'); //returns the PDF document as a string
       return $content;
        exit;
    }
    /**
     * Creates a new ProcurementPlans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProcurementPlans();

       
        if ($model->load(Yii::$app->request->post())) {
            
            if($model->save()){
             Yii::$app->session->setFlash('success','Procurement Plan Saved !');
             return $this->redirect(['index']);
             
            }
            else{
       
              Yii::$app->session->setFlash('error',Html::errorSummary($model));
               
            }
            
           
        }
      
       if(Yii::$app->request->isAjax){
         
         return $this->renderAjax('create', [
            'model' => $model,
        ]);   
           
       }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProcurementPlans model.
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
     * Deletes an existing ProcurementPlans model.
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
    
    public function actionStartApproval($id){
    
       $approvalRequest=new ApprovalRequest();
       $model= $this->findModel($id); 
    
       
      if(Yii::$app->request->post()){
         
          
        $approvalRequest->attributes=$_POST['ApprovalRequest'];
        $approvalRequest->entityRecord=$model;
        $approvalRequest->initiator=Yii::$app->user->identity->user_id;
       
         try{
            //----------wf instance--------------------------------------
          $wfInstance =Yii::$app->wfManager->createWorkflowInstance($approvalRequest);
         
         if($wfInstance==null){
          
           throw new UserException("Unable to  start approval ! , please contact administrator");  
          }
         
         if($wfInstance->isRunning()){
           
            throw new UserException("Annual Procurement Plan  already submited for approval ");  
             
         } 
         
         $res=$wfInstance->run();
         
         if($res['status']!='success'){
              
                throw new UserException($res['error']);  
              
               }
               
           $model->status='Pending Approval';
           $model->save(false);
           $model->trigger(ProcurementPlans::EVENT_REQUEST_SUBMISSION);     
           Yii::$app->session->setFlash('success',"Annual Procurement Plan has been submited for approval !");
           return  $this->redirect(['planning']);
         }
         
         catch(UserException $e){
           Yii::$app->session->setFlash('error',$e->getMessage());     
          return  $this->redirect(['view-pdf', 'id'=>$model->id]);    
         }
         
        
           
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
        
        
 if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('approval-history',['model' => $this->findModel($id)]);
     
     
         }
         else{
             
              return $this->render('approval-history',['model' => $this->findModel($id)]);
         }

    } 

    /**
     * Finds the ProcurementPlans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProcurementPlans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProcurementPlans::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
