<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Province;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Kota */
/* @var $form yii\widgets\ActiveForm */

 $prov = ArrayHelper::map(Province::find() ->all(),'PROVINCE_ID', 'PROVINCE');
?>

<div class="kota-form">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'enableClientValidation' => true
    ]); ?>

     <!-- $form->field($model, 'CITY_ID')->textInput() ?> -->

    <?= $form->field($model, 'PROVINCE_ID')->widget(Select2::classname(), [
        'data' => $prov,
        'options' => [
         // 'id'=>"slect",
        'placeholder' => 'Pilih Province..'],
        'pluginOptions' => [
            'allowClear' => true,
             ],


    ]);?>

    <?= $form->field($model, 'PROVINCE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TYPE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CITY_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POSTAL_CODE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("

   $('form#{$model->formName()}').on('beforeSubmit',function(e)
    {
        var \$form = $(this);
        $.post(
            \$form.attr('action'),
            \$form.serialize()

        )

            .done(function(result){
			        if(result == 1 )
                                          {

                                             $(document).find('#form2').modal('hide');
                                             $('form#{$model->formName()}').trigger('reset');
                                             $.pjax.reload({container:'#gv-kota'});
                                          }
                                        else{
                                           console.log(result)
                                        }

            });

return false;


});


 ",$this::POS_END);
