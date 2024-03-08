<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay Revisions';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
?>


<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                     
               
           <div class="card-body">

  <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
          'layout' => '{items}{pager}',
        'columns' => [
           

            [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{update} {activate}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i> Change', Url::to(['update','id'=>$model->id]), ['class'=>['btn btn-success btn-sm'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                   
                    
                    'activate'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-check"></i> Activate', Url::to(['activate','id'=>$model->id]), ['class'=>['btn btn-warning btn-sm btn-activate'],
                            'title' => Yii::t('app', 'Activate')
                        ]);
                    },
                      
                      
                      ]//-------end
            
            ],
            
            /* ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],*/

             [   'contentOptions' => ['style' =>'white-space:nowrap;'],
                 'label'=>'Employee',
                 'value'=>function ($model) {
                      $emp=$model->employee0;
                     
                    
                return  $emp!==null? $emp->first_name.' '.$emp->last_name: '';
            }
                ],
                
             [  
                 'label'=>'Department/Unit/Office',
                 'value'=>function ($model) {
                      $orgUnit=$model->employee0->employmentDetails->orgUnitDetails;
                     
                    
                return  !empty($orgUnit)?$orgUnit->unit_name: '';
            }
                ],
              [  
                 'label'=>'Position',
                 'format'=>'raw',
                 'value'=>function ($model) {
                      $pos=$model->employee0->employmentDetails->positionDetails;
                     
                    
                return  !empty($pos)?$model->employee0->employmentDetails->isActing()?'<b>Acting</b> '.$pos->position : $pos->position : '';
            }
                ],   
                
           
                 [
                 'label'=>'Previous Base Pay',
                 'value'=>function ($model) {
                     
                  $prevPay=$model->previousPay; 
                 
                 return !empty(  $prevPay) ? number_format(  parseFloat($prevPay->base_pay)) :'';   
                    
                
            }
                ],
              [
                 'label'=>'New Base Pay',
                 'value'=>function ($model) {
                 $newPay=$model->revisedPay; 
                 
                 return !empty($newPay) ? number_format(parseFloat($newPay->base_pay)) :'';   
                    
                
            }
                ],
                
                 [
                 'label'=>'Effective From',
                 'value'=>function ($model) {
                     
                     
                    
                return date('d/m/Y',strtotime($model->effective_date));
            }
                ],
            [
                 'label'=>'PayOut Month',
                 'value'=>function ($model) {
                
                  $dateObj   = DateTime::createFromFormat('!m', $model->payout_month);
                  $monthName = $dateObj->format('F');   
                 return $monthName ." ". $model->payout_year;   
            }
                ],
             [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>function ($model) {
                      if($model->status=='pending'){
                         $class="badge badge-warning";
                      }else if($model->status=='activated'){
                          $class="badge badge-success";
                      }else{
                          $class="badge badge-info";
                      }
                      
                      $badge='<span class="'.$class.'"> <i class="far fa-clock"></i> '. $model->status.' </span> ';
                    
                     return $model->status!=null ? $badge : '';
            }
                ],    
                
         [
                 'label'=>'Date of Revision ',
                 'value'=>function ($model) {
                     
                     
                    
                return date('d/m/Y',strtotime($model->revision_date));
            }
                ],
             [
                 'label'=>'Reason For Revision',
                 'value'=>function ($model) {
                
                
                 return $model->reason;   
            }
                ],
            
        ],
         'tableOptions' =>['class' => 'table  table-bordered'],
    ]); ?>
</div>
</div>
</div>
</div>
</div>
       
          <?php
         
  
function parseFloat($numString){
    
    return  filter_var($numString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ); 
}


$script = <<< JS

$(document).ready(function()
                            {
  $('.btn-activate').on('click',function (e) {
    e.preventDefault();
    var url=$(this).attr('href');  
       Swal.fire({
  title: 'Are you sure?',
  text: "You want to Activate This Pay Revision!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
  
  $.post({
      
        url: url,  
        success: function(res) {
      
            if(res.success){
                
       
   Swal.fire({
  icon: 'success',
  title: 'Success',
  text:res.data.msg ,
 
})
 location.reload(true);
            }else{
        Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Unable to Activate Pay Revision!',
 
})
            }
        },

        error: function(){
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
       
       
    });
  
  }
})
                
   return false;   
  });                              
                                
            });
                          


JS;
$this->registerJs($script);

?>
