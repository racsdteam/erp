<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tblgroupmembers".
 *
 * @property int $groupID
 * @property int $userID
 * @property int $manager
 *
 * @property Tblgroups $group
 * @property Tblusers $user
 */
class Tblgroupmembers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblgroupmembers';
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
            [['groupID', 'userID'], 'required'],
            [['groupID', 'userID', 'manager','created_by'], 'integer'],
            [['groupID', 'userID'], 'unique', 'targetAttribute' => ['groupID', 'userID']],
            [['groupID'], 'exist', 'skipOnError' => true, 'targetClass' => Tblgroups::className(), 'targetAttribute' => ['groupID' => 'id']],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'groupID' => 'Group ID',
            'userID' => 'User ID',
            'manager' => 'Manager',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Tblgroups::className(), ['id' => 'groupID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Tblusers::className(), ['id' => 'userID']);
    }
}
