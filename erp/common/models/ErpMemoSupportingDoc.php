<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_supporting_doc".
 *
 * @property int $id
 * @property int $type
 * @property string $doc_upload
 * @property string $doc_name
 * @property int $memo
 */
class ErpMemoSupportingDoc extends \yii\db\ActiveRecord
{
    
    public $doc_uploaded_files;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo_supporting_doc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['title', 'doc_upload', 'doc_name', 'memo','uploaded_by'], 'required'],
            [[ 'memo','uploaded_by'], 'integer'],
            ['uploaded','safe'],
            [['doc_upload', 'doc_name','title'], 'string', 'max' => 255],
           [['doc_uploaded_files'], 'file', 'extensions'=>'pdf,jpg','skipOnEmpty'=>true,'maxFiles' => 10,'minFiles'=>1],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'doc_upload' => 'Doc Upload',
            'doc_name' => 'Doc Name',
            'memo' => 'Memo',
        ];
    }
}
