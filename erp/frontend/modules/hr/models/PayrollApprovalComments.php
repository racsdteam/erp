<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "payroll_approval_comments".
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
class PayrollApprovalComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_approval_comments';
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

    /**
     * {@inheritdoc}
     * @return PayrollApprovalCommentsQuery the active query used by this AR class.
     */
        public function getAuthor()
{
    return $this->hasOne(User ::className(), ['user_id' => 'user']);
}

    public static function find()
    {
        return new PayrollApprovalCommentsQuery(get_called_class());
    }
}