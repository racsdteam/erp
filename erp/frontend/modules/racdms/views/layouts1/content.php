<?php
use yii\bootstrap4\Breadcrumbs;
use yii\widgets\AlertLte;
use yii\helpers\Html;
?>
	
      
<!-- Content Wrapper. Contains page content -->
	  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div style="padding:5px !important;"class="content-header">
		
 <div class="container-fluid">
   
   <div class="row mb-2  ml-2">
   <?=
			Breadcrumbs::widget([
			    'encodeLabels'=>false,
			    'homeLink' => [ 
                      'label' =>Html::encode(Yii::t('yii', 'Home')),
                     
                      'url' => Yii::$app->homeUrl,
                 ],
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				
			]) ?>
		 </div>	
			 </div>
        </div>
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
			<?= $content ?>
			 </div>
        </div><!-- /.content -->
      </div><!-- /.content-wrapper -->
