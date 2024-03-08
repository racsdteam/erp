<?php

namespace frontend\modules\hr\models;


use Yii;
use yii\base\Model;

/**
 * This is the model class for table "approval_step_approvers".
 *
 * @property int $id
 * @property string $type
 * @property int $approver
 */
class ApprovalStepApprovers extends Model
{
   


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'value'], 'required'],
            [['type'], 'string'],
            [['value'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           
            'type' => 'Type',
            'value' => 'Value',
        ];
    }
}
