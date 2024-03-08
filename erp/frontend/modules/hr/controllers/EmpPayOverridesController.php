<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\EmpPayOverrides;
use frontend\modules\hr\models\EmpPayOverridesSearch;
use frontend\modules\hr\models\PayTemplateItems;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * EmpPayOverridesController implements the CRUD actions for EmpPayOverrides model.
 */
class EmpPayOverridesController extends Controller
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
     * Lists all EmpPayOverrides models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpPayOverridesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpPayOverrides model.
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
     * Creates a new EmpPayOverrides model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpPayOverrides();
        $request=Yii::$app->request;
        
        if ($request->post()) {
            $model->attributes=$_POST['EmpPayOverrides'];
            $model->user=Yii::$app->user->identity->user_id;
           
            if(!$flag=$model->save()){
                
               $errorMsg=Html::errorSummary($model);
               Yii::$app->session->setFlash('error',  $errorMsg);
              
            }
            if($flag){
                if($model->amount==0){
                    
                  $msg="Pay item removed from employee salary";  
                }else{
                    
                  $msg="Pay item amount changed !";    
                }
                Yii::$app->session->setFlash('success', $msg);
            }
            
            return $this->redirect(['emp-pay-details/view', 'id' =>$model->pay_id]);
        }
        
       $tmpl=$request->get('tmpl');
       $tmpl_line_id=$request->get('id');
       $emp_pay=$request->get('emp_pay');
       $tmpl_line=PayTemplateItems::findOne($tmpl_line_id);
       
        
        
      

        
        if(Yii::$app->request->isAjax){
            
          return $this->renderAjax('_form', [
            'model' => $model,'tmpl_line'=>$tmpl_line,'params'=>compact("tmpl", "emp_pay")
        ]);   
        }

        return $this->render('_form', [
            'model' => $model,'tmpl_line'=>$tmpl_line,'params'=>compact("tmpl", "emp_pay")
        ]);
    }

    /**
     * Updates an existing EmpPayOverrides model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {   
        $model = $this->findModel($id);
      
        

        if (Yii::$app->request->post()) {
            
           $model->attributes=$_POST['EmpPayOverrides'] ;
           $disable_override=$_POST['disable_override'];
           
           if(!empty($disable_override)){
               
            $model->active=0;
            $msg="Pay item set to default";
           }
           else{
            
            $msg= $model->amount==0 ? "Pay item removed from Employee salary" : "Pay item amount changed !";
              }
          
           if(!$model->save(false)){
              $msg=Html::errorSummary($model);
              Yii::$app->session->setFlash('error',  $msg);
           }else{
              
              Yii::$app->session->setFlash('success', $msg);  
               
             }
          return $this->redirect(['emp-pay-details/view', 'id'=>$model->pay_id]);
        }
        
       $tmpl=$model->tmpl;
       $tmpl_line_id=$model->tmpl_line;
       $emp_pay=$model->pay_id;
       $tmpl_line=PayTemplateItems::findOne($tmpl_line_id);
      
       if(Yii::$app->request->isAjax){
            
          return $this->renderAjax('_form', [
            'model' => $model,'tmpl_line'=>$tmpl_line,'params'=>compact("tmpl", "emp_pay")
        ]);   
        }

        return $this->render('_form', [
            'model' => $model,'tmpl_line'=>$tmpl_line,'params'=>compact("tmpl", "emp_pay")
        ]);
    }

    /**
     * Deletes an existing EmpPayOverrides model.
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
     * Finds the EmpPayOverrides model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpPayOverrides the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpPayOverrides::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
