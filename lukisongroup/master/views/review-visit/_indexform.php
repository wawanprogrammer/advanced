<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;


?>

	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName(),
				//'enableClientValidation' => true,
				'method' => 'post',
				'action' => ['/master/review-visit/ambil-tanggal'],
		]);
	?>	
	<?= $form->field($model, 'tanggal')->widget(DatePicker::classname(), [
		'options' => ['placeholder' => 'Pilih  ...'],
		'pluginOptions' => [
		   'autoclose'=>true,
		   'format' => 'yyyy-mm-dd',
		],
		'pluginEvents'=>[
		       'show' => "function(e) {errror}",
		           ],

		])->label('Tanggal')  ?>
		
		<div style="text-align: right;"">
			<?php echo Html::submitButton('Submit',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	

	





