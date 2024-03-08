<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpOrgUnitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp Org Units';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
  $alert=function($msg,$type){
      $errorOrSuccess=$type==1?'success':'error';
      $alertScript='<script type="text/javascript">';
      $alertScript.="Swal.fire({
                  position: 'center',
                  icon: '".$errorOrSuccess."',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
       $alertScript.= '</script>'; 
       
       return $alertScript;
      
  };

?>

<?php 

if (Yii::$app->session->hasFlash('success')){
    
    echo $alert(Yii::$app->session->getFlash('success'),1);  
  }
elseif(Yii::$app->session->hasFlash('error')){
    
   echo $alert(Yii::$app->session->getFlash('error'),0);     
}

$unitService=Yii::$app->unit;
$unitTypes=$unitService->getAllUnitTypes();

   ?>
<div class="card card-primary card-outline">
          <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users"></i> Company Structure</h3>
          </div>
          <div class="card-body">
             
              <div class="callout callout-info">
                  <h5>Company Structure!</h5>

                  <p> Company structure is a combination of three ERP features: departments,units,offices and positions.</p>
                </div>
          
          <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
             
             <?php foreach($unitTypes as $uType) : ?>
            
              <li class="nav-item">
                <a class="nav-link <?php echo $uType->level_code=='O'?'active':'' ?>" 
                id="custom-content-above-<?php echo $uType->level_code ?>-tab" 
                data-toggle="pill" href="#custom-content-above-<?php echo $uType->level_code?>" role="tab" 
                aria-controls="custom-content-above-<?php echo $uType->level_code ?>" aria-selected="true">
                   <i class="fas fa-building"></i> <?php echo $uType->level_name ?> </a>
              </li>
             
             <?php endforeach; ?>
             
            
            </ul>
            
            <div class="tab-custom-content d-flex  flex-sm-row flex-column  justify-content-end  mt-2 ">
            
  <?= Html::a('<i class="fas fa-plus"></i> Add Org Unit ', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'Add New Unit']) ?>
       
       
   
            </div>
           
            <div class="tab-content" id="custom-content-above-tabContent">
                
                
                
              <?php foreach($unitTypes as $uType) : ?>
           
              <div class="tab-pane fade <?php echo $uType->level_code=='O'?'active show':'' ?> " 
              id="custom-content-above-<?php echo $uType->level_code ?>" role="tabpanel" 
               aria-labelledby="custom-content-above-<?php echo $uType->level_code ?>-tab">
            
          
            
            
               <?php
               $provider=$unitService->getAllUnitsByType($uType->level_code);
               
               ?>
               <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' =>  $provider,
        //'filterModel' => $searchModel,
        'columns' => [
           

            [    
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<i class="fas fa-cog"></i>',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update}',
           
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
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Employee ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ]//-------end
            
            ],
            
             ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],

           
             [
                 'label'=>'Name',
                 'value'=>function ($model) {
                     
                      
                    
                return $model->unit_name;
            }
                ],
            [
                 'label'=>'Code',
                 'value'=>function ($model) {
                     
                      
                    
                return $model->unit_code;
            }
                ],
             
              [
                 'label'=>'Parent Unit',
                 'value'=>function ($model) {
                      $p=$model->parent;
                      
                    
                return  $p!==null? $p->unit_name : '';
            }
                ],
           
             
           
     
            
        ],
         'tableOptions' =>['class' => 'table table-bordered  ','id'=>$uType->level_code],
    ]); ?>
</div>
              </div>
              
              <?php endforeach;?>
              
              
            
            </div>
          </div>
          <!-- /.card -->
        </div>  
