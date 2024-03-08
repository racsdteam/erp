<?php

namespace common\models;

use Yii;


class TbldocumentsDetails extends Model
{
    
     public $uploaded_file;
     public $document;
     public $name;
     public $comment;
     public $expires;
  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          
           
            [['document'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['comment'], 'string'],
            ['expires','safe'],
            [['uploaded_file'], 'file','extensions'=>'jpg, gif, png, doc, docx, pdf, xlsx, rar, zip, xlsx, xls, txt, csv, rtf, one, pptx, ppsx,pot',
            'skipOnEmpty'=>false],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           
            'comment' => 'Comment',
            'name' => 'Name',
            'uploaded_file'=>'Document File',
            'expires'=>'Expires'
            
        ];
    }

   
}
