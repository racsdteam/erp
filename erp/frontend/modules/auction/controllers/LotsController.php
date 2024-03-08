<?php

namespace frontend\modules\auction\controllers;

use Yii;
use frontend\modules\auction\models\Lots;
use frontend\modules\auction\models\User;
use frontend\modules\auction\models\LotsSearch;
use frontend\modules\auction\models\SelectedBiddersNotification;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Html;

/**
 * LotsController implements the CRUD actions for Lots model.
 */
class LotsController extends Controller
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
            
            'verbs' => [//checks if the HTTP request methods are allowed by the requested actions
                   'class' => VerbFilter::className(),
                    'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Lots models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LotsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lots model.
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

 public function actionBiddings($lot){
   if (($model = Lots::find()->where(['lot'=>$lot])->One()) !== null) {
          
          $cond[]='and'; 
    
   
    
    $query = new Query;
     $query->select([
        'lt.id as lot_id',
        'lt.id',
        'lt.lot',
        'lt.description',
        'lt.quantity',
        'lt.reserve_price',
        'loc.location',
        'lt.auction_date',
       
         
         'b.id',//highest bid id
         'b.user',//highest bid bidder
    
        'count(b.item) as tot_bid',
        "MAX(cast(REPLACE(b.amount,',','') as unsigned )) as highest_bid ",
        'count(b.user) as tot_bidders'
        
        ]
        )  
        ->from('lots as lt')
         ->join('INNER JOIN', 'lots_locations as loc',
            'lt.location =loc.id')	
        ->join('LEFT JOIN', 'bids as b',
            'b.item =lt.id')		
          ->where(['b.item'=>$model->id])
          ->groupBy(['lt.lot']); 
          
          
         $queryString=$query->createCommand()->getRawSql();
         $data = Yii::$app->db5->createCommand($queryString)->queryOne();
        
    
          return $this->render('biddings', [
            'model' =>$model,
            'data'=>$data
           
        ]);
        }

        throw new NotFoundHttpException('The requested lot  does not exist.');   
  
     
     
 }
 

public function actionBidders($lot){

$model = Lots::find()->where(['lot'=>$lot])->One();  
    //---------------------------bidders list----------------------------------- 
         $query1 = new Query;
     $query1->select([
        'u.*',
        'b.*',
       
        
        ]
        )  
        ->from('user as u')
        
        ->join('INNER JOIN', 'bids as b',
            'b.user =u.user_id')
            ->orderBy([
  'amount' => SORT_DESC,
  
])
          ->where(['b.item'=>$model->id])
          ;
         
          
          
         $queryString1=$query1->createCommand()->getRawSql();
         $bidders = Yii::$app->db5->createCommand($queryString1)->queryAll();
         
         $res=array();
         $res['data']=$bidders;
         
         return json_encode($res) ;
}
  
  
  public function actionSelectedBidders($lot){

$model = Lots::find()->where(['lot'=>$lot])->One();  
    //---------------------------bidders list----------------------------------- 
         $query1 = new Query;
     $query1->select([
        'u.*',
        'b.*',
       
        
        ]
        )  
        ->from('user as u')
        
        ->join('INNER JOIN', 'bids as b',
            'b.user =u.user_id')
            ->orderBy([
  'amount' => SORT_DESC,
  
])
          ->where(['b.item'=>$model->id,'b.selected'=>1])
          ;
         
          
          
         $queryString1=$query1->createCommand()->getRawSql();
         $bidders = Yii::$app->db5->createCommand($queryString1)->queryAll();
         
         $res=array();
         $res['data']=$bidders;
         
         return json_encode($res) ;
}
   
    /**
     * Creates a new Lots model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lots();
        
        if(Yii::$app->request->post()){
            
            if(isset($_POST['Lots'])){
              
              $model->attributes= $_POST['Lots'];
              $model->user=Yii::$app->user->identity->user_id;
             // $files = UploadedFile::getInstances($model, 'item_images');
             
              
              if(!$flag=$model->save()){
                 
                 Yii::$app->session->setFlash('failure',Html::errorSummary($model)); 
                 return $this->render('create', [
            'model' => $model,
        ]);
                  
                  }
                  
                /*  if(!empty($files)){
                    
                    if(!$model->addImages($files)){
                        
                           Yii::$app->session->setFlash('failure',"Error Saving images !"); 
                 return $this->render('create', [
            'model' => $model,
        ]);
                
                    }
                
                  }*/
           
             Yii::$app->session->setFlash('success',"Lot Created !");  
             return $this->redirect(['index']);  
            
            }
        }
        
       

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lots model.
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
     * Deletes an existing Lots model.
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
     * Finds the Lots model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lots the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lots::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
}
