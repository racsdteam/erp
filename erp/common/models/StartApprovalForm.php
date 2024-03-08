<?php
    namespace common\models;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\base\Model;
    use common\models\User;
     
    /**
     * Change password form for current user only
     */
    class StartApprovalForm extends Model
    {
        public $wfModel;
        public $entityRecord;
        public $entityType;
        public $initiator;
        public $comment;
     
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
               
                [['wfModel','entityRecord','initiator'], 'integer'],
                [['entityType','comment'], 'string'],
               
            ];
        }
       public function attributeLabels()
    {
        return [
            'wfModel' => 'Workflow Model',
             'entityRecord' => 'Entity Record',
           
            
        ];
    }
        
    }