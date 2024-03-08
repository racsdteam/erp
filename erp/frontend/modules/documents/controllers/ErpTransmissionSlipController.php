<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpTransmissionSlip;
use common\models\ErpTransmissionSlipSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
/**
 * ErpTransmissionSlipController implements the CRUD actions for ErpTransmissionSlip model.
 */
class ErpTransmissionSlipController extends Controller
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
     * Lists all ErpTransmissionSlip models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpTransmissionSlipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpTransmissionSlip model.
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
       public function actionView2($id)
    {
        $content = $this->renderPartial('view3',['model' => $this->findModel($id)]);
    
    // setup kartik\mpdf\Pdf component
    $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => 'css/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Krajee Report Title'],
         // call mPDF methods on the fly
        'methods' => [ 
            //'SetHeader'=>['Krajee Report Header'], 
            'SetFooter'=>['<img src="img/footer.png"/>'],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    return $pdf->render(); 
    }
    
     public function actionViewForm(){
      
       $model=ErpTransmissionSlip::find()->where(['id'=>$_GET['id']])->one() ; 
       
       if($model!=null){
          
       return $this->renderAjax('page-viewer1', [
         'model' => $model,
         
    ]);  
      
       }else{
         return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Transmission  Form Found!
              
               </div>';  
           
       }
      
   }
     
     
     public function actionPdfData($id)
    {
        $url = "css/kv-mpdf-bootstrap.min.css";
          $stylesheet = file_get_contents($url);
           
          $url2 = "css/prince-bootstrap-grid-fix.css";
          $stylesheet2 = file_get_contents($url2);
          
        $mpdf = new \Mpdf\Mpdf();
        //----------------------------add bootsrap classes---------------------------
       $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
       //------------------------bootsr grid system---------------------------------
        $mpdf->WriteHTML($stylesheet2, \Mpdf\HTMLParserMode::HEADER_CSS);
       //---------------------make us of font awesome----------------------------
       $mpdf->WriteHTML('.fa { font-family: fontawesome;}',1);
       //-----------------sett footer------------------------------
        $mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
        $mpdf->SetCompression(false);
        $mpdf->setAutoBottomMargin = 'stretch';
     //------------------fix image not showing---------------------------------------------------    
         //$mpdf->showImageErrors = true;
         $mpdf->curlAllowUnsafeSslRequests = true;
         $mpdf->WriteHTML($this->renderPartial('view2', [
            'model' => $this->findModel($id),]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }

    /**
     * Creates a new ErpTransmissionSlip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpTransmissionSlip();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpTransmissionSlip model.
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
     * Deletes an existing ErpTransmissionSlip model.
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
     * Finds the ErpTransmissionSlip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpTransmissionSlip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpTransmissionSlip::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
