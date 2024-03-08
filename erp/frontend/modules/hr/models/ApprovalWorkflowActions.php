<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "approval_workflow_actions".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 */
class ApprovalWorkflowActions extends \yii\db\ActiveRecord
{
     public const APRV_CODE='APRV';
     public const RJT_CODE='RJT';
     public const REV_CODE='REV';
     public const RET_CODE='RET';
     public const RASS_CODE='RASS';
     public const RSBM_CODE='RSMB';
     public const ARC_CODE='ARC';
     public const VF_CODE='VF';
     public const CTF_CODE='CTF';
     public const STMP_CODE='STMP';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'approval_workflow_actions';
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
            [['name', 'code'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
        ];
    }
    
    public static function findByCode($code){
      
      return self::find()->where(['code'=>$code])->One();  
        
    }
    
    public  function getHtmlAttributes(){
         $html=[]; 
         switch($this->code){
                   
                       case  self::APRV_CODE :
                         $html['btnClass']='btn btn-success';
                         $html['icon']='<i class="far fa-thumbs-up"></i>';
                          
                        break;
                         case self::RJT_CODE :
                         $html['btnClass']='btn btn-danger';
                         $html['icon']='<i class="far fa-thumbs-down"></i>';
                         break;
                     case self::RET_CODE  :
                         $html['btnClass']='btn btn-warning';
                         $html['icon']='<i class="fas fa-undo"></i>';
                         break;
                        case self::REV_CODE  :
                         $html['btnClass']='btn btn-info';
                         $html['icon']='<i class="fas fa-share"></i>';
                         break;  
                         case self::VF_CODE  :
                         $html['btnClass']='btn btn-info';
                         $html['icon']='<i class="fas fa-thumbs-up"></i>';
                         break; 
                          case self::CTF_CODE  :
                         $html['btnClass']='btn btn-info';
                         $html['icon']='<i class="fas fa-stamp"></i>';
                         break; 
                       case self::RASS_CODE  :
                         $html['btnClass']='btn btn-secondary';
                         $html['icon']='<i class="fas fa-share"></i>';
                         break;
                       
                        case self::RSBM_CODE  :
                         $html['btnClass']='btn btn-info';
                         $html['icon']='<i class="fas fa-share"></i>';
                         break;
                         case self::ARC_CODE  :
                        $html['btnClass']='btn btn-info';
                        $html['icon']='<i class="fas fa-archive"></i>';
                         break;
                         case self::STMP_CODE  :
                        $html['btnClass']='btn btn-info';
                        $html['icon']='<i class="fas fa-stamp"></i>';
                         break;
                         default:
                        $html['btnClass']='btn btn-default';
                        $html['icon']='<i class="fas fa-cog"></i>';
                        
                }
                
                return $html;
    }
}
