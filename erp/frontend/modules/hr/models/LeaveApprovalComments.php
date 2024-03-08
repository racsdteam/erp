<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "leave_approval_flow_comments".
 *
 * @property int $id
 * @property int $user
 * @property int $request
 * @property string $comment
 * @property string $scope
 * @property int $wfStep
 * @property string $timestamp
 */
class LeaveApprovalComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_approval_comments';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'request', 'comment'], 'required'],
            [['user', 'request', 'wfStep'], 'integer'],
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
            'user' => 'User',
            'request' => 'Request',
            'comment' => 'Comment',
            'scope' => 'Scope',
            'wfStep' => 'wfStep',
            'timestamp' => 'Timestamp',
        ];
    }
    
    
   public function getAuthor()
{
    return $this->hasOne(User ::className(), ['user_id' => 'user']);
}

  public function getActionwfStep()
{
    return $this->hasOne(LeaveApprovalFlowwfSteps::className(), ['id' => 'wfStep']);
}

}
