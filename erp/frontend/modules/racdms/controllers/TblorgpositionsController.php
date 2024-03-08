<?php

namespace frontend\modules\racdms\controllers;

use Yii;
use frontend\modules\racdms\models\Tblorgpositions;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\racdms\models\Tblorgs;

/**
 * TblorgpositionsController implements the CRUD actions for Tblorgpositions model.
 */
class TblorgpositionsController extends Controller
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
     * Lists all Tblorgpositions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblorgpositions::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tblorgpositions model.
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
     * Creates a new Tblorgpositions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tblorgpositions();

        if (Yii::$app->request->post()) {
            
             $data=$_POST['Tblorgpositions'];
            
           if(!isset($data['org'])){
               
             $errorMsg = '<ul style="margin:0"><li>invalid organisation id</li></ul>';
             Yii::$app->session->setFlash('error', $errorMsg); 
              $html=$this->render('create', [
            'model' => $model,
        ]);   
             }
           
           $org=$data['org'];
          
          
           
           $orgModel=Tblorgs::find()->where(['id'=>$org])->one();
           
           if(!$orgModel){
               
              $errorMsg = '<ul style="margin:0"><li>organisation not found</li></ul>';
              Yii::$app->session->setFlash('error', $errorMsg); 
              $html=$this->render('create', [
            'model' => $model,
        ]);  
           }
           
           if(! $orgModel->addPosition($data)){
               
              $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $orgModel->getFirstErrors()) . '</li></ul>';
              Yii::$app->session->setFlash('error', $errorMsg); 
              $html=$this->render('create', [
            'model' => $model,
        ]);
           }else{
               
                $successMsg = 'Postion Addedd !';
                Yii::$app->session->setFlash('success', $suuccessMsg); 
                $html=$this->redirect(['index']);
             }
          
           
           return $html;
       
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tblorgpositions model.
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
     * Deletes an existing Tblorgpositions model.
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
     * Finds the Tblorgpositions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblorgpositions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tblorgpositions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
           public function beforeAction($action)
 {
     $this->view->params['showSideMenu'] =true;
     $this->layout ='admin';
     return parent::beforeAction($action);
 }
}
