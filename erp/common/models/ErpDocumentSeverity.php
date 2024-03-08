<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document_severity".
 *
 * @property int $id
 * @property string $severity
 */
class ErpDocumentSeverity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document_severity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['severity'], 'required'],
            [['severity'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'severity' => 'Severity',
        ];
    }
}
