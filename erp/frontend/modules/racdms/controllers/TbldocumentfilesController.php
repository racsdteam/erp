<?php

namespace frontend\modules\racdms\controllers;

use Yii;
use common\models\Tbldocumentfiles;
use common\models\TbldocumentfilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\TbldocumentfilesForm ;
use common\models\Tbldocuments;
use yii\web\UploadedFile;
/**
 * TbldocumentfilesController implements the CRUD actions for Tbldocumentfiles model.
 */
class TbldocumentfilesController extends Controller
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
     * Lists all Tbldocumentfiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TbldocumentfilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tbldocumentfiles model.
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
     * Creates a new Tbldocumentfiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TbldocumentfilesForm();
        $documentid=$_GET['documentid'];

        if (Yii::$app->request->post()) {
           
            
           
           if(isset($_POST['documentid']) && $_POST['documentid']!=null){
               
                $documentid=$_POST['documentid'];
                
                $document=Tbldocuments::find()->where(['id'=> $documentid])->one();
                
                if($document!=null){
                    
                $model->attributes=$_POST['TbldocumentfilesForm']; 
                
                $model->uploaded_file = UploadedFile::getInstance($model, 'uploaded_file');
                
                if($model->uploaded_file!=null){
                    
                  
                    
                  if(!$flag=$document->addDocumentFile($model)){
                      
                      $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $document->getFirstErrors()) . '</li></ul>'; 
                   
                   
                    } 
                  
                    
                }else{
                
                 $errorMsg = '<ul style="margin:0"><li> No file uploaded !</li></ul>';    
               //-----------------No file uploaded----------------------------     
                }
                
               
                }else{
                 
                  $errorMsg = '<ul style="margin:0"><li>document not found !</li></ul>';   
          //---------------------docu not found---------------------------------          
                }
                
              
                
                
               
             }else{
       //---------------------invalid document id----------------------------------------------          
               $errorMsg = '<ul style="margin:0"><li>Invalid document Id !</li></ul>';   
                 
               }
           
           if($flag){
             
              $successMsg = '<ul style="margin:0"><li>Document File Saved !</li></ul>';
              Yii::$app->session->setFlash('success', $successMsg); 
               
           }else{
               
               Yii::$app->session->setFlash('error', $errorMsg);
           
             }
           
           
           
            return $this->redirect(['tbldocuments/view', 'id' =>$documentid]);
        }

                          
                          
                           if(Yii::$app->request->isAjax){

          $html=$this->renderAjax('_form',[ 
            'model' =>$model,'documentid'=> $documentid
            
    ]);
            return json_encode($html);
           // return $html;
        }

        return $this->render('_form', [
            'model' => $model,'documentid'=> $documentid
        ]);
    }

    /**
     * Updates an existing Tbldocumentfiles model.
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
     * Deletes an existing Tbldocumentfiles model.
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
     * Finds the Tbldocumentfiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tbldocumentfiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tbldocumentfiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
