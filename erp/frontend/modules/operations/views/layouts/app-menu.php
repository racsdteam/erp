<?php
use frontend\assets\AppAsset;
use yii\helpers\Html;
use frontend\assets\MaterialAdminLteAsset;

/* @var $this \yii\web\View */
/* @var $content string */

MaterialAdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <?php $this->head() ?>
   
</head>
<body class="hold-transition  layout-top-nav">

<?php $this->beginBody() ?>
<div class="wrapper">
    <?= $this->render('header.php', ['baserUrl' => $baseUrl, 'title'=>Yii::$app->name]) ?>
   
    <?= $this->render('content.php', ['content' => $content]) ?>
    <?= $this->render('footer.php', ['baserUrl' => $baseUrl]) ?>
   
  
   
</div>
  

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
