<?php

namespace frontend\modules\auction\controllers;

use Yii;
use frontend\modules\auction\models\LotsItems;
use frontend\modules\auction\models\LotsItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
/**
 * LotsItemsController implements the CRUD actions for LotsItems model.
 */
class LotsItemsController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all LotsItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LotsItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'param'=>Yii::$app->request->queryParams
        ]);
    }

    /**
     * Displays a single LotsItems model.
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
     * Creates a new LotsItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       $model = new LotsItems();
        
        if(Yii::$app->request->post()){
            
            if(isset($_POST['LotsItems'])){
              
              $model->attributes= $_POST['LotsItems'];
              $model->user=Yii::$app->user->identity->user_id;
              $files = UploadedFile::getInstances($model, 'item_images');
             
              
              if(!$flag=$model->save()){
                 
                 Yii::$app->session->setFlash('failure',Html::errorSummary($model)); 
                 return $this->render('create', [
            'model' => $model,
        ]);
                  
                  }
                  
                /*  if(!empty($files)){
                    
                    if(!$model->addImages($files)){
                        
                           Yii::$app->session->setFlash('failure',"Error Saving images !"); 
                 return $this->render('create', [
            'model' => $model,
        ]);
                
                    }
                
                  }*/
           
             Yii::$app->session->setFlash('success',"Item Created !");  
             return $this->redirect(['index']);  
            
            }
        }
        
       

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LotsItems model.
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
     * Deletes an existing LotsItems model.
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
     * Finds the LotsItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LotsItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LotsItems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
