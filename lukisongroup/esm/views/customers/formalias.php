<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\label\LabelInPlace;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Province */
/* @var $form yii\widgets\ActiveForm */

   $config = ['template'=>"{input}\n{error}\n{hint}"];  
                                                               
?>

<div class="province-form">

    <?php $form = ActiveForm::begin([
	'id'=>'updatealias',
	'enableClientValidation'=>true
	
	]); ?>

	<?= $form->field($model, 'CUST_KD_ALIAS', $config)->widget(LabelInPlace::classname());?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
