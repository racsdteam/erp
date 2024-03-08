<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tblgroups".
 *
 * @property int $id
 * @property string $name
 * @property string $comment
 *
 * @property Tblgroupmembers[] $tblgroupmembers
 * @property Tblusers[] $users
 */
class Tblgroups extends \yii\db\ActiveRecord
{
   
    public $group_members;
     
     const UNIT_GROUP=1;
     const CUSTOM_GROUP=2;
     const PUBLIC_GROUP=3;
   
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblgroups';
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
            [['comment','name','type'], 'required'],
            [['comment'], 'string'],
            [['type','created_by'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['group_members','created'], 'safe'],
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
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblgroupmembers()
    {
        return $this->hasMany(Tblgroupmembers::className(), ['groupID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_id' => 'userID'])->viaTable('tblgroupmembers', ['groupID' => 'id']);
    }
}
