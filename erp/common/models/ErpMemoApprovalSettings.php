<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_approval_settings".
 *
 * @property int $id
 * @property int $memo_id
 * @property int $final_approver
 * @property int $user
 * @property string $timestamp
 */
class ErpMemoApprovalSettings extends \yii\db\ActiveRecord
{
    public $approver_position; 
    public $approver_name;
    
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo_approval_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memo_id', 'final_approver', 'user','approver_position','approver_name'], 'required'],
            [['memo_id', 'final_approver', 'user'], 'integer'],
            [['timestamp'], 'safe'],
            [['approver_position','approver_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'memo_id' => 'Memo ID',
            'final_approver' => 'Final Approver',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    
    public  function isFinalApprover($user){
     
      $approvalDate = date('Y-m-d');
      $approvalDate=date('Y-m-d', strtotime($approvalDate));
      
      $activeInterim=Yii::$app->muser->getInterim($user,$this->final_approver,$approvalDate);  
      return $user==$this->final_approver || $activeInterim!=null;
        
        
    }
    

    
  
    
    public static function findByMemo($memo){
         
         return self::find()->where(['memo_id'=>$memo])->orderBy(['timestamp' => SORT_DESC])->One();   
        
    }
}
