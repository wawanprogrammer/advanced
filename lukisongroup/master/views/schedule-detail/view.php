<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Scheduledetail */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Scheduledetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduledetail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'TGL',
            'CUST_ID',
            'USER_ID',
            'SCDL_GROUP',
            'LAT',
            'LAG',
            'RADIUS',
            'NOTE:ntext',
            'STATUS',
            'CREATE_BY',
            'CREATE_AT',
            'UPDATE_BY',
            'UPDATE_AT',
        ],
    ]) ?>

</div>
