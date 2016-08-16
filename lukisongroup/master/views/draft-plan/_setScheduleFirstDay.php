<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlan */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Draft Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-plan-view">


<?php
   /*info*/
    $cusviewinfo=DetailView::widget([
        'model' => $view_info,
        'attributes' => [
            [
                'attribute' =>'CUST_NM',
                'label'=>'Customer.NM',
                'labelColOptions' => ['style' => 'text-align:right;width: 30%']
            ],
            [
                'attribute' =>'SCDL_GROUP',
                'value'=>$view_info->custgrp->SCDL_GROUP_NM, 
                'label'=>'Schedule Group',
                'labelColOptions' => ['style' => 'text-align:right;width: 30%']
            ],
            
        ],
    ]); 

    $layer_viewinfo=DetailView::widget([
        'model' => $view_info,
        'attributes' => [
            [
                'attribute' =>'CUST_NM',
                'label'=>'Customer.NM',
                'labelColOptions' => ['style' => 'text-align:right;width: 30%']
            ],
            [
                'attribute' =>'LAYER',
                'value'=>$view_info->custlayer->LAYER, 
                'label'=>'Layer',
                'labelColOptions' => ['style' => 'text-align:right;width: 30%']
            ],
            
        ],
    ]); 

    ?>
    <div class="row">
        <div class="col-sm-6">
        <?= $cusviewinfo ?>
        </div>
          <div class="col-sm-6">
          <?= $layer_viewinfo ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            
			<?php $form = ActiveForm::begin(['id'=>$model->formName(),
					'enableClientValidation' => true,
  					'enableAjaxValidation'=>true,
  					 'validationUrl'=>Url::toRoute('/master/draft-plan/valid')
			]); ?>
			<?=$form->field($model, 'displyGeoId')->hiddenInput(['value'=>$model->GEO_ID,'id'=>'draftplan-displygeoid'])->label(false); ?>
			
				<?=$form->field($model, 'CUST_KD')->hiddenInput(['value'=>$model->CUST_KD])->label(false); ?>

				<?=$form->field($model, 'YEAR')->hiddenInput(['value'=>$model->YEAR])->label(false); ?>
			<div class="row">
				<div class="col-sm-6">	
						<?=$form->field($model, 'displyGeoNm')->textInput(['value' => $model->geoNm .' - '. $model->GeoDcrip,'readonly' => true])->label('CUSTOMER GROUP'); ?>
				</div>
				<div class="col-sm-6">
					<?= $form->field($model, 'GEO_SUB')->widget(DepDrop::classname(), [
						'type'=>DepDrop::TYPE_SELECT2,
						'options'=>['placeholder'=>'Select ...'],
						'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						'pluginOptions'=>[
							'depends'=>['draftplan-displygeoid'],
							 'initialize' => true,
							  'loadingText' => 'Loading  ...',
							'url' => Url::to(['/master/draft-plan/lis-geo-sub']),
						]
					])->label('AREA GROUP') 
					?>
				</div>
			</div>		
			
			<?= $form->field($model_day, 'OPT')->widget(Select2::classname(), [
					'data' => $opt,
					'options' => ['placeholder' => 'Pilih ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('Options Jeda Pekan');

			?>


			<?= $form->field($model, 'DAY_ID')->widget(DepDrop::classname(), [
					'type'=>DepDrop::TYPE_SELECT2,
					'options'=>['placeholder'=>'Select ...'],
					'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
					'pluginOptions'=>[
						'depends'=>['dayname-opt'],
						 'initialize' => true,
						  'loadingText' => 'Loading  ...',
						'url' => Url::to(['/master/draft-plan/lisday']),
					]
				])->label('Setel Hari') 
			?>

		   <!--   $form->field($model, 'DAY_ID')->widget(Select2::classname(), [
					// 'data' => $opt,
					'options' => ['placeholder' => 'Pilih ...'],
					'pluginOptions' => [
						'allowClear' => true,

						 ],
				]);?> -->
		

			<div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

			 <?= Html::button(Yii::t('app', 'Delete'),
						[
						'id'=>'modalButton',
						'class'=>"btn btn-danger btn",      
					  ]); ?>

			
			</div>

			<?php ActiveForm::end(); ?>
		</div>

    </div>

</div>


<?php
 $this->registerJs("
$('#modalButton').on('click',function(e){
e.preventDefault();
var nilaiaja = localStorage.getItem('nilaix');

var idx = '{$model->CUST_KD}';

var ID = '{$model->ID}';
localStorage.setItem('nilaix','/master/draft-plan/set-scdl-fday?id='+ID+'');

   $.ajax({   
        url: '/master/draft-plan/delete-schedule',
        dataType: 'json',
        type: 'GET',
        data:{id:idx},
        success: function (data, textStatus, jqXHR) {
        		if(textStatus == 'success')
        		{
        			$(document).find('#modal-day-draft').modal('hide');
        			$.pjax.reload({container:'#gv-maintain-id'});
        			 setTimeout(function(){
				      $('#modal-day-draft').modal('toggle')
				      .find('.modal-body')
				      .load(nilaiaja);
				    }, 2000); 
        		}
                
        },
    });

   
				
    
  
})

",$this::POS_READY);

 


/** *js getting table values using ajax
    *@author adityia@lukison.com

**/
// $this->registerJs("
// $('#dayname-opt').on('change',function(e){
// e.preventDefault();
// var idx = $(this).val();
//    $.ajax({   
//         url: '/master/draft-plan/lisday',
//         dataType: 'json',
//         type: 'GET',
//         data:{opt:idx},
//         success: function (data, textStatus, jqXHR) {            $('#draftplan-day_id').html(data);
//         },
//     });
  
// })
// // bootstrap-duallistbox-nonselected-list_Customers[CUST_GRP][]
// ",$this::POS_READY);
