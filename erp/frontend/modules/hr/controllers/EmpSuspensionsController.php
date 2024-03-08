<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\EmpSuspensions;
use frontend\modules\hr\models\EmpSuspensionsSearch;
use frontend\modules\hr\models\EmpEmployment;
use frontend\modules\hr\models\EmpSuspAttachments;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\EmployeeStatuses;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use common\models\Model;
use yii\base\UserException;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\helpers\FileHelper;

/**
 * EmpSuspensionsController implements the CRUD actions for EmpSuspensions model.
 */
class EmpSuspensionsController extends Controller
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
     * Lists all EmpSuspensions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpSuspensionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpSuspensions model.
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
     * Creates a new EmpSuspensions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpSuspensions();
        $modelsAttachment=[new EmpSuspAttachments];

       
        
         if ($model->load(Yii::$app->request->post()) ) {
            
             //------------------------------------attchemts-------------------------------------------------------------------------
        $modelsAttachment = Model::createMultiple(EmpSuspAttachments::classname());
        Model::loadMultiple( $modelsAttachment , Yii::$app->request->post());
        
            $renderForm=function()use($model,$modelsAttachment){
               
             return $this->render('_form', [
            'model' => $model,'modelsAttachment' => (empty($modelsAttachment)) ? [new EmpSuspAttachments] : $modelsAttachment
        ]); 
                
            };
              $transaction = \Yii::$app->db4->beginTransaction();
                try {
               
               try{
                       $model->user=Yii::$app->user->identity->user_id;
           
           if(!$model->save()){
            
          
             throw new UserException(Html::errorSummary($model));
          
             }
             
           foreach ($modelsAttachment as $i=>$attachModel) {
      
          
             //saving files for dyanamic forms
           $file[$i]=  UploadedFile::getInstanceByName("EmpSuspAttachments[".$i."][upload_file]");
     
 if( $file[$i]==null){
     
  throw new UserException("No Supporting Document(s) Found !");   
     
 }
  
                      $modelAttachement=new EmpSuspAttachments();
                      $modelAttachement->attributes=$attachModel->attributes;
                      $modelAttachement->susp=$model->id;
                      $modelAttachement->dir=$savePath='uploads/employees/'.$model->employee.'/documents/susp/';
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
             
             $employee=Employees::findOne($model->employee);
             $employee->status=EmployeeStatuses::STATUS_TYPE_SUSP;
             if(!$employee->save(false)){
           
            throw new UserException(Html::errorSummary($employee));
          
             }
             
 
             
             $transaction->commit();
             Yii::$app->session->setFlash('success', "Employee Suspended!"); 
             return $this->redirect(['index']);
                       
                   
               }
               
                catch (UserException $e) {
                    $transaction->rollBack();
                     Yii::$app->session->setFlash('error',$e->getMessage()); 
                    return $renderForm(); 
                }
                 
                } catch (Exception $e) {
                    $transaction->rollBack();
                     return $renderForm(); 
                }
       
        }
        
         if(Yii::$app->request->isAjax)
         return $this->renderAjax('_form', [
            'model' => $model,'modelsAttachment' => (empty($modelsAttachment)) ? [new EmpSuspAttachments] : $modelsAttachment
        ]);
        return $this->render('_form', [
            'model' => $model,'modelsAttachment' => (empty($modelsAttachment)) ? [new EmpSuspAttachments] : $modelsAttachment
        ]);
    }

    /**
     * Updates an existing EmpSuspensions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

           if ($model->load(Yii::$app->request->post()) ) {
            
            $renderForm=function()use($model){
               
               return $this->render('_form', [
            'model' => $model,
        ]);   
                
            };
            
            $success=$error=false;
            
            if(!$model->save()){
            $success=false;
            $errorMsg=Html::errorSummary($model); 
            
             
            }
            else{
               $success=true; 
               $successMsg="Employee Termination Updated !" ;
               
            }
            
            if(!$success){
              Yii::$app->session->setFlash('error',$errorMsg);  
              return $renderForm();
            }
            Yii::$app->session->setFlash('success',$successMsg);  
            return $this->redirect(['index']);
        }
if(Yii::$app->request->isAjax)
         return $this->renderAjax('_form', [
            'model' => $model,
        ]);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EmpSuspensions model.
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
     * Finds the EmpSuspensions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpSuspensions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpSuspensions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
      protected function createDir($path){
        
        return FileHelper::createDirectory($path);
    }
}
