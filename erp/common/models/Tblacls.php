<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tblacls".
 *
 * @property int $id
 * @property int $target
 * @property int $targetType
 * @property int $userID
 * @property int $groupID
 * @property int $mode
 */
class Tblacls extends \yii\db\ActiveRecord
{
  

    const M_NONE = 1;
    const M_READ =2;
    const M_READWRITE =3;
    const M_ALL = 4;
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblacls';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['target', 'targetType', 'userID', 'groupID','roleID', 'mode'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'target' => 'Target',
            'targetType' => 'Target Type',
            'userID' => 'User ID',
            'groupID' => 'Group ID',
            'roleID' => 'Role ID',
            'mode' => 'Mode',
        ];
    }
}
