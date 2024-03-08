<?php

namespace frontend\modules\auction\controllers;

use Yii;
use frontend\modules\auction\models\Auctions;
use frontend\modules\auction\models\Lots;
use frontend\modules\auction\models\AuctionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use common\models\Model;
use yii\filters\AccessControl;
/**
 * AuctionsController implements the CRUD actions for Auctions model.
 */
class AuctionsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
                'access' => [ //----------rules based access control
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                 
                   [ //-----------------rule 
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
     * Lists all Auctions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuctionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionLaunch($id){
       
      if(Yii::$app->request->isAjax){
         
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
        
        $model=Auctions::find()->where(['id'=>$id])->One();
        if($model!=null){
          
           $model->status='active';
           $msg="Auction Launched!";
           
        if(!$flag=$model->save(false)){
          $msg=Html::errorSummary($model);  
            
        }
        
        }else{
            $flag=false;
            $msg="ERROR,Auction not found !";
        }
        
        $response=['flag'=>$flag,'msg'=>$msg];
        return $response;
        
      }
       
    
        
    }

    /**
     * Displays a single Auctions model.
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
    
     public function actionActive()
    {
        $cond[]='and'; 
        $cond[]=['auct.status'=>'active'];
     $query = new Query;
     $query->select([
        'auct.id',
        'auct.name',
        'auct.description',
        'auct.online_start_time',
        'auct.online_end_time',
        'auct.status',
        'auct.timestamp',
       
        
        
        ]
        )  
        ->from('auctions as auct')
        /*->join('INNER JOIN', 'lots_locations as loc',
            'loc.id =auct.location')->where($cond)*/
            ->orderBy(['timestamp' => SORT_DESC]);		
         $queryString=$query->createCommand()->getRawSql();
        
         $data = Yii::$app->db5->createCommand($queryString)->queryAll();
        return $this->render('active', [
            'data' =>$data,
        ]);
    }

     public function actionDrafts()
    {
        $cond[]='and'; 
        $cond[]=['auct.status'=>'draft'];
     $query = new Query;
     $query->select([
        'auct.id',
        'auct.name',
        'auct.description',
        'auct.online_start_time',
        'auct.online_end_time',
        'auct.status',
        'auct.timestamp',
       
        
        
        ]
        )  
        ->from('auctions as auct')
        ->where($cond)->orderBy(['timestamp' => SORT_DESC]);		
         $queryString=$query->createCommand()->getRawSql();
        
         $data = Yii::$app->db5->createCommand($queryString)->queryAll();
        return $this->render('drafts', [
            'data' =>$data,
        ]);
    }

    /**
     * Creates a new Auctions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Auctions();
        $modelsAuctionLots = [new Lots]; 
      
        if(Yii::$app->request->post()){
            
            $model->attributes=$_POST['Auctions'];
            $model->user=Yii::$app->user->identity->user_id;
            
            $modelsAuctionLots = Model::createMultiple(Lots::classname());
            Model::loadMultiple($modelsAuctionLots, Yii::$app->request->post());
            
            $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                    if ($flag = $model->save(false)) {
                        foreach ($modelsAuctionLots as $modelLot) {
                            $modelLot->auction_id = $model->id;
                             $modelLot->user = Yii::$app->user->identity->user_id;
                            if (! ($flag = $modelLot->save(false))) {
                                $transaction->rollBack();
                                Yii::$app->session->setFlash('failure',Html::errorSummary($modelLot)); 
                                break;
                            }
                        }
                    }else{
                      Yii::$app->session->setFlash('failure',Html::errorSummary($model)); 
                 return $this->render('_form', [
            'model' => $model,
            'modelsAuctionLots' => (empty($modelsAuctionLots)) ? [new Lots] : $modelsAuctionLots
        ]);   
                    }
                    
                    if ($flag) {
                        $transaction->commit();
                         Yii::$app->session->setFlash('success',"Auction Created Successfully !"); 
                         return $this->redirect(['drafts']); 
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
          
         
            
            
        }

       

        return $this->render('_form', [
            'model' => $model,
            'modelsAuctionLots' => (empty($modelsAuctionLots)) ? [new Lots] : $modelsAuctionLots
        ]);
    }

    /**
     * Updates an existing Auctions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsAuctionLots =$model->lots;
        
        if(Yii::$app->request->post()){
            
            $model->attributes=$_POST['Auctions'];
            $model->user=Yii::$app->user->identity->user_id;
            
            $oldIDs = ArrayHelper::map($modelsAuctionLots, 'id', 'id');
            $modelsAuctionLots = Model::createMultiple(Lots::classname(),$modelsAuctionLots);
            Model::loadMultiple($modelsAuctionLots, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAuctionLots, 'id', 'id')));
            
            $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                    if ($flag = $model->save(false)) {
                         
                          if (!empty($deletedIDs)) {
                            Lots::deleteAll(['id' => $deletedIDs]);
                        }
                        
                        foreach ($modelsAuctionLots as $modelLot) {
                            $modelLot->auction_id = $model->id;
                             $modelLot->user = Yii::$app->user->identity->user_id;
                            if (! ($flag = $modelLot->save(false))) {
                                $transaction->rollBack();
                                Yii::$app->session->setFlash('failure',Html::errorSummary($modelLot)); 
                                break;
                            }
                        }
                    }else{
                      Yii::$app->session->setFlash('failure',Html::errorSummary($model)); 
                 return $this->render('_form', [
            'model' => $model,
            'modelsAuctionLots' => (empty($modelsAuctionLots)) ? [new Lots] : $modelsAuctionLots
        ]);   
                    }
                    
                    if ($flag) {
                        $transaction->commit();
                         Yii::$app->session->setFlash('success',"Auction Created Successfully !"); 
                         return $this->redirect(['drafts']); 
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
          
         
            
            
        }

       

        return $this->render('_form', [
            'model' => $model,
            'modelsAuctionLots' => (empty($modelsAuctionLots)) ? [new Lots] : $modelsAuctionLots
        ]);
  
    


    }

    /**
     * Deletes an existing Auctions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $modelsAuctionLots=$model->lots;
        
        if($flag=$model->delete()){
            
            foreach($modelsAuctionLots as $lot){
                  
                  $flag=$lot->delete();
                
            }
            
           }
if($flag){
    
     Yii::$app->session->setFlash('success',"Auction Deleted Successfully !"); 
}else{
  
  Yii::$app->session->setFlash('failure',"Error deleting auction !");  
    
}
   
    return $this->redirect(['drafts']);
   
   
    }

    /**
     * Finds the Auctions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Auctions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Auctions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
