<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
//use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
	
use lukisongroup\models\master\Kategori;
use lukisongroup\models\master\Unitbarang;
use lukisongroup\models\master\Suplier;
//use lukisongroup\models\master\Perusahaan;
use lukisongroup\models\master\Tipebarang;
use lukisongroup\models\hrd\Corp;
use kartik\widgets\DatePicker;

use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\master\Barangumum */
/* @var $form yii\widgets\ActiveForm */


// dropdown data

 $drop = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM'); 
 $droptipe = ArrayHelper::map(Tipebarang::find()->where(['STATUS' => 1])->all(), 'KD_TYPE', 'NM_TYPE');
 $dropkategori = ArrayHelper::map(Kategori::find()->where(['STATUS' => 1])->all(), 'KD_KATEGORI', 'NM_KATEGORI');
 $dropunit = ArrayHelper::map(Unitbarang::find()->where(['STATUS' => 1])->all(), 'KD_UNIT', 'NM_UNIT');
 $dropsuplier = ArrayHelper::map(Suplier::find()->where(['STATUS' => 1])->all(), 'KD_SUPPLIER', 'NM_SUPPLIER');
?>

         <div class="row">
            
             <div class="col-lg-3"></div>
             <div class="col-lg-9">

    <?php $form = ActiveForm::begin([
		'type' => ActiveForm::TYPE_HORIZONTAL,
                'id'=>'createumum',
                'enableClientValidation' => true,
		'method' => 'post',
		'action' => ['master/barangumum/simpan'],
		'options' => ['enctype' => 'multipart/form-data']
		]);
	?>

   
    <?= $form->field($model, 'KD_CORP')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --']) ?>
    
    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>

	 
    <?= $form->field($model, 'KD_TYPE')->dropDownList($droptipe,['prompt'=>' -- Pilih Salah Satu --'])->label('Type Barang') ?>

	
    <?= $form->field($model, 'KD_KATEGORI')->dropDownList($dropkategori,['prompt'=>' -- Pilih Salah Satu --'])->label('Kategori') ?>
                 
	 
       
    <?=$form->field($model, 'KD_UNIT')->widget(Select2::classname(), [
    'data' => $dropunit,
    'options' => ['placeholder' => 'pilih KD_unit ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

	
    <?= $form->field($model, 'KD_SUPPLIER')->dropDownList($dropsuplier,['prompt'=>' -- Pilih Salah Satu --'])->label('Supplier') ?>


    <?= $form->field($model, 'PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HPP')->textInput() ?>

    <?= $form->field($model, 'HARGA')->textInput() ?>
                 
               

    <?= $form->field($model, 'BARCODE')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'image')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
	]);
	?>
              
    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'KD_CAB')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_DEP')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>

    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Barang' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		
     

    
    
    <?php ActiveForm::end(); ?>
             </div>
