<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayTemplateItems;
use frontend\modules\hr\models\PayTemplateItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
/**
 * PayTemplateItemsController implements the CRUD actions for PayTemplateItems model.
 */
class PayTemplateItemsController extends Controller
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
     * Lists all PayTemplateItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayTemplateItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayTemplateItems model.
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
     * Creates a new PayTemplateItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayTemplateItems();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
     * Updates an existing PayTemplateItems model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        

        if($model->load(Yii::$app->request->post())) {
        
            if(!$model->save()){
                
                 $errorMsg=Html::errorSummary($model); 
                Yii::$app->session->setFlash('error',$errorMsg);
              
            }else{
                
                $successMsg="Pay Item Updated !"; 
                Yii::$app->session->setFlash('success',$successMsg);  
            }
            return $this->redirect(['pay-templates/view', 'id' => $model->tmpl]);
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
  
  public function actionOverride(){
   
   $request=Yii::$app->request;
   
   $id=$request->get('id');
   $empployee=$request->get('emp');
   var_dump($id);
      
  }
    /**
     * Deletes an existing PayTemplateItems model.
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
     * Finds the PayTemplateItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayTemplateItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayTemplateItems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
