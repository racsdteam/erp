<?php

namespace frontend\modules\hr\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\Payrolls;
use frontend\modules\hr\models\PayrollsSearch;
use frontend\modules\hr\models\Payrolldata;
use frontend\modules\hr\models\EmpPayDetails;
use frontend\modules\hr\models\EmpPayAdditional;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\Payslips;
use frontend\modules\hr\models\PayslipItems;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\components\PaySlipCalculator;
use frontend\modules\hr\components\PayrollCalculator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Model;
use common\models\ErpOrgJobs;
use common\models\UserHelper;
use common\models\User;
use NXP\MathExecutor;
use frontend\modules\hr\models\PayItems;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\base\UserException;
use yii\db\Query;
use yii\helpers\Json;

$userinfo=UserHelper::getPositionInfo(Yii::$app->user->identity->user_id); 
$userposition=$userinfo['position_code'];
/**
 * PayrollsController implements the CRUD actions for Payrolls model.
 */
class PayrollsController extends Controller
{
   // public $enableCsrfValidation = false;

  
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            
              'access' => [
                'class' => AccessControl::className(),
                'only' => ['indexx'],
                'rules' => [
                 
                 [
        'actions' => ['indexx'],
        'allow' => true,
        'matchCallback' => function ($rule, $action) {
            return \Yii::$app->user->identity->isAdmin() || \Yii::$app->user->identity->isPayrollOfficer() || $userposition == "FATM";
        },
    ],
                ],
                 ],
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'include' => ['POST'],
                    'exclude' => ['POST'],
                    'finilise' => ['POST'],
                    'unlock' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Payrolls models.
     * @return mixed
     */
    public function actionIndex()
    {
       /* $searchModel = new PayrollsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
        
        return $this->render('index'); 
    }

    /**
     * Displays a single Payrolls model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      
      return $this->render('view', [
            'model' =>$this->findModel($id),
        ]); 
    }
    
     public function actionViewPdf($id)
    {
       return $this->render('view-pdf', [
            'model' =>$this->findModel($id),
        ]);
    }
     public function actionPdf($id)
    {
        $request=Yii::$app->request;
        $approval_id=$request->get("approval_id");
        
        if($request->isAjax){
            $html= $this->renderAjax('pdf', [
            'model' => $this->findModel($id),"approval_id"=>$approval_id
        ]);
        return Json::encode($html);
        }
        
      return   $this->render('pdf', [
            'model' => $this->findModel($id),"approval_id"=>$approval_id
        ]);
    }
    
    
      public function actionPdfData($id)
    {    $request=Yii::$app->request;
         $approval_id=$request->get("approval_id");
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
        
        $mpdf->WriteHTML($this->renderPartial('_pdf-content', [
            'model' => $this->findModel($id),"approval_id"=>$approval_id]));
      $fileName=$model->name.'pdf';    
       $content= $mpdf->Output($fileName,'S'); //returns the PDF document as a string
       return $content;
        exit;
    }
    
    
    
    
    
    public function actionTest()
    {  
        //$model= $this->findModel(6);
       /* $e=\frontend\modules\hr\models\Employees::findOne(400);
        $base=Yii::$app->prlUtil->getCurrentPay($e,$model);
        var_dump($base);*/
        
          /*$parser= new MathExecutor();
          $parser->setVar('lpsm',1882086);
          //$parser->setVar('',1882086);
          $gr=$parser->execute('lpsm*100/70');
          $parser->setVar('gr',$gr);
          $tax=$parser->execute('gr*30/100');
          $gr1=round($gr,2);
          $tax1=round($tax,2);
          $parser->setVar('gr1',$gr1);
          $parser->setVar('tax1',$tax1);
         //var_dump($tax);
         //var_dump( round($tax, ceil(0 - log10($tax)) + 15));
         var_dump(intVal(41886.2250000000));*/
         
         //$paygr=PayGroups::findOne(6);
         
     
         //var_dump($paygr->findEmpByRunType());
         
        $s=\frontend\modules\hr\models\EmpPaySplits::findAll(['employee' =>128,'active'=>1]);
        
        
        
     if(strtotime("2023-08-14 10:10:00") >= strtotime($s[0]->effective_from)){
            
           var_dump("0ok") ;
        }
       else{
           
           var_dump("no");
       } 
         
        //var_dump(\frontend\modules\hr\models\EmpPaySplits::findActiveSplits(128,2023,"08"));
        
        
    }
     
  
      public function actionManage($id){
      
       return $this->render('payroll-wizard', [
            'model' => $this->findModel($id),
           
        ]);  
          
      }
   
      
      

    /**
     * Creates a new Payrolls model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
 

  public function actionCreate()
    {
        $model = new Payrolls();
       $modelSettings = new \yii\base\DynamicModel([
        'copy', 'prevPayroll'
    ]);
    
    $modelSettings
     ->addRule('prevPayroll', 'required',['when' => function ($model) {
        return $model->copy == '1';
    }, 'whenClient' =>'isCopyOptionChecked'])   
    ->addRule(['copy'],'boolean')
    ->addRule(['prevPayroll'],'integer');
    
    

        if (Yii::$app->request->post()) {
          
            $model->attributes=$_POST['Payrolls'];
            $modelSettings->attributes=$_POST['DynamicModel'];
            
            $transaction = \Yii::$app->db4->beginTransaction();
                try {
            $myDateTime1 = \DateTime::createFromFormat('d/m/Y', $model->pay_period_start);
            $myDateTime2 = \DateTime::createFromFormat('d/m/Y', $model->pay_period_end);        
            $model->pay_period_start=$myDateTime1->format('Y-m-d');
            $model->pay_period_end=$myDateTime2->format('Y-m-d');
            $model->user=Yii::$app->user->identity->user_id; 
            
           
          if(!$model->save()){
            
             $errorMsg=Html::errorSummary($model); 
             Yii::$app->session->setFlash('error', $errorMsg); 
             throw new UserException($errorMsg);
          
             }
          $payrollManager = \Yii::createObject(PayrollCalculator::className(),[$model]);
          
          if($modelSettings->copy && !empty($modelSettings->prevPayroll)) {
              
             $prevPayroll=Payrolls::findOne($modelSettings->prevPayroll);
             
              $payrollManager->payCopy($prevPayroll);
            
        
  $res['success']=true;
  $res['data']['id']=$model->id;
  $res['data']['msg']='payroll copied !';        
      $transaction->commit();
      return $this->asJson($res);        
          }
         
      
  $paySlips=!empty($model->paySlips)? $model->paySlips: $payrollManager->payGenerate() ;
  $slipManager = \Yii::createObject(PaySlipCalculator::className());
 
  foreach($paySlips as $slip){
  
  $slipManager->calculate($slip,false);
    }

  $res['success']=true;
  $res['data']['id']=$model->id;
  $res['data']['msg']='payroll generated !';
  
  $transaction->commit();
  return $this->asJson($res);
      
                   }
                    catch (UserException $e) {
                    $transaction->rollBack();
                   $res['success']=false;
    $res['data']['msg']=$e->getMessage();
    return $this->asJson($res);
                }
                 
                catch (Exception $e) {
                    $transaction->rollBack();
                    $res['success']=false;
    $res['data']['msg']=$e->getMessage();
    return $this->asJson($res); 
                }
            
          
         
        }
        
        if(Yii::$app->request->isAjax){
           return $this->renderAjax('create', [
            'model' => $model,'modelSettings'=>$modelSettings
        ]);  
            
        }

        return $this->render('create', [
            'model' => $model,'modelSettings'=>$modelSettings
        ]);
    } 
   
 public function actionReGenerate(){
  
  if(Yii::$app->request->isAjax){
    $data = Yii::$app->request->post();
    $id=json_decode($data['id']);
    
    if($id==null || !is_numeric($id)){
     $res['success']=false;
     $res['data']['msg']='Invalid Payroll Id';
     return $this->asJson($res);    
     }
   
   $transaction = \Yii::$app->db4->beginTransaction();
               
   
try {
   
  $model=Payrolls::findOne($id);
  $payrollManager = \Yii::createObject(PayrollCalculator::className(),[$model]);
  $old=$model->paySlips;
  
  $paySlips=empty($model->paySlips)? $payrollManager->payGenerate(false) : $payrollManager->payGenerate(true) ;
  $slipManager = \Yii::createObject(PaySlipCalculator::className());
  $new=array_diff(ArrayHelper::getColumn($paySlips, 'id'),ArrayHelper::getColumn($old, 'id'));
 
  foreach($paySlips as $slip){
  
  if(!in_array($slip->id,$new)){
      
    $slipManager->calculate($slip,true);   
  }else{
      
    $slipManager->calculate($slip,false);   
  }
 
    }

  $res['success']=true;
  $res['data']['id']=$model->id;
  $res['data']['msg']='payroll Regenerated !';
  
  $transaction->commit();
  return $this->asJson($res);

 
}


catch(yii\base\UserException $e) {
    $res['success']=false;
    $res['data']['msg']=$e->getMessage();
    return $this->asJson($res);
} 

catch (Exception $e) {
                    $transaction->rollBack();
                    $res['success']=false;
    $res['data']['msg']=$e->getMessage();
    return $this->asJson($res); 
                }
  
  }
  
       
   }
   
  public function actionAdjust($id){
     $model=$this->findModel($id);   
    if(Yii::$app->request->isAjax){
         return $this->renderAjax('_adjust',[
            'model' => $model
        ]); 
    }
     return $this->render('_adjust',[
            'model' => $model
        ]); 
        
        
    } 
    
    
      
public function actionPayslips(){

   $request=Yii::$app->request;
   
   if($request->isAjax){
    $res=[];
    $id = $request->post('id');
    
    try{
        
     if(empty($id) || !is_numeric($id))
     throw new UserException('Invalid Payroll Id');
    
    $model = Payrolls::findOne($id);
    if(empty($model))
     throw new UserException(sprintf("No Payroll found with id %u .",$id));
     
      $res['data']=$model->payrollData();
 return json_encode($res);
        
    }
    catch (UserException $e) {
                   
                 return $res['data']=[];
                }
     
      } 
   
  

 
}  

 
public function actionFinilise(){
      
      if(Yii::$app->request->post()){
          
        $id =$_POST['id'];
        $model = $this->findModel($id);
        $model->status='completed';
        $model->locked=1;
       if(!$success=$model->save(false)){
             
            $errorMsg=Html::errorSummary($model); 
             
         }
         
          if($success){
             
            Yii::$app->session->setFlash('success',"Payroll Completed"); 
           }else{
               
            Yii::$app->session->setFlash('error',$errorMsg);   
            
             }
         
     

           return $this->redirect(['index']);
      } 
      
         
        
      
    } 
    
public function actionUnlock($id)
    {
        $model=$this->findModel($id);
        $model->locked=0;
        $model->status='draft';
        $model->save();
       
            if(!$success=$model->save()){
                 
                 $errorMsg=Html::errorSummary($model); 
            }
            
            if(!$success){
              Yii::$app->session->setFlash('error',$errorMsg);
              
            }else{
               Yii::$app->session->setFlash('success',"Payroll Unlocked for edits !");   
            }
            
           
            return $this->redirect(['index']);
    }


public function actionPrevPayrolls($pay_group){
    
    $models = Payrolls::find()
				->where(['pay_group' => $pay_group,'status'=>'approved'])
				->orderBy('id DESC')
				->all();
				
		if (!empty($models)) {
			foreach($models as $prl) {
				echo "<option value='".$prl->id."'>".$prl->name."</option>";
			}
		} else {
			echo "<option>-</option>";
		}  
} 
 

 public function actionCopyPrevious($id){
  
  $model=$this->findModel($id);   
  $copyModel = new \yii\base\DynamicModel([
        'prevPayroll'
    ]);
    
    $copyModel
     ->addRule('prevPayroll', 'required')   
     ->addRule(['prevPayroll'],'integer');
     
        if (Yii::$app->request->post()) {
           
            $post=$_POST['Payrolls'];
          
            
            $myDateTime1 = \DateTime::createFromFormat('d/m/Y', $post['pay_period_start']);
            $myDateTime2 = \DateTime::createFromFormat('d/m/Y', $post['pay_period_end']);
            
            $model->attributes=$_POST['Payrolls'];
            $model->pay_period_start=$myDateTime1->format('Y-m-d');
            $model->pay_period_end=$myDateTime2->format('Y-m-d');
            $model->user=Yii::$app->user->identity->user_id;
            $render=function()use($model){
             return $this->renderAjax('_form', [
            'model' => $model,
        ]);    
            };
            $success=true;
            if(!$model->save()){
                 $success=false;
                 $errorMsg=Html::errorSummary($model); 
            }
            
            if(!$success){
              Yii::$app->session->setFlash('error',$errorMsg);
              return $render();
            }
            $successMsg='Payroll Saved!';
            Yii::$app->session->setFlash('success',$successMsg); 
            return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax){
           return $this->renderAjax('_copy', [
            'model' => $model,'copyModel'=>$copyModel
        ]);  
            
        }

        return $this->render('_copy', [
            'model' => $model,'copyModel'=>$copyModel
        ]);
 }
 
    /**
     * Updates an existing Payrolls model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         if (Yii::$app->request->post()) {
            
            
            $post=$_POST['Payrolls'];
            $myDateTime1 = \DateTime::createFromFormat('d/m/Y', $post['pay_period_start']);
            $myDateTime2 = \DateTime::createFromFormat('d/m/Y', $post['pay_period_end']);
            
            $model->attributes=$_POST['Payrolls'];
            $model->pay_period_start=$myDateTime1->format('Y-m-d');
            $model->pay_period_end=$myDateTime2->format('Y-m-d');
           
            
            $hasErrors=false;
            
            if(!$model->save()){
            
            $hasErrors=true;
            
            
        
            }
           
           if( $hasErrors){
              
            
              return $this->render('_period', [
            'model' => $model,
           
              ]);
        
           }
             $succesMsg="Payroll details Updated !" ;
             Yii::$app->session->setFlash('success',$succesMsg); 
             return $this->redirect(['index']);
        }
        
         if(Yii::$app->request->isAjax){
           return $this->renderAjax('_period', [
            'model' => $model,
        ]);  
            
        }

        return $this->render('_period', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Payrolls model.
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
     * Finds the Payrolls model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payrolls the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payrolls::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function toArray($objArr,$args){
  
     $arr= ArrayHelper::toArray($objArr,$args); 
           return $arr;                                                              
         
    
        
    }
    
    protected function formatVal($val){
      
        return number_format($val);
    }
   
   public function  parseFloat($numString){
    
    return  filter_var($numString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ); 
}

    
}
