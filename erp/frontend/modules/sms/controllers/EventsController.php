<?php

namespace frontend\modules\sms\controllers;

use Yii;
use frontend\modules\sms\models\Events;
use frontend\modules\sms\models\EventAircraftDetails;
use frontend\modules\sms\models\EventCategories;
use frontend\modules\sms\models\EventReporters;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventsController implements the CRUD actions for Events model.
 */
class EventsController extends Controller
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
     * Lists all Events models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Events::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Events model.
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
     * Creates a new Events model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model_event = new Events();
        $model_event_aircraft_details = new EventAircraftDetails();
        $model_event_categories = new EventCategories();
        $model_event_reporter = new EventReporters();
        
        
        
        
        if ($model_event->load(Yii::$app->request->post()) && $model_event->save()) {
            return $this->redirect(['view', 'id' => $model_event->id]);
        }

        return $this->render('create', [
            'model_event' => $model_event,
        ]);
    }
    
        public function actionEventsPublic()
    {
         $model_event = new Events();
        $model_event_aircraft_details = new EventAircraftDetails();
        $model_event_reporter = new EventReporters();
        $event_categories = EventCategories::find()->all();
        
        if (Yii::$app->request->post()) {
             $model_event->attributes=$_POST['Events'];
            if($model_event->save()){
             
             $model_event_reporter->attributes=$_POST['EventReporters'];
               $model_event_reporter->event_id=$model_event->id;
             $model_event_reporter->save();
             
              $model_event_aircraft_details->attributes=$_POST['EventAircraftDetails'];
               $model_event_aircraft_details->event_id=$model_event->id;
             $model_event_aircraft_details->save();
             
            return $this->render('viewpublic');
            }
        }

        return $this->render('public', [
            'model_event' => $model_event, 'model_event_aircraft_details' => $model_event_aircraft_details, 'model_event_categories' => $model_event_categories, 'model_event_reporter' => $model_event_reporter,
            'event_categories' => $event_categories,
        ]);
    }
    
    /**
     * Updates an existing Events model.
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
     * Deletes an existing Events model.
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
     * Finds the Events model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Events the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Events::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
