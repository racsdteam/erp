<?php

namespace frontend\modules\procurement\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "procurement_plan_approval_comments".
 *
 * @property int $id
 * @property int $wfInstance
 * @property int $wfStep
 * @property int $request
 * @property string $comment
 * @property string $scope
 * @property int $user
 * @property string $timestamp
 */
class ProcurementPlanApprovalComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_plan_approval_comments';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db8');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wfInstance', 'request', 'comment', 'user'], 'required'],
            [['wfInstance', 'wfStep', 'request', 'user'], 'integer'],
            [['comment', 'scope'], 'string'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wfInstance' => 'Wf Instance',
            'wfStep' => 'Wf Step',
            'request' => 'Request',
            'comment' => 'Comment',
            'scope' => 'Scope',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
            public function getAuthor()
{
    return $this->hasOne(User ::className(), ['user_id' => 'user']);
}

    public static function find()
    {
        return new ProcurementPlanApprovalCommentsQuery(get_called_class());
    }
}
