<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Regulasi */

$this->title = 'Update Regulasi: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Regulasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="regulasi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
