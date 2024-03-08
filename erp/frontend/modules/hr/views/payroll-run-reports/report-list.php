<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\models\ReportTemplates;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\PayrollApprovalReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
<div class="d-flex  flex-sm-row flex-column  justify-content-end mb-2">
    
        <?= Html::a('<i class="fas fa-plus"></i> Add New Report', ['create'], ['class' => 'btn btn-outline-primary btn-sm action-createx','title'=>'Add New Pay Report']) ?>
    </p>   
       
   </div>
  
  <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' =>  $dataProvider,
        'emptyText' => false,
        'columns' => [
           

              [
                 'label'=>'Description',
                 'format' => 'raw',
                 'value'=>function ($model) {
           $icon =Html::tag('i',null,
           ['class'=>'fas fa-file-pdf text-danger']); 
           
           $desc=Html::a($model->rpt_desc,['payroll-run-reports/view-pdf','id'=>$model->id],
           ['class'=>'ml-1']);
           $content=Html::tag('span',$icon.$desc,
           ['class'=>"text-blue"]);
            
          return $content;
            },'contentOptions' => ['style' =>'white-space:nowrap;']
                ],
            
          [
            'label'=>'Period Year' ,
            'value'=>function($model){
                 return  ArrayHelper::getValue($model->getParams(),'period_year') ; 
              }
              
              ],
          [
            'label'=>'Period Month' ,
            'value'=>function($model){
               
              return date("F", strtotime('00-'.ArrayHelper::getValue($model->getParams(), 'period_month').'-01'))  ; 
              }
              
              ],
           
               [
            'label'=>'Pay Group' ,
            'format' => 'raw',
            'value'=>function($model){
              $groups=PayGroups::findByCode(ArrayHelper::getValue($model->getParams(), 'pay_group'));
              if(!empty($groups)){
                  $ul='<ul style="padding:0;margin:8px;font-size:12px">';
                  foreach($groups as $g){
                      
                      $ul.='<li>'.$g->name.'</li>';
                  }
                  
                 $ul.='</ul>';
                  
                  return $ul;
              }
             
              }
              
              ],
              [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>function ($model) {
                     if($model->status !=='approved'){
                        
                        $class="badge bg-pink";  
                     }
                     else{
                        $class="badge bg-success"; 
                       }
                     
                     
                     $badge='<small class="'.$class.'" >'. $model->status.'</small> ';
                    
                return $badge;
            }
                ],
           
       [    
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<i class="fas fa-cog"></i>',
                 'contentOptions' => ['style' => 'white-space:nowrap;','class'=>""],
                  'template' => '{export-to-excel} {pdf} {view} {update} {delete}',
           
             'buttons'        => [
                  'export-to-excel'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-file-excel"></i> Export bank File', $url, ['class'=>['btn btn-outline-success text-success btn-sm'],
                            'title' => Yii::t('app', 'EXCEL')
                        ]);
                    },
                     'pdf'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-file-pdf"></i> PDF', $url, ['class'=>['btn btn-outline-warning text-danger btn-sm'],
                            'title' => Yii::t('app', 'PDF')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class'=>['btn btn-outline-primary btn-sm'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class'=>['btn btn-outline-success btn-sm'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<i class="fas fa-times"></i>', $url, ['class'=>['btn btn-outline-danger btn-sm'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Employee ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ],
                      
                      'visibleButtons' => [
    'export-to-excel' => function ($model) {
        return $model->rpt_type=='BL' ;
    },
    'update' => function ($model) {
        return $model->status=='draft' && ($model->user==\Yii::$app->user->identity->user_id || \Yii::$app->user->identity->isAdmin() );
    },
    'delete' => function ($model) {
       return $model->status=='draft' && ($model->user==\Yii::$app->user->identity->user_id || \Yii::$app->user->identity->isAdmin() );
    },
]
            
            ]
            
        ],
         'tableOptions' =>['class' => 'table table-bordered tbl-list ','id'=>'tbl-'.$rptType],
    ]); ?>
</div> 

  
</div>
</div>
</div>
</div>

<?php

$script = <<< JS

 $(document).ready(function(){
 
 $('.tbl-list').DataTable({
     destroy:true,
    ordering: false,
    info:true
 });

});
JS;
$this->registerJs($script);

?>


