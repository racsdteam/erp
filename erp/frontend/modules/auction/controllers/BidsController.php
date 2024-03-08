<?php

namespace frontend\modules\auction\controllers;

use Yii;
use frontend\modules\auction\models\Bids;
use frontend\modules\auction\models\BidsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\filters\AccessControl;
/**
 * BidsController implements the CRUD actions for Bids model.
 */
class BidsController extends Controller
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
     * Lists all Bids models.
     * @return mixed
     */
    public function actionIndex()
    { $cond[]='and'; 
    
    /*$dateNow=date('Y-m-d H:i:s');
   $cond[]=['>=', 'item.end_date',$dateNow];*/
    
     $query = new Query;
     $query->select([
       'lot.lot',
        'lot.description',
        'lot.quantity',
        'lot.reserve_price',
        'loc.location',
        'lot.auction_date',
        
        'bid.id',
        'bid.user',
        'bid.amount',
        'count(bid.item) as tot_bid',
        'MAX(bid.amount) as highest_bid ',
        'count(bid.user) as tot_bidders'
        
        ]
        )  
        ->from('lots as lot')
         ->join('INNER JOIN', 'lots_locations as loc',
            'lot.location =loc.id')	
        ->join('LEFT JOIN', 'bids as bid',
            'bid.item =lot.id')		
          //->where($cond)
          ->groupBy(['lot.lot']);  
          
          
         $queryString=$query->createCommand()->getRawSql();
         $data = Yii::$app->db5->createCommand($queryString)->queryAll();
        
        
      return $this->render('index', [
            'data' => $data,'title'=>'All Biddings'
        ]);
    }
     public function actionAllBids()
    { $cond[]='and'; 
    
    /*$dateNow=date('Y-m-d H:i:s');
   $cond[]=['>=', 'item.end_date',$dateNow];*/
    
     $query = new Query;
     $query->select([
       'lot.lot',
        'lot.description',
        'lot.quantity',
        'lot.reserve_price',
        'bid.amount',
        'usr.first_name',
        'usr.last_name',
        'usr.doc_type',
        'usr.doc_id',
        'usr.phone',
        'usr.email',
        ]
        )  
        ->from('bids as bid ')
        ->join('INNER JOIN', 'lots as lot',
            'bid.item =lot.id')
         ->join('INNER JOIN', 'user as usr',
            'bid.user =usr.user_id')
        ->orderBy(['lot.lot' => SORT_ASC ,'bid.amount'=> SORT_DESC ])
            ;
          
          
         $queryString=$query->createCommand()->getRawSql();
        
         $data = Yii::$app->db5->createCommand($queryString)->queryAll();
      return $this->render('allbids', [
            'data' => $data,'title'=>'All Biddings'
        ]);
    }
    
    public function actionBiddersByLot($lot){
         
         $query1 = new Query;
     $query1->select([
        'u.*',
        'b.*'
        
       
        
        ]
        )  
        ->from('user as u')
        
        ->join('INNER JOIN', 'bids as b',
            'b.user =u.user_id')
            ->orderBy([
  'amount' => SORT_DESC,
  
])
          ->where(['b.item'=>$lot])
          ;
         
          
          
         $queryString1=$query1->createCommand()->getRawSql();
         $bidders = Yii::$app->db5->createCommand($queryString1)->queryAll(); 
         
         return json_encode( $lot);
        
    }

    /**
     * Displays a single Bids model.
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
    
    /*$dateNow=date('Y-m-d H:i:s');
   $cond[]=['>=', 'item.end_date',$dateNow];*/
    
    $query = new Query;
     $query->select([
        'lot.lot',
        'lot.description',
        'lot.quantity',
        'lot.reserve_price',
        'loc.location',
        'lot.auction_date',
        
        'bid.id',
        'bid.user',
        'bid.amount',
        'count(bid.item) as tot_bid',
        'MAX(bid.amount) as highest_bid ',
        'count(bid.user) as tot_bidders'
        
        ]
        )  
        ->from('lots as lot')
         ->join('INNER JOIN', 'lots_locations as loc',
            'lot.location =loc.id')	
             ->join('INNER JOIN', 'auctions as auct',
            'auct.id =lot.auction_id')	
        ->join('LEFT JOIN', 'bids as bid',
            'bid.item =lot.id')	
            
          ->where(['auct.status'=>'active'])
          ->groupBy(['lot.lot']); 
          
          
         $queryString=$query->createCommand()->getRawSql();
         $data = Yii::$app->db5->createCommand($queryString)->queryAll();
         
        
      return $this->render('active', [
            'data' => $data,'title'=>'Active Biddings'
        ]);
    }
    
      public function actionViewBid($item)
    {
          
    $cond[]='and'; 
    
    /*$dateNow=date('Y-m-d H:i:s');
   $cond[]=['>=', 'item.end_date',$dateNow];*/
    
    $query = new Query;
     $query->select([
        'l.id as lot_id',
        'l.lot',
        'l.description',
        'l.quantity',
        'l.reserve_price',
        'l.location',
        'l.start_date',
        'l.end_date',
        'b.id',
        'b.user',
        'b.item',
        'b.amount',
       
        'count(b.item) as tot_bid',
        
        "MAX(cast(REPLACE(b.amount,',','') as unsigned )) as highest_bid ",
        'count(b.user) as tot_bidders'
        
        ]
        )  
        ->from('bids as b ')
        ->join('INNER JOIN', 'lots as l',
            'b.item =l.id')	
         ->join('INNER JOIN', 'lots_locations as loc',
            'l.location =loc.id')	
        	
          ->where(['b.item'=>$item])
          
         ->groupBy(['b.item']); 
          
          
         $queryString=$query->createCommand()->getRawSql();
         $data = Yii::$app->db5->createCommand($queryString)->queryAll();
         
        var_dump($data);
     
    }

    /**
     * Creates a new Bids model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bids();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bids model.
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
     * Deletes an existing Bids model.
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
     * Finds the Bids model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bids the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bids::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
