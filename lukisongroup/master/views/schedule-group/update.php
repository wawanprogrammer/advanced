<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Schedulegroup */

$this->title = 'Update Schedulegroup: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Schedulegroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="schedulegroup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>