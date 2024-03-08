<?php

namespace frontend\modules\racdms\models;

use Yii;

/**
 * This is the model class for table "tblorgusers".
 *
 * @property int $id
 * @property int $userID
 * @property int $orgID
 * @property int $posID
 * @property int $status
 * @property string $created
 * @property int $created_by
 */
class Tblorgusers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblorgusers';
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
            [['userID', 'orgID', 'posID', 'created_by'], 'required'],
            [['userID', 'orgID', 'posID', 'status', 'created_by'], 'integer'],
            [['created'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userID' => 'User ID',
            'orgID' => 'Org ID',
            'posID' => 'Pos ID',
            'status' => 'Status',
            'created' => 'Created',
            'created_by' => 'Created By',
        ];
    }
}
