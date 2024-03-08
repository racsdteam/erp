<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;
use yii\helpers\Url;
use lo\widgets\modal\ModalAjax;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MirrorCaseSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =$level->level_name.'s';

$this->params['breadcrumbs'][] = $this->title;

?>

 <style type="text/css">
       .modal-dialog {
          width: 1200px;
          height:1200px !important;
        }

        .modal.modal-info{
  opacity:1;
}
.modal.modal-info .modal-dialog {
   -webkit-transform: translate(0);
   -moz-transform: translate(0);
   transform: translate(0);
}
    </style>

<div class="row clearfix">



                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="box box-default color-palette-box">
                        <div class="box-header with-border">
                           
                        <h3 class="box-title"><i class="fa fa-tag"></i> <?= Html::encode($this->title) ?></h3>   
                           
                        </div>
                        
                        <div class="box-body">

                        <?php
                        
                        if (Yii::$app->session->hasFlash('success')){

                            $msg=Yii::$app->session->getFlash('success');
                            
                            echo '<script type="text/javascript">';
                            echo 'showSuccessMessage("'.$msg.'");';
                            echo '</script>';
                            
                             }
                             $i=0;
                        
                        ?>
   
   
                                <table id="usersTable"  class="table table-bordered table-striped table-hover dataTable js-exportable ">
                                    <thead>
                                        <tr>
                                        
                                        <th>#</th>
                                        <th> name</th>
                                         <th>View</th>
                                         <th>Edit</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php   $i++;?>
        
           

                                     <tr>
                                           
                                           
                                            <td><?php 
                                            
                                           
                                            
                                              echo  $i; ?></td>
                                 
                                            <td><?php echo $row["subdiv_name"]  ;?></td>
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-cubes"></i>',
                                              Yii::$app->urlManager->createUrl(["erp-org-subdivisions/view",'id'=>$row['id'],'level'=>$level->id,
                                              
                                           ])
                                          ,['class'=>'btn-info btn-sm active btn-view','title'=>$row["subdiv_name"]]); ?> </td>
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-edit"></i>',
                                              Yii::$app->urlManager->createUrl(["erp-org-subdivisions/update",'id'=>$row['id'],'level'=>$level->id
                                           ])
                                          ,['class'=>'btn-info btn-sm active btn-update','title'=>$row["subdiv_name"] ]); ?> </td>

                                         
                                            
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                       
                                    </tbody>
                                    
                                </table>

</div>
                    </div>

                   

                </div>
            </div>
<!-- displaying control modal -->  

 <div class="modal modal-info" id="modal-action">
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div id="modal-body" class="modal-body">
              <div  id="modalContent"> <div style="text-align:center"><img src="<?=Yii::$app->request->baseUrl?>/img/m-loader.gif"></div></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<?php
           


$script = <<< JS

$('.btn-view').click(function(){
    var url = $(this).attr("href"); 
    
$('#modal-action').modal('show')
 .find('.modal-body')
 .load(url);
 
return false;
              
});
function testAnim(x) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog  ' + x + '  animated');
   
};

$('#modal-action').on('show.bs.modal', function (e) {
    var anim ="zoomIn";
      testAnim(anim);
    
      
})

JS;
$this->registerJs($script);



?>




