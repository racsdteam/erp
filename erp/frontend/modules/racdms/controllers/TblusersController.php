<?php

namespace frontend\modules\racdms\controllers;

use Yii;
use frontend\modules\racdms\models\Tblusers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\racdms\models\SignupForm;
use common\models\Tblgroupmembers;
use frontend\modules\racdms\models\Tblorgusers;

/**
 * TblusersController implements the CRUD actions for Tblusers model.
 */
class TblusersController extends Controller
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
     * Lists all Tblusers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblusers::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tblusers model.
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
     * Creates a new Tblusers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();
 
        if ($model->load(Yii::$app->request->post()))
        {
            //var_dump(Yii::$app->request->post());die();

         if ($user = $model->signup()) {
            
                       
                       $model1=new Tblorgusers();
                       $model1->orgID=$model->org;
                       $model1->posID=$model->position;
                       $model1->userID=$user->user_id;
                       $model1->created_by=Yii::$app->user->identity->user_id;
                       $model1->save(false);
                       
                       
                       
                       $model2=new Tblgroupmembers();
                       $model2->groupID=$model->group;
                       $model2->userID=$user->user_id;
                       $model2->created_by=Yii::$app->user->identity->user_id;
                       $model2->save();
                       
                       
                       
            
            
             $successMsg="New User Added !"; 
             Yii::$app->session->setFlash('success',$successMsg); 
             $model = new SignupForm();
             
            }else
            {
                
              $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $model->getFirstErrors()) . '</li></ul>'; 
              Yii::$app->session->setFlash('error',$errorMsg);
            }
           
           
            return $this->render('create', [
            'model' => $model,
        ]);

    }
 
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tblusers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tblusers model.
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
     * Finds the Tblusers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblusers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tblusers::findOne($id)) !== null) {
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
