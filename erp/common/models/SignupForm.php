<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Login form
 */
class SignupForm extends Model
{
    public $username;
    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $subdivision;
    public $position;
    public $password;
    public $confirm;
    public $terms = true;
    public $user_role;
  

    private $_user;
    public $tokenhid;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username','first_name','last_name','phone', 'password','confirm','email','position','subdivision'], 'required'],
            ['password', 'string', 'min' => 6],
           [['user_role'],'integer'],
            
            ['username', 'trim'],
            ['username', 'unique','targetClass'=> '\common\models\User', 'message' => 'username already Exists.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            
            ['tokenhid','string'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'unique','targetClass'=> '\common\models\User', 'message' => 'This email address has already been taken.'],
          
            // terms of usage must be a boolean value
            ['terms', 'boolean'],
            ['confirm', 'compare','compareAttribute'=>'password','operator'=>'==','message'=>'Passwords Entered do not match'],
     
            
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
        ];
    }

    

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
 
        if (!$this->validate()) {
            return null;
        }
 
        $user = new User();
        $user->username =$this->username;
        $user->first_name =$this->first_name;
        $user->last_name =$this->last_name;
        $user->phone =$this->phone;
        $user->email =$this->email;
        //$user->user_level=1;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->created_at = new Expression('NOW()');
        $user->updated_at = new Expression('NOW()');
        return $user->save() ? $user : null;
    }
}
