<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\master\models\MasterBanksearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Bank';
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);
?>

<div class="master-bank-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?php Pjax::begin(['id'=>'PtlCommentsPjax']); 
    echo $this->render('_search', ['model' => $searchModel]);

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'BankID',
            'BankName',
            'BankGroupName',
            
//            'isActive',
//            'usercrt',
            // 'datecrt',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

 <?php Pjax::end(); ?> 
     <p style="float:right;">
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
        
        <?php
        
        if(!isset($_GET['typeSearch']) == NULL && !isset($_GET['textsearch']) == NULL)
        {
            echo Html::a('Back', ['index'], ['class' => 'btn btn-primary']);
        }
        
        ?>
    </p>

</div>
