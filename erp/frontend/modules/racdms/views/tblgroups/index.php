<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Security groups';
$this->params['breadcrumbs'][] = $this->title;

?>


<?php 
 
  $q1=" SELECT g.*  FROM tblgroups as g  order by g.created desc";
     $com1 = Yii::$app->db3->createCommand($q1);
     $rows = $com1->queryAll();
     $i=0;
 
?>


<div class="card card-default">
           
              
              <div class="card-body"> 
  
    <?php
              
                  // helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) use($hideCssClass) {
    $class = "alert alert-{$type} alert-dismissible";
    if ($hide) {
        $class .= ' ' . $hideCssClass;
    }
return Html::tag('div', Html::button('&times;',['class'=>'close','data-dismiss'=>'alert','aria-hidden'=>true]). '<div>' . $body . '</div>', ['class' => $class]);  
 
};
                  ?>
                  
                  
                   <div class="kv-treeview-alerts">
        <?php
        
        $session = Yii::$app->has('session') ? Yii::$app->session : null;
       
        if ($session && $session->hasFlash('success')) {
            echo $showAlert('success', $session->getFlash('success'), false);
        }
        if ($session && $session->hasFlash('error')) {
            echo $showAlert('danger', $session->getFlash('error'), false);
        }
       
        ?>
    </div>            

   <div class="table-responsive">
              <table id="groups" class="table ">
                <thead>
                <tr>
                 <th>#</th>
                  <th>Actions</th>
                  <th>Securitys Group</th>
                  <th>Created</th>
                  <th>Created By</th>
                  <th>Comment</th>
                 
                  
                 
                </tr>
                </thead>
                
                <tbody>
                                    <?php foreach($rows as $row):?>
                                 
                                   
                                  
                                    
                                    <tr>
                                        <td>
                                            <?=
                                           $i++;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         
                                         <td nowrap>
                                             
                                                                                    <div class="centerBtn">
   
 
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["tblgroups/view",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-viewx','title'=>'View Group Info'] ); ?> |
                                            
                                           
                                                 <?=Html::a('<i class="fa fa-trash"></i> Delete',
                                              Url::to(["tblgroups/delete",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-primary btn-sm active action-view','title'=>'Delete Group Info' ] ); ?>
                                            
                                             
        </div>        
                                             
                                             
                                             
                                             
                                             
                                         </td>
                                         
                                         
                                   
                                    <td>
                                            <?=
                                           $row["name"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    
                                          <td>
                                            <?php echo $row["created"]  ;?>
                                          
                                          
                                         </td>
                                         
                                          <td > <?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row['created_by']."' and pp.status=1 ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $pos=$row7['position']; 
                                           $full_name=$row7['first_name']." ".$row7['last_name'];
                                           
                                          // echo $row7['position'];
                                           echo  $pos." [ ".$full_name." ]";
                                          
                                            ?> </td>
                                         
                                          
                                           
                                            <td>
                                            <?=
                                           $row["comment"]
                                            
                                           ?>
                                          
                                          
                                         </td> 

                                            
                                               
                                             
                                        </tr>

                                     
                                    
                                    <?php endforeach;?>
                                       
                                    </tbody>
                
             
              </table>
            </div>
</div>


</div>


<?php


$script = <<< JS

 $(function () {
  
    $('#groups').DataTable({
      "paging":true,
      "lengthChange":true,
      "searching":true,
      "ordering": true,
      "info":true,
      "autoWidth": false,
   
    });
  });
JS;
$this->registerJs($script);

?>