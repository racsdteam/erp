<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lots';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i> All Lots</h3>
                       </div>
               
           <div class="card-body">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <p>
        <?= Html::a('Add New Lot', ['create'], ['class' => 'btn btn-success active']) ?>
    </p>
  <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
           

            [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update}{delete}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class'=>['text-success'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<i class="fas fa-times"></i>', $url, ['class'=>['text-danger'],
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
                     $class="badge bg-pink";
                     
                     $badge='<small class="'.$class.'" style="font-size:16px" >'. $_price.'</small> ';
                    
                return $badge;
            }
                ],
            
        
      'comment:ntext',
       
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
             
             'winner',
             
            'timestamp',
        ],
         'tableOptions' =>['class' => 'table  table-bordered'],
    ]); ?>
</div>
</div>
</div>
</div>
</div>
       
          <?php
         



$script = <<< JS

$(document).ready(function()
                            {
                           
             
/* $('.table1').DataTable( {
	  paging: true,
	  responsive: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth:true,
      dom: 'Bfrtip',
      buttons: [ 'copy', 'excel', 'pdf','print' ],
    
		
	
	} );
          */                  });
                          


JS;
$this->registerJs($script);

?>
