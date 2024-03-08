<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property int $role_id
 * @property string $role_name
 */
class UserRoles extends \yii\db\ActiveRecord
{
   
   
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name'], 'required'],
            [['role_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'role_name' => 'Role Name',
        ];
    }
}
