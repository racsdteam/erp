<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\TenderStageSequenceSettings;
use frontend\modules\procurement\models\TenderStages;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TenderStageSequenceSettingsController implements the CRUD actions for TenderStageSequenceSettings model.
 */
class TenderStageSequenceSettingsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
                           'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                 
                   [
        'actions' => ['index'],
        'allow' => true,
        'matchCallback' => function ($rule, $action) {
            return \Yii::$app->user->identity->isAdmin();
        },
    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                     'delete-fuel-out' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all TenderStageSequenceSettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TenderStageSequenceSettings::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TenderStageSequenceSettings model.
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
     * Creates a new TenderStageSequenceSettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($stage)
    {
        $model = new TenderStageSequenceSettings();

              if(Yii::$app->request->post()){
                   $stage_model= TenderStages::find()->where(["code"=>$stage])->one();
              $model->attributes=$_POST['TenderStageSequenceSettings'];
              $check1= TenderStageSequenceSettings::find()->where(["sequence_number"=>$model->sequence_number,"tender_stage_code"=>$stage])->one();
              if($check1!=null)
              {
            Yii::$app->session->setFlash('error','The Sequence number is already used by another stage. !');
            return $this->redirect(['tender-stages/view', 'id' => $stage_model->id]);   
              }
                $check2= TenderStageSequenceSettings::find()->where(["tender_stage_setting_code"=>$model->tender_stage_setting_code,"tender_stage_code"=>$stage])->one();
              if($check2!=null)
              {
            Yii::$app->session->setFlash('error','The stage is alrady assigned.!');
            return $this->redirect(['tender-stages/view', 'id' => $stage_model->id]);  
              }
             $user_id=Yii::$app->user->identity->user_id;
           
             $model->tender_stage_code=$stage;
             $model->user_id=$user_id;
             $flag=$model->save();
             if($flag)
             {
            Yii::$app->session->setFlash('success','Tender stage sequency Saved !');
            return $this->redirect(['tender-stages/view', 'id' => $stage_model->id]);
             }
              
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TenderStageSequenceSettings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$stage)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $stage_model= TenderStages::find()->where(["code"=>$stage])->one();
            Yii::$app->session->setFlash('success','Tender stage Sequency  Updated!');
            return $this->redirect(['tender-stages/view', 'id' => $stage_model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TenderStageSequenceSettings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$stage)
    {
        $this->findModel($id)->delete();

          $stage_model= TenderStages::find()->where(["code"=>$stage])->one();
            Yii::$app->session->setFlash('success','Tender stage  Sequency Deleted!');
            return $this->redirect(['tender-stages/view', 'id' => $stage_model->id]);
    }

    /**
     * Finds the TenderStageSequenceSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TenderStageSequenceSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TenderStageSequenceSettings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
