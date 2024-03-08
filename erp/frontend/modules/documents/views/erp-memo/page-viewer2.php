<?php
use yii\helpers\Url;

use yii\helpers\Html;

use common\models\User;

use kartik\detail\DetailView;

use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use frontend\assets\PdfTronViewerAsset;
PdfTronViewerAsset::register($this);
?>
<style>
    
   figure {
  
  text-align: center;
  font-style: italic;
  font-size: smaller;
  text-indent: 0;
  border: thin silver solid;
  
}
I 
    
</style>

 <?php
 $ser_domain='https://rac.co.rw';

 $url=Url::to(['erp-requisition/pdf-data','id'=>$model->id]);
             $full_path=$ser_domain.$url;
             
     
   
     ?>

<figure>
  <div style="height: 600px;" id="viewerpage2<?php echo $model->id ?>"></div>
  <figcaption>Purchase Requisition Form </figcaption>
</figure>





</div>

           

  <!--commenting   --> 
  
          <?php

             $serverURL=Url::to(['erp-requisition-annotations/annotations-handler']);
             $id=$model->id;
 
$user_id=Yii::$app->user->identity->user_id;
$q2="SELECT u.*,pos.*,s.signature from user  as u inner join erp_persons_in_position  as 
        pp on pp.person_id=u.user_id inner join erp_org_positions as 
        pos on pos.id=pp.position_id left join signature as s on u.user_id=s.user where pp.person_id={$user_id} ";
        $com2 = Yii::$app->db->createCommand($q2);
        $row = $com2->queryOne();
  //-----------------------------------------doc author-------------------------       
        // $author=$row['first_name']." ".$row['last_name']."/".$row['position'];
         $fn=$row['first_name'];
         $ln=$row['last_name'];
         $position=$row['position'];
         $signature=$row['signature'];
 
       

$script = <<< JS
var user = {fn: '{$fn}', ln:'{$ln}', pos:'{$position}',signature:'{$signature}'};
/*
 var viewerElement  = document.getElementById('tcviewer');
  var viewer= new PDFTron.WebViewer({
    path: '/erp/lib',
    l:'Rwanda Airports Company(rac.co.rw):ENTERP:RAC ERP::B+:AMS(20200310):A2A591AD0457A60A3360B13AC9A2737820616F996CB37A0595857BAA1AE768AE62B431F5C7',
    initialDoc:'{$full_path}',
    documentType: 'pdf',
    custom: JSON.stringify(user),
    config: "/erp/lib/config.js",
    serverUrl: '{$serverURL}',
    documentId:'{$id}'
    // replace with your own PDF file
    // optionally use WebViewer Server backend, demo.pdftron.com would later need to be replaced with your own server
    // pdftronServer: 'https://demo.pdftron.com'
  }, viewerElement );
  
  viewerElement.addEventListener('ready', () => {
  const viewerInstance = viewer.getInstance();
 
});*/

/*
 $('.pagination li a').on('click', function(e) {
     
     e.preventDefault();

        e.stopPropagation();
    viewer.loadDocument('https://rac.co.rw/erp/doc/erp-travel-clearance/pdf-data?id=33', { documentId: 'id2' });
     $(this).closest('li').addClass('active');
  });
  
  */

showViewer( '{$full_path}','{$serverURL}','{$id}', user ,'viewerpage2{$id}' );
/*var viewerElement = document.getElementById('tcviewer');
 var myWebViewer = new PDFTron.WebViewer({ ... }
, viewerElement);
*/


JS;
$this->registerJs($script);

?>

