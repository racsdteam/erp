<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\PayItemCategoriesSearch;
use frontend\modules\hr\models\PayItems;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/**
 * PayItemCategoriesController implements the CRUD actions for PayItemCategories model.
 */
class PayItemCategoriesController extends Controller
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
     * Lists all PayItemCategories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayItemCategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayItemCategories model.
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
     * Creates a new PayItemCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayItemCategories();

        if (Yii::$app->request->post()) {
            $model->attributes=$_POST['PayItemCategories'];
           
            if(!$model->save()){
            
            $errorMsg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$errorMsg); 
             
            }
            else{
                
               $succesMsg="Category Saved !" ;
               Yii::$app->session->setFlash('success',$succesMsg); 
            }
            
            return $this->redirect(['index']);
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
     * Updates an existing PayItemCategories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       
           if ($model->load(Yii::$app->request->post())) {
            
           if(!$model->save()){
            
            $errorMsg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$errorMsg); 
             
            }
            else{
                
               $succesMsg="Category Updated !" ;
               Yii::$app->session->setFlash('success',$succesMsg); 
            }
            
            return $this->redirect(['index']);
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
    
    
    public function actionCategItems(){
        
          Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
   
    $out = [];
    $options=[];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
             $cat_id = $parents[0];
            
             if (!empty($_POST['depdrop_params'])) {
                $params = $_POST['depdrop_params'];
                 $options=json_decode($params[0]);
                
                 
            }
         
    
               $out=self::getCategItems($cat_id,$options);
             
                return ['output'=>$out, 'selected'=>''];
        }
    }
    return ['output'=>'', 'selected'=>''];
    }
    
    
    private function getCategItems($categ,$options=array()){
        $out=[];
        $cond=[];
        $cond['pay_item_categories.code']=$categ;
        
        $query = PayItems::find()->alias('t1')->select(['t1.*','pay_item_categories.code'])->innerJoinWith('category0');
        if(!empty($options)){
         
         foreach($options as $key=>$value){
             
          $cond['t1.'.$key]=$value ;  
         }   
           }
        if(!empty($cond))   
        $query->where($cond);
        
        $rows=$query->asArray()->all();
             
            if(!empty($rows)){
                 
               foreach($rows as $row){
                
                 $out[]=['id'=>$row['id'],'name'=>$row['name']];   
                   
               }
                    
               
         
                }
                
                return $out;
        
    }

    /**
     * Deletes an existing PayItemCategories model.
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
     * Finds the PayItemCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayItemCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayItemCategories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
