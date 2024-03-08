<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\CompanyContributions;
use frontend\modules\hr\models\CompanyContributionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
/**
 * CompanyContributionsController implements the CRUD actions for CompanyContributions model.
 */
class CompanyContributionsController extends Controller
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
     * Lists all CompanyContributions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanyContributionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyContributions model.
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
     * Creates a new CompanyContributions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompanyContributions();
        $errors=array();

       if (Yii::$app->request->post()) {
            $model->attributes=$_POST['CompanyContributions'];
            $empGroupArr=$model->empGroupArr;
            $renderForm=function()use($model){
              return  $this->render('_form', [
            'model' => $model,
             ]);
            };
           
           
            if(is_array( $empGroupArr) && !empty( $empGroupArr)){
               
                $tr = Yii::$app->db4->beginTransaction();
    try {
         foreach($empGroupArr as $key=>$categ){
                 
                   $model1 = new CompanyContributions();
                   $model1->attributes=$_POST['CompanyContributions'];
                   $model1->contribution_rate=$model->contribution_rate/100;
                   $model1->emp_group=$categ;
                   $model1->user=Yii::$app->user->identity->user_id;
                   if(!$model1->save()){
                    $errors[]= Html::errorSummary($model1);
                   break;
             
            }
           
                }
                
         if (!empty($errors)) {
                
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $err) {
                    $errorMsg .= "<li>" .$err. "</li>\n";
                }
                $errorMsg .= "</ul>";
                
                Yii::$app->session->setFlash('error', $errorMsg);     
                return $renderForm();
            }
          
           
        //Submission
        $tr->commit();
        $succesMsg="Employeer Contribution Saved !" ;
        Yii::$app->session->setFlash('success',$succesMsg); 
        return $this->redirect(['index']);
    } catch (Exception $e) {
        //RollBACK
        $tr->rollBack();
       
    } 
               
                
               }
          
           
        
                
              
        }
      
       if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('_form', [
            'model' => $model,
        ]);
           
       }
      return  $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CompanyContributions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->contribution_rate=$model->contribution_rate*100;
        $model->empGroupArr=$model->emp_group;
         if (Yii::$app->request->post()) {
            $model->attributes=$_POST['CompanyContributions'];
            $model->contribution_rate= $model->contribution_rate/100;
            $model->emp_group=$model->empGroupArr[0];
           
            $renderForm=function()use($model){
              return  $this->render('_form', [
            'model' => $model,
             ]);
            };
            $errors=array();
           
            
            if(!$model->save()){
            
            $errors[]=$model->getFirstErrors();
             
            }
           
    
         if (!empty($errors)) {
                
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $err) {
                    $errorMsg .= "<li>" .$err. "</li>\n";
                }
                $errorMsg .= "</ul>";
                
                Yii::$app->session->setFlash('error', $errorMsg);     
                return $renderForm();
            }
            $succesMsg="Employeer Contribution Updated !" ;
            Yii::$app->session->setFlash('success',$succesMsg); 
             return $this->redirect(['index']);
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
     * Deletes an existing CompanyContributions model.
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
     * Finds the CompanyContributions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyContributions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompanyContributions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
