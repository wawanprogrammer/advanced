<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

use dashboard\assets\AppAssetFusionChart;
AppAssetFusionChart::register($this);


$this->sideCorp = 'PT. ESM';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'effenbi_dboard';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;     

?>
<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
			<?php
				 echo Html::panel(
					[
						'heading' => ' <a class="btn btn-warning btn-xs full-right" href="/efenbi/report"><< BACK MENU </a>  ANALIZE DATA SALES',
						'body'=> '',
					],
					Html::TYPE_INFO
				);
			?>
		</div>
		<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
			<?php
				//print_r($nmGroup);
				/*
				 * DAILY CUSTOMERS VISIT
				 * @author ptrnov  [piter@lukison.com]
				 * @since 1.2
				*/
				$actionClass='btn btn-info btn-xs';
				$actionLabel='View';
				$attDinamik =[];
				/*GRIDVIEW ARRAY FIELD HEAD*/
				$headColomnEvent=[
					['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>1, 'ATTR' =>['FIELD'=>'USER_NM','SIZE' => '10px','label'=>'User','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>2, 'ATTR' =>['FIELD'=>'TIME_DAYSTART','SIZE' => '10px','label'=>'Time IN','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>3, 'ATTR' =>['FIELD'=>'TIME_DAYEND','SIZE' => '10px','label'=>'Time Out','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>4, 'ATTR' =>['FIELD'=>'SCDL_GRP_NM','SIZE' => '10px','label'=>'Schadule','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>5, 'ATTR' =>['FIELD'=>'CUST_TIPE_NM','SIZE' => '10px','label'=>'Type','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>6, 'ATTR' =>['FIELD'=>'CUST_KTG_NM','SIZE' => '10px','label'=>'Cetegory','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					//['ID' =>7, 'ATTR' =>['FIELD'=>'radiusMeter','SIZE' => '10px','label'=>'Radius/Meter','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					//['ID' =>8, 'ATTR' =>['FIELD'=>'sttKoordinat','SIZE' => '10px','label'=>'Status','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
				];
				$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
				
				
				/*GRIDVIEW ARRAY ACTION*/
				$attDinamik[]=[
					'class'=>'kartik\grid\ActionColumn',
					'dropdown' => true,
					'template' => '{view1}{view2}',
					'dropdownOptions'=>['class'=>'pull-left dropdown','style'=>['disable'=>true]],
					'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
					'dropdownButton'=>[
						'class' => $actionClass,
						'label'=>$actionLabel,
						//'caret'=>'<span class="caret"></span>',
					],
					'buttons' => [
						'view1' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'Image Start'),
															['/master/schedule-detail/img1','id'=>$model->ID],[
															'id'=>'img1-id',
															'data-toggle'=>"modal",
															'data-target'=>"#img1-visit",
															]). '</li>' . PHP_EOL;
						},
						'view2' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'Image End'),
															['/master/schedule-detail/img2','id'=>$model->ID],[
															'id'=>'img2-id',
															'data-toggle'=>"modal",
															'data-target'=>"#img2-visit",
															]). '</li>' . PHP_EOL;
						},
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'10px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
							'background-color'=>'rgba(74, 206, 231, 1)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'10px',
							'height'=>'10px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
						]
					],
				];
				
				/*GRIDVIEW EXPAND*/
				$attDinamik[]=[	
					'class'=>'kartik\grid\ExpandRowColumn',
					'width'=>'50px',
					'header'=>'',
					'value'=>function ($model, $key, $index, $column) {
						return GridView::ROW_COLLAPSED;
					},
					'detail'=>function ($model, $key, $index, $column){						
						$dataProviderHeader2= new ArrayDataProvider([
							//'key' => 'ID',
							'allModels'=>Yii::$app->db_esm->createCommand("CALL DASHBOARD_ESM_VISIT_header2('ALL_HEAD2','".$model['USER_ID']."','".$model['TGL']."')")->queryAll(),
							  'pagination' => [
								'pageSize' =>50,
							] 
						]);				
						
						return Yii::$app->controller->renderPartial('_expand1',[
							'dataProviderHeader2'=>$dataProviderHeader2
						]);
					},
					'collapseTitle'=>'a1',
					'expandTitle'=>'a2',
					
					//'headerOptions'=>['class'=>'kartik-sheet-style'] ,
					// 'allowBatchToggle'=>true,
					'expandOneOnly'=>true,
					// 'enableRowClick'=>true,
					//'disabled'=>true,
					'headerOptions'=>[
					'id'=>'xx',
						'style'=>[
							
							'text-align'=>'center',
							'width'=>'10px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
							'background-color'=>'rgba(74, 206, 231, 1)',
						]
					],
					'contentOptions'=>[
					'id'=>'xx',
						'style'=>[
						
							'text-align'=>'center',
							'width'=>'10px',
							'height'=>'10px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
						]
					],
				];
				
				/*GRIDVIEW ARRAY ROWS*/
				foreach($gvHeadColomn as $key =>$value[]){
					$attDinamik[]=[
						'attribute'=>$value[$key]['FIELD'],
						'label'=>$value[$key]['label'],
						'filterType'=>$value[$key]['filterType'],
						'filter'=>$value[$key]['filter'],
						'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
						'hAlign'=>'right',
						'vAlign'=>'middle',
						//'mergeHeader'=>true,
						'noWrap'=>true,
						'group'=>$value[$key]['GRP'],
						'format'=>$value[$key]['FORMAT'],						
						'headerOptions'=>[
								'style'=>[
								'text-align'=>'center',
								'width'=>$value[$key]['FIELD'],
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(74, 206, 231, 1)',
								'background-color'=>'rgba('.$value[$key]['warna'].')',
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>$value[$key]['align'],
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(13, 127, 3, 0.1)',
							]
						],
					];
				};
				
				/*STATUS RADIUS
				$attDinamik[]=[
						'attribute'=>'sttKoordinat',
						'label'=>'STATUS',
						'filter'=>$SttFilter,
					    'filterOptions'=>['style'=>'background-color:rgba(249, 215, 100, 1); align:center'],
						'hAlign'=>'right',
						'vAlign'=>'middle',
						'value' => function ($model) {
							return statusRadius($model);
						},
						'noWrap'=>true,
						//'group'=>$value[$key]['GRP'],
						'format'=>'html',						
						'headerOptions'=>[
								'style'=>[
								'text-align'=>'center',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(249, 215, 100, 1)',								
							]
						],
						'contentOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(13, 127, 3, 0.1)',
							]
						],
					];
				*/
				
				
				
				/*SHOW GRID VIEW LIST*/
				echo GridView::widget([
					'id'=>'cust-visit-list',
					'dataProvider' => $dataProviderX,
					//'filterModel' => $searchModel,					
					//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
					'columns' => $attDinamik,
					/* [
						['class' => 'yii\grid\SerialColumn'],
						'start',
						'end',
						'title',
						['class' => 'yii\grid\ActionColumn'],
					], */
					'pjax'=>true,
					'pjaxSettings'=>[
						'options'=>[
							'enablePushState'=>false,
							'id'=>'cust-visit-list',
						],
					],
					'panel' => [
								'heading'=>'<h3 class="panel-title">DETAIL VISIT</h3>',
								'type'=>'info',
								//'showFooter'=>false,
					],
					'toolbar'=> [
						''//'{items}',
					],
					// 'hover'=>true, //cursor select
					// 'responsive'=>true,
					// 'responsiveWrap'=>true,
					// 'bordered'=>true,
					// 'striped'=>true,
				]);			
			?>
		</div>
	</div>
</div>