<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\ProcurementActivities;
use frontend\modules\procurement\models\ProcurementActivitiesSearch;
use frontend\modules\procurement\models\ProcurementActivityDates;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use common\models\Model;

/**
 * ProcurementActivitiesController implements the CRUD actions for ProcurementActivities model.
 */
class ProcurementActivitiesController extends Controller
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
     * Lists all ProcurementActivities models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcurementActivitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    

    /**
     * Displays a single ProcurementActivities model.
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
     * Creates a new ProcurementActivities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProcurementActivities();
        $modelDates=[];
        
        if (Yii::$app->request->isGet) {
          
          $model->planId = Yii::$app->request->get('planId');
          $model->procurement_category = Yii::$app->request->get('category');
        }
        
        if(empty($model->code)){
          $model->code=Yii::$app->procUtil->generateCode($model->planId,$model->procurement_category);  
        }
        
        if ($model->load(Yii::$app->request->post())) {
            
            $modelDates = Model::createMultiple(ProcurementActivityDates::classname(),  $modelDates);
            Model::loadMultiple( $modelDates , Yii::$app->request->post());
            
           $model->user=Yii::$app->user->identity->user_id;  
             
       
        $transaction = \Yii::$app->db4->beginTransaction();
try {
        if ($model->save()) {
            
            
             foreach ($modelDates as $modelDate) {
                             $modelDate->activity = $model->id;
                             $modelDate->user = Yii::$app->user->identity->user_id;
                             if($modelDate->validate())
                            if (! ($flag =$modelDate->save(false))) {
                                $errorMsg = Html::errorSummary($modelDate);
                                throw new Exception($errorMsg);
                                break;
                            }
                        }
            
           
        } else {
            $errorMsg = Html::errorSummary($model);
            throw new Exception($errorMsg);
        }

        $transaction->commit();
        Yii::$app->session->setFlash('success', 'Procurement Activity Added!');
        return $this->redirect(['procurement-plans/view', 'id' => $model->procurementPlan->id]);
    } catch (Exception $e) {
        $transaction->rollback();
        Yii::$app->session->setFlash('error', $e->getMessage());
        Yii::error($e->getMessage(), 'database');
    }
  
}

      
        return $this->render('create', [
            'model' => $model,
            'modelDates'=>empty($modelDates)? []:$modelDates
        ]);
    }

    /**
     * Updates an existing ProcurementActivities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelDates=$model->procurementActivityDates;
        
       
      
        if(empty($model->code)){
          $model->code=Yii::$app->procUtil->generateCode($model->planId,$model->procurement_category);  
        }
        
        if ($model->load(Yii::$app->request->post())) {
            
            $modelDates = Model::createMultiple(ProcurementActivityDates::classname(),  $modelDates);
            Model::loadMultiple( $modelDates , Yii::$app->request->post());
            
             $model->user=Yii::$app->user->identity->user_id;  
              
      
        $transaction = \Yii::$app->db4->beginTransaction();
try {
        if ($model->save()) {
            
            
             foreach ($modelDates as $modelDate) {
                             $modelDate->activity = $model->id;
                             $modelDate->user = Yii::$app->user->identity->user_id;
                            if (! ($flag =$modelDate->save(false))) {
                                $errorMsg = Html::errorSummary($modelDate);
                                throw new Exception($errorMsg);
                                break;
                            }
                        }
            
           
        } else {
            $errorMsg = Html::errorSummary($model);
            throw new Exception($errorMsg);
        }

        $transaction->commit();
        Yii::$app->session->setFlash('success', 'Procurement Activity Updated!');
        return $this->redirect(['procurement-plans/view', 'id' => $model->procurementPlan->id]);
    } catch (Exception $e) {
        $transaction->rollback();
        Yii::$app->session->setFlash('error', $e->getMessage());
        Yii::error($e->getMessage(), 'database');
    }
  
}


        return $this->render('update', [
            'model' => $model,'modelDates'=>empty($modelDates)?[]:$modelDates
        ]);
    }

    /**
     * Deletes an existing ProcurementActivities model.
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
     * Finds the ProcurementActivities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProcurementActivities the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProcurementActivities::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
