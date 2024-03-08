<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property int $role_id
 * @property string $role_name
 */
class RolesAccessList extends Model
{
   
  public $role;
  public $access_mode;
  public $id;
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role','access_mode'], 'required'],
            [['role','access_mode','id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role' => 'Role',
            'access_mode' => 'Access Mode',
        ];
    }
}
