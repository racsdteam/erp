<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\db\Query;
use yii\grid\GridView;

use frontend\modules\auction\models\Lots;
use frontend\modules\auction\models\LotsLocations;

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Auctions */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auctions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-success card-outline card-tabs">
    
    <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-content-above-home-tab" 
                    data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true"><i class="fas fa-info-circle"></i> Auction Details</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-profile-tab" 
                    data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false"><i class="fas fa-boxes"></i> Auction Lots</a>
                  </li>
                   <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-biddings-tab" 
                    data-toggle="pill" href="#custom-content-above-biddings" role="tab" aria-controls="custom-content-above-biddings" 
                    aria-selected="false"><i class="fas fa-gavel"></i> Auction Biddings</a>
                  </li>
                  
                   <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-biddings-tab" 
                    data-toggle="pill" href="#custom-content-above-biddings" role="tab" aria-controls="custom-content-above-biddings" 
                    aria-selected="false"><i class="fas fa-gavel"></i> Auction Biddings</a>
                  </li>
                  
                </ul>
              </div>

 <div class="card-body">
     
         <div class="tab-custom-content mb-20">
              <p class="lead mb-0">  
              
              <?php if($model->status=='draft') :?> 
             
              <?=Html::a('<i class="fas fa-external-link-alt"></i> Launch',
                                              Url::to(["auctions/launch",'id'=>$model->id,
                                           ])
                                          ,['class'=>'btn  btn-success  active action-launch ','title'=>'Launch Auction'] ); ?>
                                          
                                          <?php endif;?>
                                          
                                           <?php if($model->status=='active') :?> 
                                          
                                           <?=Html::a('<i class="fas fa-times"></i> Close',
                                              Url::to(["auctions/close",'id'=>$model->id,
                                           ])
                                          ,['class'=>'btn  btn-danger  active action-close','title'=>'Close Auction'] ); ?>
                                          
                                           <?php endif;?>
                                          </p>
            </div>

     <div class="tab-content" id="custom-content-above-tabContent mt-20">
         
         
                  <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                      
                      <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'name',
            'description:ntext',
            
            'online_start_time',
           
            'online_end_time',
          
            [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>call_user_func(function ($data) {
                     $_status=$data->status;
                     if($_status=='draft' || $_status=='closed'){$class="badge badge-danger";}else{$class="badge badge-success";}
                     
                     $badge='<small class="'.$class.'" ><i class="far fa-clock"></i> '. $_status.'</small> ';
                    
                return $badge;
            }, $model)
                ],
           /* [
                 'label'=>'Location',
                 'value'=>$model->Location(),
                ],*/
                 [
                 'label'=>'Created By',
                 'value'=>call_user_func(function ($data) {
                     $_user=$data->User();
                     
                return $_user!=null? $_user->first_name ." ".$_user->last_name : '';
            }, $model),
                 
                
                ]
        ],
    ]) ?>
                      
                       
         
                      
                  </div>
                  
                  <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
            <h1>Auction Lots</h1>     
                     <?php  
 

 $query = Lots::find()->where(['auction_id'=>$model->id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false
        ]);

                     ?>
            <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' =>$dataProvider,
   'columns' => [
       
            [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update}{delete}',
                  
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', Url::to(['lots/update','id'=>$model->id]), ['class'=>['text-success'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>',Url::to(['lots/view','id'=>$model->id]), ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<i class="fas fa-times"></i>', Url::to(['lots/delete','id'=>$model->id]), ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Lot ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ]//-------end
            
            ],
            ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],

            
            'lot',
             'image',
            'description:ntext',
            'quantity',
             'reserve_price',
              [
                 'label'=>'Reserve Price',
                 'format' => 'raw',
                 'value'=>function ($model) {
                     $_price=$model->reserve_price;
                     $class="badge badge-danger";
                     
                     $badge='<small class="'.$class.'" >'. $_price.'</small> ';
                    
                return $badge;
            }
                ],
             'comment:ntext',
            
             'winner',
            [
          'label'=>'Auction Date',
          'value'=>function($model){
            $date=date_create($model->auction_date);
          return  date_format($date,"d/m/Y H:i:s");  
              
          }
           ],
            
           [
            'label' => 'Location',
             'value' => function ($model) {
           
          
           return $model->Location();
       } 
               ],
            'timestamp',

        ],
         'tableOptions' =>['class' => 'table  table-bordered'],
    ]); ?>
</div>         
                   
                      
                  </div>
                 <div class="tab-pane fade" id="custom-content-above-biddings" role="tabpanel" aria-labelledby="custom-content-above-biddings-tab">
                     <?php
                    
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
          ->where(['lt.auction_id'=>$model->id])
          ->groupBy(['lt.lot']); 
          
          
         $queryString=$query->createCommand()->getRawSql();
         $biddings = Yii::$app->db5->createCommand($queryString)->queryAll();
                     ?>
                      <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th><img src="<?php echo Yii::$app->request->baseUrl?>/img/blue_gavel.png" alt="Product 1" class="img-circle img-size-32 mr-2"></th>
                      <th nowrap>Lot No.</th>
                      <th>Lot Item</th>
                      <th>Qty</th>
                      <th>Bid Reserve</th>
                      <th>Location</th>
                      <th>Total Bids</th>
                       <th>Total Bidders</th>
                      <th>Heighest Bid (Frws)</th>
                      <th>Auction Date</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                          <?php  foreach($biddings as $row):; ?>
                    <tr>
                    <td><img src="<?php echo Yii::$app->request->baseUrl?>/img/blue_gavel.png" alt="Product 1" class="img-circle img-size-32 mr-2"></td>
                    <td><a href="#"><?php echo $row["lot"] ; ?></a></td>
                    <td class="text-red" ><a  href="<?=Url::to(['lots/biddings','lot_id'=>$row["lot_id"]])?>"> <?php echo $row["description"]  ; ?></a></td>
                     <td nowrap><?php echo $row["quantity"] ; ?></td>
                      <td>
                         
                          <span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge badge-success"><?php echo $row["reserve_price"] ; ?></span></td>
                       <td><?php echo $row["location"] ; ?></td>
                        <td>
                             <?php if($row["tot_bid"]==0){$class="badge-danger";}else{$class="badge-primary";} ?>
                    <span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge <?php echo $class ?>"><?php echo $row["tot_bid"] ; ?></span></td>
                         <td><span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge <?php echo $class ?>"><?php echo $row["tot_bidders"] ; ?></span></td>
                         <td><span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge badge-danger"><?php echo number_format($row["highest_bid"]) ; ?></span></td>
                         <td><?php 
                         $date=date_create($row["auction_date"]);
          
                         echo date_format($date,"d/m/Y H:i:s");?></td>
                         
                    </tr>
                    
                    <?php endforeach;?>
                   
                    </tbody>
                  </table>
                </div>  
                     
                 </div> 
                   
                </div>
                
             

          
</div>
</div>
</div>
</div>

<?php
$script = <<< JS

$(document).ready(function()
                            {
         $('.action-launch').on('click',function (e) {
         
 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "This auction will be launched !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, launch it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
    if(data.flag==true){
        
        Swal.fire(
  'Success!',
  data.msg,
  'success'
)
    }else{
        
      Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: data.msg,

})  
    }
});
  }
})
    
    return false;

});   


    $('.close').on('click',function () {

 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "This auction will be closed !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, close it!'
}).then((result) => {
  if (result.value) {
   return true;
  }
})
    
    return false;

});
             
var oTable= $('.tbl').DataTable({
              
              'columnDefs': [{
                    "targets": [0],
                    "orderable": false
                }]
          });          
          
   


                                
                                
                                
                            });
                          


JS;
$this->registerJs($script);

?>
