<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Changes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-changes-index">

  <div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i> Payrolls List</h3>
                       </div>
               
           <div class="card-body">
               
                        <?php 

if (Yii::$app->session->hasFlash('success')){
    
    echo Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));  
  }
elseif(Yii::$app->session->hasFlash('error')){
    
   echo Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));    
}
   ?>

<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
 
 <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Create  New Payroll Changes', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Payroll']) ?>
    </p>               
                  <!-- /.btn-group -->
                </div>
     
       
   </div>

   <div class="table-responsive">
                  <table id="tbl-payroll"  class=" table table-bordered">
                    <thead>
                    <tr>
                        <th><i class="fas fa-cog"></i> </th>
                        <th>Title</th>
                        <th>Created By</th>
                      </tr>
                    
                    </thead>
                    <tbody>
                      
                    <?php foreach($dataProvider->getModels() as $model):  ?> 
                   
                    <tr>
                    
                    <td nowrap>
                    <div class="margin">
                      <div class="btn-group">
                       <?= Html::a('<i class="fas fa-binoculars"></i> Open', Url::to(['payroll-changes/pdf','id'=>$model->id]), ['class'=>['btn btn-info btn-sm btn-flat text-light'],
                            'title' => Yii::t('app', 'Edit')
                        ]); ?>
                         
                      </div>
                      
                      <div class="btn-group">
                       <?= Html::a('<i class="fas fa-pencil-alt"></i> Change', Url::to(['payroll-changes/update','id'=>$model->id]), ['class'=>['btn btn-success btn-sm btn-flat text-light'],
                            'title' => Yii::t('app', 'Edit')
                        ]); ?>
                         
                      </div>
                      
                      <div class="btn-group">
                          <?=
                          
                          Html::a('<i class="fas fa-times"></i> Delete', Url::to(['payroll-changes/delete','id'=>$model->id]), ['class'=>['btn btn-danger btn-sm btn-flat text-light'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Employee ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                          ?>
                      </div>
                  </td>   
                    <td><?=$model->title?></td>
                    <td><?=$model->creator->first_name ?> <?=$model->creator->last_name ?></td>
                      </tr>
                      <?php endforeach ?>
                      
                     
                    </tbody>
                  </table>
                </div> 
    
 
</div>
</div>
</div>
</div>
</div>
