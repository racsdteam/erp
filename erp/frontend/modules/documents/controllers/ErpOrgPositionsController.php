<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpOrgPositions;
use common\models\ErpOrgPositionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ ErpUnitsPositions;
use common\models\ErpOrgUnits;

/**
 * ErpOrgPositionsController implements the CRUD actions for ErpOrgPositions model.
 */
class ErpOrgPositionsController extends Controller
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
     * Lists all ErpOrgPositions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpOrgPositionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpOrgPositions model.
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
     * Creates a new ErpOrgPositions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpOrgPositions();

        if (Yii::$app->request->post()) {
             $data=Yii::$app->request->post();
             $model->attributes=$data['ErpOrgPositions'];
             $p=trim($model->position);
              
              $pos =ErpOrgPositions::find()
            ->select('*')
           ->where(['LIKE', 'position',$p])
           ->one();
     
      
    
             if($pos!=null){
             
              $found=true;  
                
            }else{$found=false;}
             
             //var_dump( $found);die();
            
             if(!$found){
                 
                 //var_dump($data['ErpOrgPositions']);die();
                if($flag=$model->save()){
              
    //-------------------------------------------add position to unit-------------------------------------          
              
                $sub_pos=new ErpUnitsPositions();
                $sub_pos->unit_id=$data['ErpOrgPositions']['unit'];
                $sub_pos->position_id=$model->id;
                $sub_pos->position_count=$data['count'];
                $sub_pos->position_status=$data['ErpOrgPositions']['status'];
                 $sub_pos->position_level=$data['ErpOrgPositions']['level'];
                 
                 
                $flag= $sub_pos->save();
                

                }
            
             if($flag){
   Yii::$app->session->setFlash('success',"Position Added!");
   $model = new ErpOrgPositions();
             }else{
                Yii::$app->session->setFlash('failure',"Position Could not be added!");

             }
             
             }else{
                 
                 Yii::$app->session->setFlash('failure',"Position Already Exist!"); 
             }
            
                
              
              
          
            // return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpOrgPositions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $unit_pos=ErpUnitsPositions::find()->where(['position_id'=>$model->id])->One();
        if($unit_pos!=null){

            //$unit= ErpOrgUnits::find()->where(['id'=>$unit_pos->unit_id])->One();
            $model->unit=$unit_pos->unit_id;
            $model->status=$unit_pos->position_status;
            $model->level=$unit_pos->position_level;
        }


        if (Yii::$app->request->post()) {
            $data=Yii::$app->request->post();
            //var_dump($unit_pos);die();
            $model->attributes=$data['ErpOrgPositions'];
            $model->unit=$data['ErpOrgPositions']['unit'];
            
            
           
            
             //var_dump($data['ErpOrgPositions']);die();
               if($flag=$model->save()){
                   
             
                   
               
              // $sub_pos=new ErpUnitsPositions();
               $unit_pos->unit_id=$data['ErpOrgPositions']['unit'];
               $unit_pos->position_id=$model->id;
                $unit_pos->position_count=$data['count'];
                $unit_pos->position_status=$data['ErpOrgPositions']['status'];
               $flag=  $unit_pos->save(false);  
                  
              
               

               }
           
            if($flag){
  Yii::$app->session->setFlash('success',"Position Updated!");
  $model = new ErpOrgPositions();
  
            }else{
               Yii::$app->session->setFlash('failure',"Position Could not be Updated!");

            }
            
              return $this->redirect(['index']);
             
        }
      
       return $this->render('create',['model'=>$model]);
       
    }

    /**
     * Deletes an existing ErpOrgPositions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success',"Position Deleted!");

        return $this->redirect(['index']);
    }

    /**
     * Finds the ErpOrgPositions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpOrgPositions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpOrgPositions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
