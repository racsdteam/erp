<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_lpo".
 *
 * @property int $id
 * @property int $lpo_request_id
 * @property string $created
 * @property int $created_by
 * @property string $description
 * @property string $lpo_upload
 * @property string $status
 * @property int $is_new
 */
class ErpLpo extends \yii\db\ActiveRecord
{
    
    public $uploaded_file;
  
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_lpo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpo_request_id', 'created_by', 'is_new'], 'integer'],
            [['created'], 'safe'],
            [['created_by', 'description', 'lpo_upload','lpo_number','type'], 'required'],
            [['description', 'status','type'], 'string'],
            [['lpo_upload','lpo_number','file_name'], 'string', 'max' => 255],
             //[['uploaded_file'], 'file', 'extensions'=>'pdf,jpg,png'],//validating inputfile
              ['uploaded_file', 'required',
                'when' => function ($model) {
                    return false;
                },
                'whenClient' => "function (attribute, value) {    
              return ($('.field-erplpo-uploaded_file .file-input .kv-file-content').find('embed').length == 0 );
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
            'lpo_request_id' => 'LPO Request ID',
            'created' => 'Created',
            'created_by' => 'Created By',
            'description' => 'Description',
            'lpo_upload' => 'Lpo Upload',
            'status' => 'Status',
            'is_new' => 'Is New',
        ];
    }
    
    public static function findByRequester($requester){
      
       $query=self::find()->alias('tbl_lpo')->select(['tbl_lpo.*','tbl_req.requested_by'])
      ->innerJoin('erp_lpo_request as tbl_req', 'tbl_req.id = tbl_lpo.lpo_request_id')
       ->where(['tbl_req.requested_by'=>$requester]);
       $rows=$query->orderBy(['tbl_lpo.created' => SORT_DESC])->asArray()->all(); 
       
      return $rows;
      
    }
}
