<?php

namespace frontend\modules\racdms\controllers;

use Yii;
use common\models\Tblgroups;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Tblgroupmembers;

/**
 * TblgroupsController implements the CRUD actions for Tblgroups model.
 */
class TblgroupsController extends Controller
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
     * Lists all Tblgroups models.
     * @return mixed
     */
    public function actionIndex()
    {
       

        return $this->render('index', [
            'models' => $models,
        ]);
    }

    /**
     * Displays a single Tblgroups model.
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
     * Creates a new Tblgroups model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       
        $model = new Tblgroups();

        if (Yii::$app->request->post()) {
          
          
        
            
        if(isset($_POST['type']) && $_POST['type']!=null){
                
             $type= $_POST['type']  ;
             
             if($type==Tblgroups::UNIT_GROUP){
                 
                  
               
               $units= $_POST['units']; 
               
               if(!empty($units)){
               
              foreach($units as $unit_code){
             
              $model = new Tblgroups();
              $model->attributes=$_POST['Tblgroups'];  
              $model->name=$unit_code;
              $model->type=Tblgroups::UNIT_GROUP;
              $model->created_by=Yii::$app->user->identity->user_id;
              
              if(!$flag=$model->save()){
                  $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $model->getFirstErrors()) . '</li></ul>';  
                  break;
              }
               
              }   
                  
              } else{
                  
                    $errorMesg="Error Empty Units !";
                  Yii::$app->session->setFlash('error', $errorMsg);    
                  return $this->render('create', [
            'model' => $model,
        ]);
              }  
                 
               }
               else if($type==Tblgroups::CUSTOM_GROUP){
                   
                 $model->attributes=$_POST['Tblgroups'];
                 $model->type=Tblgroups::CUSTOM_GROUP;
                 $model->created_by=Yii::$app->user->identity->user_id; 
                 
                    if($flag=$model->save()){
                     
                     $members=$model->group_members;
                     
                     if(!empty($members)){
                         
                     foreach($members as $member){
                       
                       $model2=new Tblgroupmembers();
                       $model2->groupID=$model->id;
                       $model2->userID=$member;
                       $model2->created_by=Yii::$app->user->identity->user_id;
                       
                       if(!$flag=$model2->save()){
                            $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $model2->getFirstErrors()) . '</li></ul>';  
                           break;
                       }
                         
                      }
                     
                         
                     }
                     
                    }else{
                        
                  $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $model->getFirstErrors()) . '</li></ul>';       
                    }
                   
                   
               }
             
              else if($type==Tblgroups::PUBLIC_GROUP){
                   
                 $model->attributes=$_POST['Tblgroups'];
                 $model->type=Tblgroups::PUBLIC_GROUP;
                 $model->created_by=Yii::$app->user->identity->user_id; 
                 
                    if(!$flag=$model->save()){
                     
                   $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $model->getFirstErrors()) . '</li></ul>'; 
                     
                    }
                   
                   
               }
             
             
                
            }
            
       
            if($flag){
                
              $successMsg="Security Group Saved Successfully!";
             Yii::$app->session->setFlash('success', $successMsg);   
              }
              else{
              
                Yii::$app->session->setFlash('error', $errorMsg); 
                
                return $this->render('create', [
            'model' => $model,
        ]);
                  
              }
            
            return $this->redirect(['index']);
        }


 if (Yii::$app->request->isAjax) {
    return $this->renderAjax('_form', [
            'model' => $model,
        ]); 
 }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tblgroups model.
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
     * Deletes an existing Tblgroups model.
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
     * Finds the Tblgroups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblgroups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tblgroups::findOne($id)) !== null) {
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
