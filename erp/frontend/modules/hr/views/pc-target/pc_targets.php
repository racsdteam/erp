<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\modules\hr\models\PcTargetMillstone;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Targets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-target-index">

 
<div class="card text-black">
                        <div class="card-header">
                           
                            <h6 class="fa"> <i class="fa fa-opencart"></i><?= $this->title ?></h6>
                     
                        </div>
             <div class="card-body">
                         
    <div class="table-responsive">                    
 <table class="table table-cases table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                           <th align="center">Target Output</th>
                                             <th align="center">Target Indicator</th>
                                        <th>Q1 Output(s) </th>
                                          <th>Q2 Output(s)</th>
                                            <th>Q3 Output(s)</th>
                                          <th>Q4 Output(s)</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($dataProvider)){
                                    foreach($dataProvider as $model):
                                    $q1_targets=PcTargetMillstone::find()->where(["target_id"=>$model->id, "quarter"=>"Q1"])->all();    
                                   $q2_targets=PcTargetMillstone::find()->where(["target_id"=>$model->id, "quarter"=>"Q2"])->all();    
                                   $q3_targets=PcTargetMillstone::find()->where(["target_id"=>$model->id, "quarter"=>"Q3"])->all();    
                                   $q4_targets=PcTargetMillstone::find()->where(["target_id"=>$model->id, "quarter"=>"Q4"])->all();    
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr class="<?php if($row1['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                        
                                         <td>
                                            <?=
                                           $i++;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["leave-request/view",'id'=>$model->id])
                                          
                                          ,['class'=>'btn-info btn-sm active action-viexw','title'=>'View Leave Info'] ); ?>
                                          
                                          
                                         
                         </div>
                                   
                                          </td > 
                                         
                                     <td >
                                    <?= $model->output ?> 
                                    </td>    
                                    <td >
                                    <?= $model->indicator ?>
                                    </td>
                                     <td>
                                  <?php if($q1_targets!=null):
                                      foreach($q1_targets as $target):
                                      ?>
                                     <p> <?= $target->millstone ?></p>
                                  <?php endforeach;
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>
                                    </td>
                                    <td>
                                         <?php if($q2_targets!=null):
                                      foreach($q2_targets as $target):
                                      ?>
                                     <p> <?= $target->millstone ?></p>
                                  <?php endforeach;
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   
                                    </td>  
                                    <td>
                                         <?php if($q3_targets!=null):
                                      foreach($q3_targets as $target):
                                      ?>
                                     <p> <?= $target->millstone ?></p>
                                  <?php endforeach;
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>        
                                    </td> 
                                     <td>
                                         <?php if($q4_targets=null):
                                      foreach($q4_targets as $target):
                                      ?>
                                     <p> <?= $target->millstone ?></p>
                                  <?php endforeach;
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>        
                                    </td>
                                
                                        </tr>

                                     
                                    
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
                                    </tbody>
                                </table>
                                 </div>
</div>
</div>
</div>