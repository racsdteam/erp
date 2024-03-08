<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registed Items informations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itemlist-index row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
               
           <div class="card-body"> 
       <?php 
        
 $q1=" SELECT i.*  FROM    items as i   order by i.timestamp desc";
     $com1 = Yii::$app->db1->createCommand($q1);
     $rows = $com1->queryAll();
       
       ?>
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       <th>#</th>
                                        <th>Item Code </th>
                                        <th>Item Name</th>
                                        <th>Item Category</th>
                                        <th>Item Sub Category</th>
                                        <th>Item Tech Specs</th>
                                        <th>Item Actual Stock</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
 <?php $i=0;
 foreach($rows as $row ):
      $q1=" SELECT c.name as category,s.name as sub_category FROM  categories as c  
  inner join sub_categories as s  on c.id=s.category
 inner join items as i  on s.id=i.it_sub_categ
 where i.it_sub_categ='".$row['it_sub_categ']."'";
 $com1 = Yii::$app->db1->createCommand($q1);
 $row1 = $com1->queryOne();
 $i++;                                
$actual_stock= Yii::$app->logistic->getActualStock($row['it_id']) ;                  
                                  ?>
                                   
                                   
                                     <tr>
                                         <td>
                                     <?php echo  $i; ?>
                 
                                     </td>
                                           <td><?php echo $row["it_code"]; ?></td>
                                        <td><?php echo $row["it_name"]; ?></td>
                                        <td><?php  echo  $row1["category"];  ?> </td>
                                        <td><?php  echo  $row1["sub_category"];  ?> </td>
                                         <td><?php echo $row["it_tech_specs"] ; ?></td>
                                          <td><?php echo $actual_stock." ".$row["it_unit"] ?> </td>
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