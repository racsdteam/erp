<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_document".
 *
 * @property int $id
 * @property string $doc_code
 * @property int $creator
 * @property string $status
 * @property int $type
 * @property string $serverity
 * @property string $created
 */
class ErpDocument extends \yii\db\ActiveRecord
{

public $recipients;
public $recipients_names;
public $doc_attach_file;
public $position;
public $position_cc;
public $employee;
public $employee_cc;
//==================================================

public $action;
public $remark;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_code','doc_title','doc_description', 'creator', 'status', 'type', 'severity','recipients','recipients_names','doc_source','position','employee'], 'required'],
            [['creator', 'type','is_new'], 'integer'],
            [['doc_code','severity','doc_title','doc_description','doc_source','doc_upload ','remark','action','status'], 'string'],
            [['created','recipients','recipients_names','position','position_cc','employee','employee_cc','expiration_date'], 'safe'],
            [[ 'status'], 'string', 'max' => 255],
            [['doc_attach_file'], 'file', 'extensions'=>'pdf,jpg','skipOnEmpty'=>false],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
           'doc_attach_file' => 'Attachement(s)',
            'creator' => 'Creator',
            'status' => 'Status',
            'doc_title'=>'Document Title',
            'doc_description'=>'Document Description',
            'type' => 'Type',
            'severity' => 'Severity',
            'created' => 'created',
            'doc_source'=>'Document origin',
            'recipients_names'=>'Recipients Names',
            'expiration_date'=>'Expiration Date (Set your Document to expire automatically if they are not approved)'
        ];
    }
}
