<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Termination Reasons';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
  $alert=function($msg,$type){
      $alert='';
      switch($type){
       
       case 'success':{
            $alert.='<script type="text/javascript">';
             $alert.="Swal.fire({
                  position: 'center',
                  icon: '".$type."',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
           $alert.= '</script>';
           
           break;
       } 
       
        case 'error':{
        $class="alert alert-danger alert-dismissible"; 
        $closeBtn=Html::button('&times;',['class' =>'close','data-dismiss'=>'alert','aria-hidden'=>true]);
        $h4= Html::tag('h4',Html::tag('i', '', ['class' => 'icon fa fa-ban']));
       
        $alert= Html::tag('div',$closeBtn.$h4.$msg, ['class' => $class]);
          
           break;
       } 
          
      }
     
    return $alert;     
  };

?>
 
<?php 

if (Yii::$app->session->hasFlash('success')){
    
    echo $alert(Yii::$app->session->getFlash('success'),'success');  
  }
elseif(Yii::$app->session->hasFlash('error')){
    
   echo $alert(Yii::$app->session->getFlash('error'),'error');     
}



   ?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                     
               
           <div class="card-body">

   <div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Add Termination Reason ', ['create'], 
                                                                           ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'Add Termination Reason']) ?>
    </p>   
       
   </div>
   
  <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
          'layout' => '{items}{pager}',
        'columns' => [
           

            [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update}{delete}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class'=>['text-success action-create'],
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

            'name',
          'code',
           'description',
            
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
 
                           });
                          


JS;
$this->registerJs($script);

?>
