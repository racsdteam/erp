<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpPersonInterim;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ErpPersonInterimController implements the CRUD actions for ErpPersonInterim model.
 */
class ErpPersonInterimController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all ErpPersonInterim models.
     * @return mixed
     */
    public function actionIndex()
    {
        $q=" SELECT inter.* FROM erp_person_interim as inter order by timestamp desc";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();

        return $this->render('index', [
            'rows' => $rows,
        ]);
    }
  public function actionMyInterim()
    {
        $q=" SELECT inter.* FROM erp_person_interim as inter
  
where person_interim_for='".Yii::$app->user->identity->user_id."'";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();

        return $this->render('my-interim', [
            'rows' => $rows,
        ]);
    }
    /**
     * Displays a single ErpPersonInterim model.
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
     * Creates a new ErpPersonInterim model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpPersonInterim();

        if ($model->load(Yii::$app->request->post())) {
            $data=$_POST['ErpPersonInterim'];
            $person_in_interim=$data['person_in_interim'];
            if(!empty($person_in_interim)){
                
               
                if(isset($person_in_interim[0])){
                  
                  $model->person_in_interim=$person_in_interim[0];
                   $model->status="active";
                  $model->interim_creator=Yii::$app->user->identity->user_id;
                  $model->person_interim_for=Yii::$app->user->identity->user_id;
                  $flag=$model->save();
                  
                    
                }
            }
            
            
            
           
            if($flag){
                 
                Yii::$app->session->setFlash('success',"Person  Added Successfully!");
                 $model = new ErpPersonInterim();
            }else{
                var_dump($model->getErrors());die();
                Yii::$app->session->setFlash('failure',"Person could not be added!");
            }
            
            
            
           
        }

         if(Yii::$app->request->isAjax){
            
             return $this->renderAjax('create', [
            'model' => $model,'isAjax'=>true
        ]); 
        }else{
           return $this->render('create', [
            'model' => $model,'isAjax'=>false
        
        ]);  
            
        }
    }

    /**
     * Updates an existing ErpPersonInterim model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $q7=" SELECT p.id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$model->person_in_interim."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $model->position=$row7['id'];

        if ($model->load(Yii::$app->request->post())) {
            $data=$_POST['ErpPersonInterim'];
            $person_in_interim=$data['person_in_interim'];
            if(!empty($person_in_interim)){
                
               
                if(isset($person_in_interim[0])){
                  
                  $model->person_in_interim=$person_in_interim[0];
                  $model->interim_creator=Yii::$app->user->identity->user_id;
                  $model->person_interim_for=Yii::$app->user->identity->user_id;
                  $flag=$model->save(false);
                  
                    
                }
            }
            
            
            
           
            if($flag){
                 
                Yii::$app->session->setFlash('success',"Person  Updated Successfully!");
                 $model = new ErpPersonInterim();
                  return $this->redirect(['index'
        ]);
            }else{
                var_dump($model->getErrors());die();
                Yii::$app->session->setFlash('failure',"Person could not be Updated!");
                 return $this->redirect(['index'
        ]);
            }
            
            
            
           
        }
       
        if(Yii::$app->request->isAjax){
            
             return $this->renderAjax('update', [
            'model' => $model,'isAjax'=>true
        ]); 
        }else{
           return $this->render('update', [
            'model' => $model,'isAjax'=>false
        
        ]);  
            
        }

       
    }

    /**
     * Deletes an existing ErpPersonInterim model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success',"Person  Updated Successfully!");
        return $this->redirect(['index']);
    }

    /**
     * Finds the ErpPersonInterim model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpPersonInterim the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpPersonInterim::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
