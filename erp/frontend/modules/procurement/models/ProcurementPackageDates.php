<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "procurement_package_dates".
 *
 * @property int $id
 * @property int $package
 * @property string $end_user_requirements_submission
 * @property string $tender_preparation
 * @property string $tender_publication
 * @property string $bids_opening
 * @property string $award_notification
 * @property string $contract_signing
 * @property string $contract_start
 * @property string $supervising_firm
 * @property string $created
 * @property string $updated
 * @property int $user
 */
class ProcurementPackageDates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_package_dates';
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
            [['package', 'end_user_requirements_submission', 'tender_preparation', 'tender_publication', 'bids_opening', 'award_notification', 'contract_signing', 'contract_start', 'user'], 'required'],
            [['package', 'user'], 'integer'],
            [['end_user_requirements_submission', 'tender_preparation', 'tender_publication', 'bids_opening', 'award_notification', 'contract_signing', 'contract_start', 'supervising_firm', 'created', 'updated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package' => 'Package',
            'end_user_requirements_submission' => 'End User Requirements Submission',
            'tender_preparation' => 'Tender Preparation',
            'tender_publication' => 'Tender Publication',
            'bids_opening' => 'Bids Opening',
            'award_notification' => 'Award Notification',
            'contract_signing' => 'Contract Signing',
            'contract_start' => 'Contract Start',
            'supervising_firm' => 'Supervising Firm',
            'created' => 'Created',
            'updated' => 'Updated',
            'user' => 'User',
        ];
    }
}
