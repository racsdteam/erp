<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property int $role_id
 * @property string $role_name
 */
class GroupsAccessList extends Model
{
   
  public $group;
  public $access_mode;
  public $target;
  
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group','access_mode','target'], 'required'],
            [['group','access_mode','target'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group' => 'Security Group',
            'access_mode' => 'Access Mode',
        ];
    }
}
