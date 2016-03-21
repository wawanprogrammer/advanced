<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* TABLE CLASS DEVELOPE -> |DROPDOWN,PRIMARYKEY-> ATTRIBUTE */
use app\models\hrd\Dept;
/*	KARTIK WIDGET -> Penambahan componen dari yii2 dan nampak lebih cantik*/
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
use yii\helpers\Url;
//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'PT. Arta Lipat Ganda';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'alg_sales';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ALG - Sales Dashboard ');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                  /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
//use ho96\extplorer\Extplorer;
				
			?>


<div class="body-content">
    <div class="row" style="padding-left: 5px; padding-right: 5px">

        <div class="col-sm-12 col-md-12 col-lg-12 ">
            <?php
			//echo Extplorer::widget();
				// echo Html::panel(
					// ['heading' => 'Employee Status', 'body' => $pertama],
					// Html::TYPE_SUCCESS
				// );
				/* echo \navatech\roxymce\widgets\RoxyMceWidget::widget([
    'name'        => 'content', //default name of textarea which will be auto generated, REQUIRED if not using 'model' section
    'value'       => isset($_POST['content']) ? $_POST['content'] : '', //default value of current textarea, NOT REQUIRED
    'action'      => Url::to(['roxymce/default']), //default roxymce action route, NOT REQUIRED
    'options'     => [//TinyMce options, NOT REQUIRED, see https://www.tinymce.com/docs/
        'title' => 'RoxyMCE',//title of roxymce dialog, NOT REQUIRED
    ],
    'htmlOptions' => [],//html options of this widget, NOT REQUIRED
]); */
            ?>
      
        </div>
    </div>
</div>