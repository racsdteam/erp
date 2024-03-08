<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\models\PayGroupsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * PayGroupsController implements the CRUD actions for PayGroups model.
 */
class PayGroupsController extends Controller
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
     * Lists all PayGroups models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayGroupsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayGroups model.
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
     * Creates a new PayGroups model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayGroups();

        if ($model->load(Yii::$app->request->post()) ) {
            
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg); 
             
            }
            else{
                
               $msg="Payroll Group Saved !" ;
               Yii::$app->session->setFlash('success',$msg); 
            }
             
             return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model,
        ]); 
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PayGroups model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg); 
             
            }
            else{
                
               $msg="Payroll Group Saved !" ;
               Yii::$app->session->setFlash('success',$msg); 
            }
             
             return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model,
        ]); 
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PayGroups model.
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

   public function actionPayTemplate($code){
       
    $model=PayGroups::findByCode($code);
    return $this->asJson($model->payTemplate);
       
   }
    public function actionFindGroup(){
   
 /*  $payGroup=PayGroups::findByCode('RSCIV');
   $util=Yii::$app->prlUtil;
   $arr=[];
   $payr=\frontend\modules\hr\models\Payrolls::findOne(44);
  foreach($payGroup->employees as $e){
   if($util->isPayable($e,$payr)) {
       $arr[]=$e;
   }  
      
  }*/
  
  var_dump(0.1 + 0.2 - 0.3);
	 
}
    public function actionFindByRunType($run_type){
   
   $payGroups=PayGroups::find()->where(['run_type'=>$run_type])->active()->all();
  
				
		if (!empty($payGroups)) {
			foreach($payGroups as $grp) {
				echo "<option value='".$grp->code."'>".$grp->name."</option>";
			}
		} else {
			echo "<option>-</option>";
		}  
}
    /**
     * Finds the PayGroups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayGroups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayGroups::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
