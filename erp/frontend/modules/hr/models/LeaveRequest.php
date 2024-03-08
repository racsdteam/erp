<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;

/**
 * This is the model class for table "leave_request".
 *
 * @property int $id
 * @property string $employee_position_appointment
 * @property string $leave_financial_year
 * @property string $leave_category
 * @property string $request_start_date
 * @property string $request_end_date
 * @property int $number_days_requested
 * @property int $number_days_remaining
 * @property string $reason
 * @property string $status
 * @property int $user_id
 * @property string $timestamp
 */
class LeaveRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     
    public $position_interim;
    public $employee_interim;
    public $views;
    const VIEW_TYPE_PDF='form-pdf';
    const VIEW_TYPE_VIEWER='viewer';
   
    public function init(){
         
         parent::init();
         $this->setViews();
     }
     
    
    public static function tableName()
    {
        return 'leave_request';
    }
    
    
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_position_appointment', 'leave_financial_year', 'leave_category', 'request_start_date', 'request_end_date', 'number_days_requested','user_id'], 'required'],
            [['number_days_requested', 'user_id','position_interim','employee_interim'], 'integer'],
            [['reason', 'status'], 'string'],
            [['employee_position_appointment'], 'string', 'max' => 250],
            [['leave_financial_year'], 'string', 'max' => 10],
            [['number_days_requested'],'number','min'=>0,'max'=>183],
            [['leave_category'], 'string', 'max' => 100],
            [['request_start_date', 'request_end_date'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_position_appointment' => 'Employee Position Appointment',
            'leave_financial_year' => 'Leave Financial Year',
            'leave_category' => 'Leave Category',
            'request_start_date' => 'Leave Start Date',
            'request_end_date' => 'Leave End Date',
            'number_days_requested' => 'Number Days Requested',
            'number_days_remaining' => 'Number Days Remaining',
            'reason' => 'Reason',
            'position_interim' => 'Position Interim',
            'employee_interim' => 'Staff who will be your Interim',
            'status' => 'Status',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }
    
    public function getWfInstance()
{
    return $this->hasOne(LeaveApprovalInstances ::className(), ['entity_record' => 'id'])->andOnCondition(['entity_type' =>$this->formName()]);
} 

    public function getWfComments()
{
    return $this->hasMany(LeaveApprovalComments ::className(), ['request' => 'id'])->orderBy(['timestamp'=>SORT_DESC]) ;
} 


   public function getCategory()
{
    return $this->hasOne(LeaveCategory ::className(), ['id' => 'leave_category']);
} 


   public function getRequester()
{
    return $this->hasOne(User ::className(), ['user_id' => 'user_id']);
} 

   public function getRequesterPosition()
{
    return $this->hasOne(ErpOrgPositions ::className(), ['position_code' => 'employee_position_appointment']);
} 

  public function getRequesterOrgUnit()
{
    return $this->hasOne(ErpOrgUnits ::className(), ['unit_code' => 'employee_org_unit']);
} 

public  function isSubmitted(){
 
 return $this->wfInstance != null;   
    
}

protected function setViews(){
  $this->views = [
            'form-pdf' => '/leave-request/pdf',
            'viewer' => '/leave-request/viewer',
           
        ];   
   
}


public function view($type){
 
 switch($type){
     
   
      case self::VIEW_TYPE_PDF :
         
         return $this->views['form-pdf'];    
         break;
        case self::VIEW_TYPE_VIEWER :
         
         return $this->views['viewer'];    
         break;  
       
      default:
      return $this->views['viewer']; 
 }   
    
}

}
