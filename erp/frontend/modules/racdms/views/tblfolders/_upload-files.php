<?php
use kartik\file\FileInput;
use yii\helpers\Url;

 echo FileInput::widget([
    'name' => 'files[]',
    'options'=>[
        'multiple'=>true,
        'accept' => 'jpg, gif, png, doc, docx, pdf, xlsx, rar, zip, xlsx, xls, txt, csv, rtf, one, pptx, ppsx, pot'
    ],
    'pluginOptions' => [
        'theme'=>'fas',
        'uploadUrl' => Url::to(['tblfolders/files-upload']),
         'browseClass' => 'btn btn-warning',
         'cancelClass' => 'btn btn-danger',
        'uploadExtraData' => [
            'folderid' =>$node->id,
           
        ],
         'msgUploadBegin' => Yii::t('app', 'Please wait, system is uploading the files'),
                'msgUploadThreshold' => Yii::t('app', 'Please wait, system is uploading the files'),
                'msgUploadEnd' => Yii::t('app', 'Done'),
                'dropZoneClickTitle'=>'',
                "uploadAsync" => false,
                "browseOnZoneClick"=>true,
                 'fileActionSettings' => [
                    'showZoom' => true,
                    'showRemove' => true,
                    'showUpload' => false,
                ],
        'maxFileCount' => 10
    ],'pluginEvents' => [
                'filebatchselected' => 'function() {
                 $(this).fileinput("upload");
                 }',



            ],
]);
?>