<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_requisition".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property int $created_by
 * @property int $created_at
 * @property int $reference_memo
 * @property int $approve_status
 * @property int $is_tender_on_proc_plan
 */
class ErpRequisition extends \yii\db\ActiveRecord
{
   public $action;
   public $remark; 
   public $recipients;
   public $recipients_names;
   public $excel_file;
   public $choice;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_requisition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requisition_code','title', 'type', 'requested_by', 'requested_at','currency_type', 'reference_memo', 'approve_status','is_tender_on_proc_plan'], 'required'],
            [['type', 'requested_by', 'requested_at', 'reference_memo', 'approve_status', 'is_tender_on_proc_plan','is_new'], 'integer'],
            [['requisition_code','title','remark'], 'string', 'max' => 255],
            [['excel_file'], 'file','skipOnEmpty' => true, 'extensions' => 'xls, xlsx', 'maxSize'=>1024*1024*20],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'type' => 'Requisition For ',
            'requested_by' => 'Requested By',
            'requested_at' => 'Requested At',
            'reference_memo' => 'Reference Memo',
            'approve_status' => 'Approve Status',
            'currency_type' => 'Currency Type',
            'is_tender_on_proc_plan' => 'Is the tender on Procurement plan ?',
        ];
    }
    
    public function getItems(){
    
     return $this->hasMany(ErpRequisitionItems::className(), ['requisition_id' => 'id']);
     
}

public  function getCreator() {
       
        return $this
        ->hasOne(User::className(), ['user_id' => 'requested_by']);
       
}

public  function getCategory() {
       
        return $this
        ->hasOne(ErpRequisitionType::className(), ['id' => 'type']);
       
}

public  function getMemo() {
       
        return $this
        ->hasOne(ErpMemo::className(), ['id' => 'reference_memo']);
       
}

public function isOwner($user){
    
    return $this->requested_by==$user;
}
public function isReturned(){
    
    return $this->approve_status=='Returned';
}

public function isApproved(){
    
    return $this->approve_status=='approved';
}

public function isSubmitted(){
    
    return $this->approve_status=='processing';
}

}
