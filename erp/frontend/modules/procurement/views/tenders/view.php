<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tender Stages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php

if (Yii::$app->session->hasFlash('success')) {

  Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
}


if (Yii::$app->session->hasFlash('error')) {

  Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
}
?>


<div class="tender-stages-view">
  <div class="d-flex  flex-sm-row flex-column  justify-content-between">
    <ul class="nav nav-tabs" id="custom-content-above-tab1" role="tablist">
      <li class="nav-item">
        <a class="nav-link show active" id="custom-content-above-basic-info-tab" data-toggle="pill" href="#custom-content-above-basic-info" role="tab" aria-controls="custom-content-above-basic-info" aria-selected="true">
          <strong>Tender Basic Information</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link show" id="custom-content-above-lots-info-tab" data-toggle="pill" href="#custom-content-above-lots-info" role="tab" aria-controls="custom-content-above-lots-info" aria-selected="true">
          <strong>Tender Lots Information</strong>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link show" id="custom-content-above-stages-info-tab" data-toggle="pill" href="#custom-content-above-stages-info" role="tab" aria-controls="custom-content-above-stages-info" aria-selected="true">
          <strong>Tender Stages Information</strong>
        </a>
      </li>
    </ul>
    <?php
    $tender_stage_sequencies = $model->getStageInstances();
    if ($tender_stage_sequencies != null) :
    ?>
      <div class="float-right">
        <p>
          <?= Html::a('<i class="fas fa-file"></i> Preview & Submit Tender', ['tenders/submition-view', 'id' => (string) $model->_id], ['class' => 'btn btn-outline-danger btn-lg ', 'title' => 'Submit Tender']) ?>
        </p>
      </div>
    <?php endif ?>
  </div>
  <div class="tab-content" id="custom-content-above-tabContent">
    <div class="tab-pane fade  active show " id="custom-content-above-basic-info" role="tabpanel" aria-labelledby="custom-content-above-basic-info-tab">

      <!---

Start for Tender information information
      -->
      <div class="row clearfix">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

          <div class="card card-default text-dark">

            <div class="card-header ">
              <h3 class="card-title"><i class="fas fa-database"></i> <?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">
              <div class="float-right">
                <p>
                  <?= Html::a('Update', ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
                  <?= Html::a('Delete', ['delete', 'id' => (string)  $model->_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                      'confirm' => 'Are you sure you want to delete this Tender Staging?',
                      'method' => 'post',
                    ],
                  ]) ?>
                </p>
              </div>

              <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                  [
                    'label' => 'Created By',
                    'value' => call_user_func(function ($data) {
                      $_user = $data->User();

                      return $_user != null ? $_user->first_name . " " . $_user->last_name : '';
                    }, $model),


                  ],

                  'title',
                  'number',
                  'procurement_activity_id',
                  'created_at',
                  'updated_at',
                  'funding_source_code',
                  'currencies',
                  'number_lots',
                  'bid_security_amount',
                  'tender_document',
                  'alternative_bid_status',
                  'final_destination',
                  'manufactures_authorization_status',
                  'bid_validity_periode',
                  'tender_doc_charges_amount',
                  'tender_doc_charges_status',
                  [
                    'label' => 'Is The tender allowed  alternative bid?',
                    'value' => call_user_func(function ($data) {
                      if ($data)
                        return "Yes";
                      else
                        return "No";
                    }, $model->alternative_bid_status),


                  ],
                  [
                    'label' => 'DAO',
                    'format' => 'raw',
                    'value' => call_user_func(function ($data) {
                      if ($data)
                        return Html::a('<i class="fas fa-eye"></i> View document', Url::base() . "/" . $data, [
                          'class' => ['text-info'],
                          'title' => Yii::t('app', 'DAO'),
                          'target' => '_blank',
                        ]);
                      else
                        return "No";
                    }, $model->dao),


                  ],
                  [
                    'label' => 'RFQ',
                    'format' => 'raw',
                    'value' => call_user_func(function ($data) {
                      if ($data)
                        return Html::a('<i class="fas fa-eye"></i> View document', Url::base() . "/" . $data, [
                          'class' => ['text-info'],
                          'title' => Yii::t('app', 'RFQ'),
                          'target' => '_blank',
                        ]);
                      else
                        return "No";
                    }, $model->rfq),


                  ],
                  [
                    'label' => 'RFP',
                    'format' => 'raw',
                    'value' => call_user_func(function ($data) {
                      if ($data)
                        return Html::a('<i class="fas fa-eye"></i> View document', Url::base() . "/" . $data, [
                          'class' => ['text-info'],
                          'title' => Yii::t('app', 'RFP'),
                          'target' => '_blank',
                        ]);
                      else
                        return "No";
                    }, $model->rfp),


                  ],
                ],
              ]) ?>
            </div>
          </div>
        </div>
      </div>
      <!---

End for Tender basic information
      -->
    </div>
    <div class="tab-pane fade " id="custom-content-above-lots-info" role="tabpanel" aria-labelledby="custom-content-above-lots-info-tab">


      <!---

Start for Tender Lots information
      -->
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

          <div class="card card-default color-palette-card">

            <div class="card-header with-border">
              <h3 class="card-title"><i class="fa fa-file-o"></i>Tender Lots</h3>
            </div>
            <div class="card-body">
              <div class="callout callout-warning">
                <h5>Tender Lot Definition and Setup!</h5>

                <p>This Window Help on the tender Lot setup</p>
              </div>
              <?php if (count($model->getLots()) < $model->number_lots) : ?>
                <div class="d-flex  flex-sm-row flex-column  justify-content-between">
                  <p>
                    <?= Html::a('<i class="fas fa-plus"></i> Add Lot', ['tender-lots/create', 'tender_id' => (string) $model->_id], ['class' => 'btn btn-outline-primary btn-lg ', 'title' => 'Add Satge']) ?>
                  </p>

                </div>
              <?php endif; ?>

              <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <?php

                $lots = $model->getLots();
                ?>
                <?php foreach ($lots as $lot) : ?>


                  <li class="nav-item">
                    <a class="nav-link <?php echo $lot->number == 1 ? 'active show' : ''  ?>" id="custom-content-above-<?php echo $lot->number ?>-tab" data-toggle="pill" href="#custom-content-above-<?php echo $lot->number ?>" role="tab" aria-controls="custom-content-above-<?php echo $lot->number ?>" aria-selected="true">
                      <strong> Lot <?php echo $lot->number ?></strong>
                    </a>
                  </li>

                <?php endforeach; ?>


              </ul>


              <div class="tab-content" id="custom-content-above-tabContent">

                <?php foreach ($lots as $lot) : ?>

                  <div class="tab-pane fade  <?php echo $lot->number == 1 ? 'active show' : ''  ?> " id="custom-content-above-<?php echo $lot->number ?>" role="tabpanel" aria-labelledby="custom-content-above-<?php echo $lot->number ?>-tab">
                    <h2><?php echo $lot->title ?></h2>
                    <?= $lot->description ?>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                      <div class="card card-default text-dark">

                        <div class="card-header ">
                          <h3 class="card-title"><i class="fas fa-suitcase"></i>Items or Services to be purchased</h3>
                        </div>

                        <div class="card-body">
                          <div class="d-flex  flex-sm-row flex-column  justify-content-end mt-3 mb-3">
                            <?= Html::a('<i class="fas fa-user-plus"></i> Add item or service on lot ' . $lot->number, ['tender-items/create', 'lot_id' => (string)$lot->_id, 'tender_id' => (string)$model->_id], ['class' => 'btn btn-outline-primary btn-md mr-2 ', 'title' => 'Create puchase list']) ?>
                          </div>
                          <?php
                          $dataProviderItems = new  \yii\data\ActiveDataProvider([
                            'models' => $items = $lot->getItems(),
                            'pagination' => false

                          ]);
                          ?>
                          <?= GridView::widget([
                            'dataProvider' => $dataProviderItems,
                            'columns' => [
                              [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                                'template' => '{update}{delete}',

                                'buttons'        => [

                                  'update' => function ($url, $model_sequency, $key) use ($model) {
                                    return Html::a('<i class="fas fa-pencil-alt"></i>', ["/procurement/tender-items/update", 'id' => (string) $model_sequency->_id, 'tender_id' => (string) $model->_id], [
                                      'class' => ['text-success action-create'],
                                      'title' => Yii::t('app', 'Update')
                                    ]);
                                  },

                                  'delete' => function ($url, $model_sequency, $key) use ($model) {

                                    return Html::a('<i class="fas fa-times"></i>', ["/procurement/tender-items/delete", 'id' => (string) $model_sequency->_id, 'tender_id' => (string) $model->_id], [
                                      'class' => ['text-danger'],
                                      'title' => Yii::t('app', 'Delete'),
                                      'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Lot ?'),
                                      'data-method'  => 'post',
                                      'data-pjax'    => '0',
                                    ]);
                                  }


                                ] //-------end

                              ],

                              [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions' => ['style' => ' white-space:nowrap;']
                              ],
                              'name',
                              [
                                'attribute' => 'description',
                                'format' => 'html', // Set the format to HTML
                                'value' => function ($model) {
                                  return Html::tag('div', $model->description, ['class' => 'custom-class']);
                                  // Assuming $model->description contains the HTML content you want to display
                                },
                              ],
                              'type',
                              'unite',
                              'quantity',

                            ],
                          ]); ?>
                        </div>
                      </div>
                    </div>
                    <?php
                    $envelopes = $lot->getEnvelopes();

                    ?>

                    <?php foreach ($envelopes as $envelope) : ?>

                      <h3>Lot Envelope: <?= $envelope->name  ?></h3>
                      <?php $sections = $envelope->sections; ?>

                      <?php foreach ($sections as $section) : ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                          <div class="card card-default text-dark">

                            <div class="card-header ">
                              <h3 class="card-title"><i class="fas fa-suitcase"></i> <?= $section->name ?></h3>
                            </div>

                            <div class="card-body">
                              <?php
                              if ($section->is_staffing) :
                              ?>

                                <div class="d-flex  flex-sm-row flex-column  justify-content-end mt-3 mb-3">
                                  <?= Html::a('<i class="fas fa-user-plus"></i> Add Staff lot 1' . $lot->number, ['tender-staffs/create', 'lot_id' => (string)$lot->_id, 'tender_id' => (string)$model->_id, 'section_code' => $section->code], ['class' => 'btn btn-outline-primary btn-md mr-2 ', 'title' => ' Add Staffs']) ?>
                                </div>

                                <?php
                                $dataProviderDocuments = new  \yii\data\ActiveDataProvider([
                                  'models' => $items = $lot->getStaffs($section->code),
                                  'pagination' => false

                                ]);
                                ?>
                                <?= GridView::widget([
                                  'dataProvider' => $dataProviderDocuments,
                                  'columns' => [
                                    [
                                      'class' => 'yii\grid\ActionColumn',
                                      'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                                      'template' => '{update}{delete}',

                                      'buttons'        => [

                                        'update' => function ($url, $model_sequency, $key) use ($model) {
                                          return Html::a('<i class="fas fa-pencil-alt"></i>', ["/procurement/tender-staffs/update", 'id' => (string) $model_sequency->_id, 'tender_id' => (string) $model->_id, 'section_code' => $model_sequency->section_code], [
                                            'class' => ['text-success action-create'],
                                            'title' => Yii::t('app', 'Update')
                                          ]);
                                        },

                                        'delete' => function ($url, $model_sequency, $key) use ($model) {

                                          return Html::a('<i class="fas fa-times"></i>', ["/procurement/tender-staffs/delete", 'id' => (string) $model_sequency->_id, 'tender_id' => (string) $model->_id, 'section_code' => $model_sequency->section_code], [
                                            'class' => ['text-danger'],
                                            'title' => Yii::t('app', 'Delete'),
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Lot ?'),
                                            'data-method'  => 'post',
                                            'data-pjax'    => '0',
                                          ]);
                                        }


                                      ] //-------end

                                    ],

                                    [
                                      'class' => 'yii\grid\SerialColumn',
                                      'contentOptions' => ['style' => ' white-space:nowrap;']
                                    ],
                                    'position',
                                    'description',
                                    'documents',

                                  ],
                                ]); ?>
                              <?php else : ?>


                                <div class="d-flex  flex-sm-row flex-column  justify-content-end mt-3 mb-3">
                                  <?= Html::a('<i class="fas fa-user-plus"></i> Add Document lot ' . $lot->number, ['tender-documents/create', 'lot_id' => (string)$lot->_id, 'tender_id' => (string)$model->_id, 'section_code' => $section->code], ['class' => 'btn btn-outline-primary btn-md mr-2 ', 'title' => 'Add Document lot']) ?>
                                </div>

                                <?php
                                $dataProviderDocuments = new  \yii\data\ActiveDataProvider([
                                  'models' => $items = $lot->getDocuments($section->code),
                                  'pagination' => false

                                ]);
                                ?>
                                <?= GridView::widget([
                                  'dataProvider' => $dataProviderDocuments,
                                  'columns' => [
                                    [
                                      'class' => 'yii\grid\ActionColumn',
                                      'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                                      'template' => '{update}{delete}',

                                      'buttons'        => [

                                        'update' => function ($url, $model_sequency, $key) use ($model) {
                                          return Html::a('<i class="fas fa-pencil-alt"></i>', ["/procurement/tender-documents/update", 'id' => (string) $model_sequency->_id, 'tender_id' => (string) $model->_id, 'section_code' => $model_sequency->section_code], [
                                            'class' => ['text-success action-create'],
                                            'title' => Yii::t('app', 'Update')
                                          ]);
                                        },

                                        'delete' => function ($url, $model_sequency, $key) use ($model) {

                                          return Html::a('<i class="fas fa-times"></i>', ["/procurement/tender-documents/delete", 'id' => (string) $model_sequency->_id, 'tender_id' => (string) $model->_id, 'section_code' => $model_sequency->section_code], [
                                            'class' => ['text-danger'],
                                            'title' => Yii::t('app', 'Delete'),
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Lot ?'),
                                            'data-method'  => 'post',
                                            'data-pjax'    => '0',
                                          ]);
                                        }


                                      ] //-------end

                                    ],

                                    [
                                      'class' => 'yii\grid\SerialColumn',
                                      'contentOptions' => ['style' => ' white-space:nowrap;']
                                    ],
                                    'document_code',
                                    'number',

                                  ],
                                ]); ?>
                              <?php
                              endif;
                              ?>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>

                      <strong>End Envelope</strong>
                    <?php endforeach; ?>
                  </div>
                <?php endforeach; ?>


              </div>
            </div>
          </div>
        </div>
      </div>


      <!---

End for Tender Lots information
      -->
    </div>
    <div class="tab-pane fade " id="custom-content-above-stages-info" role="tabpanel" aria-labelledby="custom-content-above-stages-info-tab">

      <!---

Start for Tender Stages information
      -->

      <h2>Here stages</h2>

      <div class="row clearfix">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

          <div class="card card-default text-dark">

            <div class="card-header ">
              <h3 class="card-title"><i class="fas fa-database"></i><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">
              <div class="callout callout-warning">
                <h5>Tender Stages Definition and Setup!</h5>

                <p>This Window Help on the tender satges setup</p>
              </div>
              <?php
              $stage_sequencies = $model->getStages()->stageSequencies;
              $tender_stage_sequencies = $model->getStageInstances();
              if ($tender_stage_sequencies == null) :
                if (!empty($stage_sequencies)) :

                  // Function to sort the array by the 'age' key
                  function sortBySequenceNumber($a, $b)
                  {
                    return $a['sequence_number'] - $b['sequence_number'];
                  }

                  // Sort the array using the sortByAge function
                  usort($stage_sequencies, 'sortBySequenceNumber');
              ?>
                  <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data', 'data-toggle' => 'validator'],
                    'id' => 'dynamic-form',
                    'action' => ['tender-stage-instances/create-from-tender', 'tender_id' => (string)$model->_id],
                    'enableClientValidation' => true,
                    'enableAjaxValidation' => false,
                    'method' => 'post',
                  ]); ?>



                  <div class="table-responsive">
                    <table id="items" style="width:100%" class="table table-bordered table-striped">
                      <thead>
                        <tr>

                          <th style="color:#2196f3;font-weight:bold;" colspan="4">

                            <h4 style="display:inline;" class="card-title"><i class="fa fa-cart-arrow-down"></i>Segments Report</h4>

                          </th>
                        </tr>
                        <tr>

                          <th class="text-center" style="width:20%;">Stage Name</th>
                          <th>Sequence Order</th>
                          <th>Start Date</th>
                          <th>End Date</th>

                        </tr>
                      </thead>
                      <tbody class="container-items2">
                        <?php foreach ($stage_sequencies as $i => $stage_sequencie) : ?>
                          <tr class="item">
                            <td class="text-center" style="width:20%;">
                              <b><?= $stage_sequencie->stageSetting->name ?></b>
                              <?= $form->field($tenderStageIntstances, "[{$i}]tender_id")->hiddenInput(['value' => $model->_id])->label(false); ?>
                              <?= $form->field($tenderStageIntstances, "[{$i}]stage_name")->hiddenInput(['value' => $stage_sequencie->stageSetting->name])->label(false); ?>
                              <?= $form->field($tenderStageIntstances, "[{$i}]stage_code")->hiddenInput(['value' => $stage_sequencie->stageSetting->code])->label(false); ?>
                              <?= $form->field($tenderStageIntstances, "[{$i}]sequence_number")->hiddenInput(['value' => $stage_sequencie->sequence_number])->label(false); ?>
                            </td>

                            <td>

                              <?=
                              $stage_sequencie->sequence_number
                              ?>
                            </td>
                            <td>

                              <?=
                              $form->field($tenderStageIntstances, "[{$i}]start_date", ['template' => '
                 {label} 
               <div class="input-group col-sm-12">
                <div class="input-group-prepend">
                       
                        <span class="input-group-text">
                            <i class="fas fa-calendar"></i>
                        </span>
                        
                        </div>
             
                 {input}
                 
                   
               </div>{error}{hint}
       '])->textInput(['maxlength' => false, 'class' => ['form-control date'], 'placeholder' => 'Start date...'])->label(false) ?>
                            </td>
                            <td>
                              <?=
                              $form->field($tenderStageIntstances, "[{$i}]end_date", ['template' => '
                     {label} 
                   <div class="input-group col-sm-12">
                    <div class="input-group-prepend">
                           
                            <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </span>
                            
                            </div>
                 
                     {input}
                     
                       
                   </div>{error}{hint}
           '])->textInput(['maxlength' => false, 'class' => ['form-control date'], 'placeholder' => 'End date...'])->label(false) ?>
                            </td>


                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>


                  <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                  </div>

                  <?php ActiveForm::end(); ?>
                <?php endif; ?>
              <?php else : ?>
                <?php
                $dataProviderStages = new  \yii\data\ActiveDataProvider([
                  'models' => $items = $tender_stage_sequencies,
                  'pagination' => false

                ]);
                ?>
                <?= GridView::widget([
                  'dataProvider' => $dataProviderStages,
                  'columns' => [
                    [
                      'class' => 'yii\grid\ActionColumn',
                      'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                      'template' => '{update}',

                      'buttons'        => [

                        'update' => function ($url, $model_sequency, $key) use ($model) {
                          return Html::a('<i class="fas fa-pencil-alt"></i>', ["/procurement/tender-items/update", 'id' => (string) $model_sequency->_id, 'tender_id' => (string) $model->_id], [
                            'class' => ['text-success action-create'],
                            'title' => Yii::t('app', 'Update')
                          ]);
                        },
                      ] //-------end

                    ],

                    [
                      'class' => 'yii\grid\SerialColumn',
                      'contentOptions' => ['style' => ' white-space:nowrap;']
                    ],
                    'stage_name',
                    'stage_code',
                    'sequence_number',
                    'start_date',
                    'end_date',
                    'status',

                  ],
                ]); ?>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

$script = <<< JS
$(document).ready(function(){
	$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true,
				 format: 'DD/MM/YYYY',
         minDate : new Date(),
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm',
			}); 
    });
JS;
$this->registerJs($script);
?>