<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayrollChanges;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * PayrollChangesController implements the CRUD actions for PayrollChanges model.
 */
class PayrollChangesController extends Controller
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
     * Lists all PayrollChanges models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PayrollChanges::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollChanges model.
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
     * Creates a new PayrollChanges model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     
         public function actionPdf($id)
    {
        if(Yii::$app->request->isAjax){
            $html= $this->renderAjax('pdf', [
            'model' => $this->findModel($id),
        ]);
        return Json::encode($html);
        }
        return $this->render('pdf', [
            'model' => $this->findModel($id),
        ]);
    }
      public function actionPdfData($id)
    {
          $cssFile = file_get_contents("css/mpdf-custom.css");
           
        $mpdf = new \Mpdf\Mpdf(['format' =>'A4','orientation'=>'L']);
        //----------------------------add bootsrap classes---------------------------
        $mpdf->WriteHTML($cssFile, \Mpdf\HTMLParserMode::HEADER_CSS);
       //---------------------make us eof font awesome----------------------------
      
         $mpdf->setAutoBottomMargin = 'stretch';
       //-----------------sett footer------------------------------
        $mpdf->SetHTMLFooter('<div style="text-align:center"><img src="img/footer.png"/></div>');
        $mpdf->SetCompression(false);
        $mpdf->autoPageBreak = true;
         $mpdf->curlAllowUnsafeSslRequests = true;
         $mpdf->WriteHTML($this->renderPartial('view', [
            'model' => $this->findModel($id)]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
    public function actionCreate()
    {
        $model = new PayrollChanges();

         if (Yii::$app->request->post()) {
           
            $model->attributes=$_POST['PayrollChanges'];

            $model->user_id=Yii::$app->user->identity->user_id;
            $success=true;
           
            $render=function()use($model){
             return $this->renderAjax('_form', [
            'model' => $model,
        ]);    
            };
            if(!$model->save()){
                 $success=false;
                 $errorMsg=Html::errorSummary($model); 
            }
            
            if(!$success){
              Yii::$app->session->setFlash('error',$errorMsg);
              return $render();
            }
            $successMsg='Payrolls Changes Saved!';
            Yii::$app->session->setFlash('success',$successMsg); 
            return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax){
           return $this->renderAjax('_form', [
            'model' => $model,
        ]);  
            
        }

        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PayrollChanges model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
 if (Yii::$app->request->post()) {
           
            $model->attributes=$_POST['PayrollChanges'];

            $model->user_id=Yii::$app->user->identity->user_id;
            $success=true;
           
            $render=function()use($model){
             return $this->renderAjax('_form', [
            'model' => $model,
        ]);    
            };
            if(!$model->save()){
                 $success=false;
                 $errorMsg=Html::errorSummary($model); 
            }
            
            if(!$success){
              Yii::$app->session->setFlash('error',$errorMsg);
              return $render();
            }
            $successMsg='Payrolls Changes Updated!';
            Yii::$app->session->setFlash('success',$successMsg); 
            return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax){
           return $this->renderAjax('_form', [
            'model' => $model,
        ]);  
            
        }

        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PayrollChanges model.
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
     * Finds the PayrollChanges model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollChanges the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollChanges::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
