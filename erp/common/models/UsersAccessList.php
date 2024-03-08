<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property int $role_id
 * @property string $role_name
 */
class UsersAccessList extends Model
{
   
  public $user;
  public $access_mode;
  public $target;
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['user','access_mode','target'], 'required'],
            [['user','access_mode','target'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user' => 'User',
            'access_mode' => 'Access Mode',
        ];
    }
}
