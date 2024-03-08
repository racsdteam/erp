<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\EmpDocuments;
use frontend\modules\hr\models\EmpDocumentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\FileHelper;
/**
 * EmpDocumentsController implements the CRUD actions for EmpDocuments model.
 */
class EmpDocumentsController extends Controller
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
     * Lists all EmpDocuments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpDocumentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpDocuments model.
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
      public function actionPdf($id)
    {
        if(Yii::$app->request->isAjax){
            $html= $this->renderAjax('pdf', [
            'model' => $this->findModel($id),
        ]);
        }
        else{
          $html= $this->render('pdf', [
            'model' => $this->findModel($id),
            ]);
        }
        return $html;
       
    }
     public function actionEmployeeDocs($employee,$category_code)
    {
        $searchModel = new EmpDocumentsSearch();
        $dataProvider = $searchModel->search([$searchModel->formName()=>["employee"=>$employee,"category"=>$category_code]]);
if(Yii::$app->request->isAjax){
        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
}
return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new EmpDocuments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($employee)
    {
        $model = new EmpDocuments();
        $request = Yii::$app->request;
        if ($request->post()) {
            $model->upload_file = UploadedFile::getInstance($model, 'upload_file');
            if($model->upload_file!=null)
            {
                      $file=$model->upload_file;
                      $model->employee=$employee;
                      $model->attributes = $request->post("EmpDocuments");
                      $model->dir=$savePath='uploads/employees/'.$employee.'/documents/';
                      $model->file_name=$file->name;
                      $model->fileType=$file->extension;
                      $model->mimeType=$file->type;
                     if($model->save(false)){
                      $this->createDir($savePath);
                      $file->saveAs($savePath.'/'.$model->id.$file->extension);
                      return $this->redirect(['employees/documents', 'id' => $model->employee]);
                   
                }
                else{
                     var_dump($model->getErrors()); die();
              $errorMsg=Html::errorSummary($model);
              $class = end(explode("\\", get_class($model)));
              $errors[$class]=$errorMsg;
                }
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
     * Updates an existing EmpDocuments model.
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
     * Deletes an existing EmpDocuments model.
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
     * Finds the EmpDocuments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpDocuments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpDocuments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
        protected function createDir($path){
        
        return FileHelper::createDirectory($path);
    }
}
