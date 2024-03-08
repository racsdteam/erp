<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayrollItems;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\PayrollItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
/**
 * PayrollItemsController implements the CRUD actions for PayrollItems model.
 */
class PayrollItemsController extends Controller
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
    
    public function actionTest(){
     
     var_dump(PayrollItems::findAllRegularByCateg(array('BASIC', 'ALW')));   
        
        
    }

    /**
     * Lists all PayrollItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayrollItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollItems model.
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
     * Creates a new PayrollItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayrollItems();

        if (Yii::$app->request->post()) {
            $model->attributes=$_POST['PayrollItems'];
            if(!$model->save()){
            
            $errorMsg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$errorMsg); 
             
            }
            else{
                
               $succesMsg="Pay Component Saved !" ;
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
    
    public function actionSort(){
        
        if (Yii::$app->request->post()) {
           $id_ary = explode(",",$_POST["row_order"]);
           $sequence=1;
	
	for($i=0;$i<count($id_ary);$i++) {
   
       $item=PayrollItems::find()->where(['id'=>$id_ary[$i]])->One();
        
        if($item!=null){
           
            $item->sequence= $sequence;
            if(!$flag=$item->save(false)){
              $errorMsg=Html::errorSummary($model); 
              Yii::$app->session->setFlash('error',$errorMsg);
              break;
              
            }
        }else{
            $flag=false;
            $errorMsg=" Pay Item with Id ".$id_ary[$i]." not found"; 
            Yii::$app->session->setFlash('error',$errorMsg); 
            break;
        }
	    $sequence++; 
	}
       
      if($flag){
          $succesMsg="Pay Items Order Changed !" ;
          Yii::$app->session->setFlash('success',$succesMsg);   
      }     
    
      return $this->redirect(['index']);
        }
      
      return $this->render('_sort');   
        
    }
    
    
    
 public function actionGetItemById() {
    
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out =[];
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        if ($id != null) {
         
        $row=PayrollItems::find()->select(['*'])->where(['id'=>$id])->asArray()->one();
       
        if(!empty($row))
          {
              $out=['success'=>1,'data'=>$row];
          }
          else{
              $out=['success'=>0]; 
          }
        }
    }
    return $out;
}

    /**
     * Updates an existing PayrollItems model.
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
                
               $succesMsg="Pay Component Updated !" ;
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
     * Deletes an existing PayrollItems model.
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
     * Finds the PayrollItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollItems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
