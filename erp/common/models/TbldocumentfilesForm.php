<?php

namespace common\models;

use Yii;


class TbldocumentfilesForm extends Model
{
    
     public $uploaded_file;
     public $name;
      public $comment;
  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['uploaded_file'], 'file','skipOnEmpty'=>false],//validating inputfile
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
            
        ];
    }

   
}
