<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\ReportTypes;
use frontend\modules\hr\models\ReportTypesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * ReportTypesController implements the CRUD actions for ReportTypes model.
 */
class ReportTypesController extends Controller
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
     * Lists all ReportTypes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportTypes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {  
        $model=$this->findModel($id);
        $type=$model->contributionType->code;
        $data=array();
        switch($type){
         case 'rssbMER' :{
             
             $template='rama';
             break;
         }  
          case 'rssbPER' :{
             
             $template='pension';
             break;
         }
         
         case 'rssbMLER' :{
             
             $template='maternity';
             break;
         }
         default:
             $template='index';
        }
        
        $data=$model->getReportData();
       
        
        return $this->render($template, [
            'model' => $this->findModel($id),
            'rows'=>$data
        ]);
    }
    
      public function actionViewPdf($id)
    {  
        $model=$this->findModel($id);
        $type=$model->contributionType->code;
        $data=array();
        switch($type){
         case 'rssbMER' :{
             
             $template='_rama-pdf';
             break;
         }  
          case 'rssbPER' :{
             
             $template='_pension-pdf';
             break;
         }
         
         case 'rssbMLER' :{
             
             $template='_maternity-pdf';
             break;
         }
         default:
             $template='index';
        }
        
        $data=$model->getReportData();
        
        if($template=='index'){
            
          return $this->redirect(['index']);   
        }
        
       /* return $this->render($template, [
            'model' => $model,
            'rows'=>$data
        ]);*/
     $html=$this->renderPartial($template, [
            'model' => $model,
            'rows'=>$data
        ]);
   
    $css = "css/payroll-report.css"; 
    $stylesheet = file_get_contents($css);
        
    $mpdf = new \Mpdf\Mpdf([
	'margin_left' => 20,
	'margin_right' => 15,
	'margin_top' => 48,
	'margin_bottom' => 25,
	'margin_header' => 10,
	'margin_footer' => 10,
    'mode'=>'c',
    'format' =>'A4-L'
]);
$mpdf->SetHTMLHeader('<table  style="width:100%;"  cellspacing="0" cellpadding="10">
<tr>
<td  align="left"> <img src="img/logo.png"  width="151" height="118px" hspace="17px" vspace="15px"></td>
<td align="right"><img src="img/rightlogo.png"  width="234px" height="55px"  hspace="76px" vspace="13px"></td>
</tr>
</table>');
$mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);

$mpdf->Output();
    }


    /**
     * Creates a new ReportTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReportTypes();

          if (Yii::$app->request->post()) {
             $model->attributes=$_POST['ReportTypes'];
            
            if(!$flag=$model->save()){
            
            $errorMsg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$errorMsg); 
             
            }
            else{
                
               $succesMsg=" Report Type Saved !" ;
               Yii::$app->session->setFlash('success',$succesMsg); 
            }
            
            if(!$flag){
                
         if(Yii::$app->request->isAjax){
            
           return $this->renderAjax('_form', [
            'model' => $model,
        ]);  
        }

        return $this->render('create', [
            'model' => $model,
        ]);  
            }
            
            return $this->redirect(['index']);
            
            
        }
        
        if(Yii::$app->request->isAjax){
            
           return $this->renderAjax('_form', [
            'model' => $model,
        ]);  
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReportTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        if(Yii::$app->request->isAjax){
            
           return $this->renderAjax('update', [
            'model' => $model,
        ]);  
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReportTypes model.
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
     * Finds the ReportTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportTypes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportTypes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
