<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termgeneral */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="termgeneral-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SUBJECT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ISI_TERM')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>