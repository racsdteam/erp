<?php
 use frontend\modules\hr\models\Employees;
 use frontend\modules\hr\models\EmpPhoto;
 use frontend\modules\hr\models\EmpDocumentsSearch;
  use frontend\modules\hr\models\EmployeeDocsCategories;
 use yii\helpers\Url;
 use kartik\tabs\TabsX;

$bank=$model->bankDetails;

 ?>
<style>
    
ul.basic-info li a,ul.cont-info li a,ul.addr-info li a {color:black;}   
    
</style> 
 <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="far fa-folder-open"></i> Employee Documents</h3>
                <div class="card-tools">
                  <a href="<?=Url::to(['emp-documents/create','employee'=>$model->id])?>"  class="btn btn-tool btn-sm action-create" title="Add  Document">
                  <i class="far fa-plus-square"></i>
                  </a>
                 
                </div>
              </div>
              <div class="card-body table-responsive p-0 ">
                   <?php   
   $Url_items = array();
   $doc_categories=EmployeeDocsCategories::find()->all();
   $i=0;
  foreach( $doc_categories as $doc_categorie):  
      $searchModel = new EmpDocumentsSearch();
      $dataProvider = $searchModel->search([$searchModel->formName()=>["employee"=>$model->id,"category"=>$doc_categorie->code]]);
      $i++;
    $url_item =[
        'label'=>'<i class="fab fa-wpforms"></i>'.$doc_categorie->name,
        'content'=>Yii::$app->controller->renderPartial('@frontend/modules/hr/views/emp-documents/employee', [
          'dataProvider' => $dataProvider,
          'code'=>$doc_categorie->code
        ]),
        'active'=> $i==1 ? true : false,
         ];
         array_push($Url_items, $url_item);
         
         
  endforeach;
 ?>  
 <div class="d-flex flex-sm-row flex-column">
  <div class="col-md-12">
      
     <?php echo TabsX::widget([
    'items'=>$Url_items,
    'position'=>TabsX::POS_LEFT,
    'pluginOptions'=>['enableCache'=>false],
    'encodeLabels'=>false,
   
    
]);?>    
      
  </div>
  </div>
               
             
              </div>
            </div>