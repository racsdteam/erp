<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Tbldocumentcontent;
use kartik\tabs\TabsX;
use common\models\Tblfolders;


/* @var $this yii\web\View */
/* @var $model common\models\Tbldocuments */

$folder=Tblfolders::find()->where(['id'=>$model->folder])->One();

$this->title = $model->name;

if($folder!=null){
    
$this->params['breadcrumbs'][] = ['label' => $folder->name, 'url' => ['tblfolders/view2','id'=>$folder->id]];    

    
}

$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>

<?php
$session = Yii::$app->has('session') ? Yii::$app->session : null;

$content=Tbldocumentcontent::find()->where(['document'=>$model->id])->orderBy(['version' => SORT_DESC])
      ->all();
 $contentFirst=$content[0];
 
 
     
  if(!empty($content)){
      
    foreach($content as $c) {
        
     $active=$contentFirst->id==$c->id?true:false;
   
      
       $items[]= [
        'label'=>'<i class="fas fa-layer-group"></i> Version '.$c->version,
        'content'=>$content2,
        'active'=>$active,
        'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/racdms/tbldocuments/get-content-by-version','id'=>$model->id,'v'=>$c->version])]
    ]; 
        } 
      
  }


?>


<div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
             
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
        if ($session && $session->hasFlash('success')) {
            echo $showAlert('success', $session->getFlash('success'), false);
        }
        if ($session && $session->hasFlash('error')) {
            echo $showAlert('danger', $session->getFlash('error'), false);
        }
       
        ?>
    </div>
                  

            <?php
            
          echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false,
    'bsVersion'=>4
]);
            ?>
           
                  </div>
                  
                   </div>
                   
                    </div>
                    
                     </div>
                     
                      </div>
                      
                      <?php
                      $this->registerJs('
$("document").ready(function() {
setTimeout(function() {
$(".tabs-krajee").find("li a.active").click();
},10);
});', \yii\web\View::POS_READY);
                      ?>

