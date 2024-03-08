<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $created_by
 * @property string $created_at
 */
class ErpMemo extends \yii\db\ActiveRecord
{
    
   public $action;
   public $remark; 
   public $employee;
   public $employee_cc;
  
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','type', 'description', 'created_by','memo_code'], 'required'],
            [['description','memo_code','status'], 'string'],
            [['created_by','type','is_new','user_position'], 'integer'],
            [['created_at','expiration_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'type'=>'Memo For',
            'expiration_date'=>'Expiration Date (Set your Memo to expire automatically if they are not approved)'
        ];
    }
    
    public function getCreator()
{
    return $this->hasOne(User::className(), ['user_id' => 'created_by']);
}
   public function getCateg()
{
    return $this->hasOne(ErpMemoCateg::className(), ['id' => 'type']);
}
}
