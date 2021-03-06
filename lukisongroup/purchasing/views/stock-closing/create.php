<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\stck\StockClosing */

$this->title = Yii::t('app', 'Create Stock Closing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stock Closings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-closing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
