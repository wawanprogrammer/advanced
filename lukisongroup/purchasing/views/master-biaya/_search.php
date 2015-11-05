<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterTunjanganpotongansearch */
/* @var $form yii\widgets\ActiveForm */
if(Yii::$app->controller->action->id === 'biayatunjangan')
{
$act='./index.php?r=master/master-biaya/biayatunjangan';
} 
else {
 $act='./index.php?r=master/master-biaya/biayapotongan';   
}
?>
    <?php 
      $form = ActiveForm::begin(
        ['action'=>$act,
        'method' => 'post',
        'options' => ['data-pjax'=>true],
    ]); 
    if(isset($_post['typeSearch']))
        {
            $type = $_post['typeSearch'];
        } else {
            $type = NULL;
        }

        if(isset($_post['textsearch']))
        {
            $text = $_post['textsearch'];
        } else {
            $text = NULL;
        }
        
         echo Html::dropDownList('typeSearch',$type,
                        ['1'=>'BiayaID', '2'=>'Description'],
                        ['prompt'=>'ALL','class'=>'form-control', 'id'=> 'searchdrop']) ;
        echo Html::textInput('textsearch',$text,['class' => 'form-control','id' => 'searchbox']);

            echo Html::submitButton('Search', ['class' => 'btn btn-primary','id' => 'searchbtn']);
//            echo Html::resetButton('Reset', ['class' => 'btn btn-default']) 
            
            ActiveForm::end(); 
?>

</div>