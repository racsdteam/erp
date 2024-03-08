<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;



/**
 * This is the model class for table "user".
 *
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $approved
 * @property int $user_level
 * @property int $created_at
 * @property int $updated_at
 * @property int $user_image
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_ADMIN=1;
    const ROLE_HOD=2;
    const ROLE_CUSTOMERCARE=3;
    const ROLE_MD=4;
    const ROLE_DMD=5;
    const ROLE_PA=6;
    const ROLE_RECEPTIONIST=7;
    const ROLE_HOU=8;
    const ROLE_OFFICER=9;
    const ROLE_RCR_ASS=13;
    const ROLE_PRL_OFFICER=15;
   

    public $photo_uploaded_file;
    public $org_unit;
    public $position;
    public $level;
   

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'approved', 'user_level','org_unit','position' ], 'integer'],
            [['first_name', 'last_name', 'phone', 'username', 'password_hash', 'password_reset_token', 'email','user_image'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['photo_uploaded_file'], 'file', 'extensions'=>'jpg,png','skipOnEmpty'=>true],//validating input file
          
          
        ];
    }
     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
           
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'approved' => 'Approved',
            'user_level' => 'User Level',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'photo_uploaded_file'=>'Profile Picture',
        ];
    }

       /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
   
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE,'approved'=>true]);
    }
     public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
      /*  if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
*/
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public static function isAdminUser() {
     
     $user_role=Yii::$app->user->identity->user_level;
     
       if($user_role==self::ROLE_ADMIN){
           
           return true;
       }else{
           return false;
           
       }
       
        
}

   public static function isAdmin() {
     
 if(Yii::$app->user->identity->user_level==self::ROLE_ADMIN){
           
           return true;
       }else{
           return false;
           
       }
       
        
}

 public static function isPayrollOfficer() {
     
 if(Yii::$app->user->identity->user_level==self::ROLE_PRL_OFFICER){
           
           return true;
       }else{
           return false;
           
       }
       
        
}

 public function isRCR_Ass_User() {
     
   if($this->user_level==self::ROLE_RCR_ASS){
           
           return true;
       }else{
           return false;
           
       }
       
        
}

 public function isMemberOfGroup($group,$isUnitGroup) {
  
  if($isUnitGroup){
      
   $unit=ErpOrgUnits::find()->where(['unit_code'=>$group])->one();
   
   if(!$unit)
   return false;
   return $unit->isMember($this);
      
      
     }else{
         
         return false;
     }
  
       
        
}

public static function isManagerUser() {
        return Yii::$app->user->identity->user_level==self::HOU ? 1: 0; 
}



public  function findPosition() {
       
  return ErpPersonsInPosition::find()->where(["person_id"=>$this->user_id,"status"=>1] )->orderBy(['id' => SORT_DESC])->one()->position;     
       
}

public  function findOrgUnit() {
       
  return ErpPersonsInPosition::find()->where(["person_id"=>$this->user_id,"status"=>1] )->orderBy(['id' => SORT_DESC])->one()->orgUnit;
  
       
}

 public function getWorkDetails()
{
    return $this->hasOne(ErpPersonsInPosition::className(), ['person_id' => 'user_id'])->orderBy(['timestamp' => SORT_DESC])->one();
}


  public function getSignature()
{
    return $this->hasOne(Signature::className(), ['user' => 'user_id'])->orderBy(['timestamp' => SORT_DESC])->one();
}
  public function getRole()
{
    return $this->hasOne(UserRoles::className(), ['role_id' => 'user_level'])->one();
}
public  function findInterim() {
  $todate = date('Y-m-d');
  $todate=date('Y-m-d', strtotime($todate));     
  return ErpPersonInterim::find()->where(["person_interim_for"=>$this->user_id] )->andFilterWhere(['>=', 'date_to', $todate])->andFilterWhere(['<=', 'date_from', $todate])->One();
       
}

}
