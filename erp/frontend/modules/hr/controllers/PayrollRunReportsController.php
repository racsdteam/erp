<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayrollRunReports;
use frontend\modules\hr\models\PayrollRunReportsSearch;
use frontend\modules\hr\models\ReportTemplates;
use frontend\modules\hr\models\PayrollRunReportAttachments;
use frontend\modules\hr\models\ PayrollRunReportParams;
use frontend\modules\hr\models\BankListReportExporter;
use common\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;


 

/**
 * PayrollRunReportsController implements the CRUD actions for PayrollRunReports model.
 */
class PayrollRunReportsController extends Controller
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
     * Lists all PayrollRunReports models.
     * @return mixed
     */
    public function actionIndex()
    {     
         $rpt=ReportTemplates::find()->orderBy('id ASC')->limit(1)->all();
         
          $searchModel = new PayrollRunReportsSearch();
          $dataProvider = $searchModel->search([$searchModel->formName()=>['rpt_type'=>$rpt[0]->code]]);
         
          
      $content1=$this->renderAjax('report-list', [
          'dataProvider' => $dataProvider,
          'rptType'=>$rpt[0]->code
        ]);

        return $this->render('index',['content1'=>$content1]);
    }
    
    public function actionReportsList($type){
      
        $searchModel = new PayrollRunReportsSearch();
        $dataProvider = $searchModel->search([$searchModel->formName()=>['rpt_type'=>$type]]);  
       $html=$this->renderAjax('report-list', [
          'dataProvider' => $dataProvider,
          'rptType'=>$type
        ]);
        
        return Json::encode($html);
        
    } 


    /**
     * Displays a single PayrollRunReports model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {      $request=Yii::$app->request;
           $model=$this->findModel($id);
           $params=array();
           
           $params['wf']=$request->get("wf");
           $params['model']=$model;
           $params['approval']=$request->get("approval_id");
         
          $content= $model->generate()->render();
     
       
        return  $this->render('view', [
            'model' => $model,'content'=>$content
        ]); 
     
    }
    
    //calls pdf-data
      public function actionViewPdf($id)
    {
        $request=Yii::$app->request;
      
        $model=$this->findModel($id);
        
        
        if($request->isAjax){
            $html= $this->renderAjax('pdf', [
            'model' => $model,'wf'=>$request->get("wf")
        ]);
        return Json::encode($html);
        }
          $html= $this->render('view-pdf', [
            'model' => $model,
        ]);
        return $html;
    }
    
    //calls pdf-data
      public function actionPdf($id)
    {
        $request=Yii::$app->request;
      
        $model=$this->findModel($id);
        
        
        if($request->isAjax){
            $html= $this->renderAjax('pdf', [
            'model' => $model,'wf'=>$request->get("wf"),'approval_id'=>$request->get("approval_id")
        ]);
        return Json::encode($html);
        }
          $html= $this->render('pdf', [
            'model' => $model,$model,'wf'=>$request->get("wf"),'approval_id'=>$request->get("approval_id")
        ]);
        return $html;
    }
    
      public function actionPdfData($id)
    {      $request=Yii::$app->request;
    
           $model=$this->findModel($id);
           
           $params=array();
           $params['wf']=$request->get("wf");
           $params['model']=$model;
           $params['approval']=$request->get("approval_id");
         
           $html= $model->generate()->render();
       
          
          $cssFile = file_get_contents("css/mpdf-custom.css");
           
       $htmlHeader='<table style="width:100%;" id="maintable" cellspacing="0" cellpadding="0">
<tr>
<td align="left"><img src="img/logo.png" height="100px"></td>
<td style="padding:20 0px" align="right"><img src="img/rightlogo.png" height="100px"></td>

</tr>
</table>';

$footerHtml='<div style="text-align: center;">{PAGENO}</div>';
           
        $mpdf = new \Mpdf\Mpdf(['format' =>'A4','orientation'=>'L','mode' => 'UTF-8']);
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
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($footerHtml);
       
      //hack display header on the first page only 
        $mpdf->WriteHTML(' ');

        $mpdf->SetHTMLHeader(''); 
       //set your footer
       $mpdf->SetHTMLFooter($footerHtml);
        
        $mpdf->WriteHTML($html);
        $fileName=$model->rpt_desc.'pdf';
       $content= $mpdf->Output($fileName,'S');
       return $content;
        exit;
    }
  
  
      
    public function actionTest(){
   
        
/*$rows=\Yii::$app->db4->createCommand("CALL sp_paye_salaried(:pay_group, :period_year, :period_month)") 
                      ->bindValue(':pay_group' , 1)
                      ->bindValue(':period_year', 2022)
                      ->bindValue(':period_month', '02')
                      ->queryAll();
        $val=$rows[0]['tags'];           
                      var_dump(json_decode($val,true));*/
 /*  foreach( PayrollRunReports::find()->all() as $model){
       
    if($model->id!=60){
      $model->modelParams->period_month =$model->period_month; 
      $model->modelParams->period_year =$model->period_year; 
      $model->modelParams->pay_group =Json::decode($model->pay_group,true); 
      $model->modelParams->pay_type =$model->list_type; 
      $model->modelParams->paye_basis =$model->pay_basis; 
      $model->params=Json::encode($model->modelParams,JSON_UNESCAPED_SLASHES);
      $model->save(false);
        
      }   
       
   }*/
   
                      
  $model=PayrollRunReports::findOne(51); 
  //var_dump($model->generate()->dbData);
  return $model->generate()->render();
                      
    }
    public function actionListByType(){
   
    $rptType=Yii::$app->request->get('rpt_type');
    $searchModel = new PayrollRunReportsSearch();
    $dataProvider = $searchModel->search([$searchModel->formName()=>['rpt_type'=>$rptType]]);
    
      $html=$this->renderAjax('index-partial', [
          'dataProvider' => $dataProvider,
          'rptType'=>$rptType
        ]);
      return Json::encode($html) ;    
    }

  

   public function actionExportToExcel($id){
   
      
      $model=$this->findModel($id);
       
       switch($model->rpt_type){
           
           case 'BL':
                $exporter=new BankListReportExporter($model);
                $exporter->exportToExcel();
           
               break;
               
          default :
               
               var_dump("no report type found");
               die();
              
              
              
       }
        
/*  $inputfile="uploads/temp/62aae515485b8xlsx";
  $spreadsheet =  \PhpOffice\PhpSpreadsheet\IOFactory::load($inputfile);
  $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
  var_dump($sheetData);     
     */
    
    
            
    }
    

    /**
     * Creates a new PayrollRunReports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayrollRunReports();
        $modelParams= new PayrollRunReportParams();
        $modelsAttachment=[new PayrollRunReportAttachments];
        
        $request=Yii::$app->request;
        if($model->load($request->post()) ) {
            
          if($modelParams->load($request->post())){
              
            $model->params=Json::encode($modelParams,JSON_UNESCAPED_SLASHES);
              }
          
        //------------------------------------attchemts-------------------------------------------------------------------------
        $modelsAttachment = Model::createMultiple(PayrollRunReportAttachments::classname());
        Model::loadMultiple( $modelsAttachment , $request->post());
        
            $renderForm=function()use($model,$modelParams,$modelsAttachment){
               
             return $this->render('_form', [
            'model' => $model,'modelParams'=>$modelParams,
            'modelsAttachment' => (empty($modelsAttachment)) ? [new PayrollRunReportAttachments] : $modelsAttachment
        ]); 
                
            };
              $transaction = \Yii::$app->db4->beginTransaction();
               
               try{
                       
           
           if(!$model->save()){
            
          
             throw new UserException(Html::errorSummary($model));
          
             }
             
           foreach ($modelsAttachment as $i=>$attachModel) {
      
          
             //saving files for dyanamic forms
           $file[$i]=  UploadedFile::getInstanceByName("PayrollRunReportAttachments[".$i."][upload_file]");
     
 if( $file[$i]==null){
     
  throw new UserException("No Supporting Document(s) Found !");   
     
 }
  
                      $modelAttachement=new PayrollRunReportAttachments();
                      $modelAttachement->attributes=$attachModel->attributes;
                      $modelAttachement->report=$model->id;
                      $modelAttachement->dir=$savePath='uploads/payroll/reports/'.$model->id.'/';
                      $modelAttachement->fileName=$file[$i]->name;
                      $modelAttachement->fileType=$file[$i]->extension;
                      $modelAttachement->mimeType=$file[$i]->type;
                      $modelAttachement->user=Yii::$app->user->identity->user_id;
                      
                       if(!$modelAttachement->save(false)){
                 
             throw new UserException(Html::errorSummary($modelAttachement)); 
                   
                }
               $this->createDir($savePath);
               $file[$i]->saveAs($savePath.$modelAttachement->id.$file[$i]->extension);
                     
        
      
          }  
        
             
             $transaction->commit();
             Yii::$app->session->setFlash('success', "Payroll Run Report Saved!"); 
             return $this->redirect(['index']);
                       
                   
               }
               
                catch (UserException $e) {
                    $transaction->rollBack();
                     Yii::$app->session->setFlash('error',$e->getMessage()); 
                    return $renderForm(); 
                }
                 
                 catch (Exception $e) {
                    $transaction->rollBack();
                     return $renderForm(); 
                }
       
        }
        
      
        
        if(Yii::$app->request->isAjax)
         return $this->renderAjax('_form', [
            'model' => $model,'modelParams'=>$modelParams,
            'modelsAttachment' => (empty($modelsAttachment)) ? [new PayrollRunReportAttachments] : $modelsAttachment
        ]);
        return $this->render('_form', [
            'model' => $model,'modelParams'=>$modelParams,
             'modelsAttachment' => (empty($modelsAttachment)) ? [new PayrollRunReportAttachments] : $modelsAttachment
        ]);
    }

    /**
     * Updates an existing PayrollRunReports model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelParams= new PayrollRunReportParams();
        $modelsAttachment=$model->attachments;
        
        $request=Yii::$app->request;
    if($model->load($request->post()) ) {
        
         if($modelParams->load($request->post())){
            
            $model->params=Json::encode($modelParams,JSON_UNESCAPED_SLASHES);
              }
        //------------------------------------attchemts-------------------------------------------------------------------------
                 $oldIDs = ArrayHelper::map($modelsAttachment, 'id', 'id');
                 $modelsAttachment= Model::createMultiple(PayrollRunReportAttachments::classname(), $modelsAttachment);
                 Model::loadMultiple($modelsAttachment , $request->post()); 
                 $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAttachment, 'id', 'id')));
           
        
            $renderForm=function()use($model,$modelParams,$modelsAttachment){
               
             return $this->render('_form', [
            'model' => $model,'modelParams'=>$modelParams,
            'modelsAttachment' => (empty($modelsAttachment)) ? [new PayrollRunReportAttachments] : $modelsAttachment
        ]); 
                
            };
              $transaction = \Yii::$app->db4->beginTransaction();
               
               try{
                       $model->user=Yii::$app->user->identity->user_id;
           
           if(!$model->save()){
            
          
             throw new UserException(Html::errorSummary($model));
          
             }
             
             if (!empty($deletedIDs)) {
                        PayrollRunReportAttachments::deleteAll(['id' => $deletedIDs]);
                    }
             
           foreach ($modelsAttachment as $i=>$attachModel) {
      
          
             //saving files for dyanamic forms
           $file[$i]=  UploadedFile::getInstanceByName("PayrollRunReportAttachments[".$i."][upload_file]");
     
 if( $file[$i]==null){
     
  throw new UserException("No Supporting Document(s) Found !");   
     
 }
  
                      $modelAttachement=new PayrollRunReportAttachments();
                      $modelAttachement->attributes=$attachModel->attributes;
                      $modelAttachement->report=$model->id;
                      $modelAttachement->dir=$savePath='uploads/payroll/reports/'.$model->id.'/';
                      $modelAttachement->fileName=$file[$i]->name;
                      $modelAttachement->fileType=$file[$i]->extension;
                      $modelAttachement->mimeType=$file[$i]->type;
                      $modelAttachement->user=Yii::$app->user->identity->user_id;
                      
                       if(!$modelAttachement->save(false)){
                 
             throw new UserException(Html::errorSummary($modelAttachement)); 
                   
                }
               $this->createDir($savePath);
               $file[$i]->saveAs($savePath.$modelAttachement->id.$file[$i]->extension);
                     
        
      
          }  
        
             
             $transaction->commit();
             Yii::$app->session->setFlash('success', "Payroll Run Report Saved!"); 
             return $this->redirect(['index']);
                       
                   
               }
               
                catch (UserException $e) {
                    $transaction->rollBack();
                     Yii::$app->session->setFlash('error',$e->getMessage()); 
                    return $renderForm(); 
                }
                 
                 catch (Exception $e) {
                    $transaction->rollBack();
                     return $renderForm(); 
                }
       
        }
        
      
        
        if(Yii::$app->request->isAjax)
         return $this->renderAjax('_form', [
            'model' => $model,'modelParams'=>$modelParams,
            
            'modelsAttachment' => (empty($modelsAttachment)) ? [new PayrollRunReportAttachments] : $modelsAttachment
        ]);
        return $this->render('_form', [
            'model' => $model,'modelParams'=>$modelParams,
            'modelsAttachment' => (empty($modelsAttachment)) ? [new PayrollRunReportAttachments] : $modelsAttachment
        ]);
    }

    /**
     * Deletes an existing PayrollRunReports model.
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
     * Finds the PayrollRunReports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollRunReports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollRunReports::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
      protected function createDir($path){
        
        return FileHelper::createDirectory($path);
    }
    
    
}
