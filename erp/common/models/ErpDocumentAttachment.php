<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_attachment".
 *
 * @property int $id
 * @property string $attach_title

 * @property int $user
 * @property string $timestamp
 */
class ErpDocumentAttachment extends \yii\db\ActiveRecord
{
    
    public $attach_uploaded_file;
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['user',], 'integer'],
            [['timestamp'], 'safe'],
            [['attach_title'], 'string', 'max' => 255],
          
          // [['attach_uploaded_file'], 'file', 'extensions'=>'pdf,jpg','skipOnEmpty'=>false,'maxFiles' => 100,'minFiles'=>1],//validating inputfile
           ['attach_uploaded_file', 'required',
                'when' => function ($model) {
                    return false;
                },
                'whenClient' => "function (attribute, value) {
               
              return ($('.item .file-input .kv-file-content').find('embed').length == 0 );
            }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
           // 'attachement' => 'Attachement',
            //'type' => 'Type',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}
