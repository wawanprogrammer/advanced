
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use lukisongroup\master\models\Customers;
use lukisongroup\hrd\models\Corp;
use lukisongroup\master\models\Distributor;


$data = Customers::find()->where('CUST_KD = CUST_GRP')->all();
$to = "CUST_KD";
$from = "CUST_NM";

$data1 = Corp::find()->all();
$to1 = "CORP_ID";
$from1 = "CORP_NM";

$data2 = Distributor::find()->all();
$to2 = 'KD_DISTRIBUTOR';
$from2 = "NM_DISTRIBUTOR";

?>

<?php
$form = ActiveForm::begin([
  'id'=>$model->formName(),
]);
 ?>

<?= $form->field($model, 'CUST_KD')->widget(Select2::classname(),[
  'options'=>[  'placeholder' => 'Select Customers parent ...'
  ],
  'data' =>$model->data($data,$to,$from)
]);?>


<?= $form->field($model, 'PRINCIPAL_KD')->widget(Select2::classname(),[
  'options'=>[  'placeholder' => 'Select Nama Principal ...'
  ],
  'data' =>$model->data($data1,$to1,$from1)
]);?>

<?= $form->field($model, 'DIST_KD')->widget(Select2::classname(),[
  'options'=>[  'placeholder' => 'Select Nama Distributor ...'
  ],
  'data' =>$model->data($data2,$to2,$from2)
]);?>


<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
