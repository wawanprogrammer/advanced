
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;



$this->params['breadcrumbs'][] = $this->title;

$this->sideCorp = 'Purchase Report';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'acc_purchase';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Purchase Report');      /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;               /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-12 col-md-12 col-lg-12">
			<?php
				/*
				 * PURCHASE REPORT ALL
				 * @author ptrnov  [piter@lukison.com]
				 * @since 1.2
				*/
				$actionClass='btn btn-info btn-xs';
				$actionLabel='View';
				$attDinamik =[];
				/*GRIDVIEW ARRAY FIELD HEAD*/
				$headColomnEvent=[
					['ID' =>0, 'ATTR' =>['FIELD'=>'KD_CORP','SIZE' => '10px','label'=>'CORP','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>$aryCorpID,'filterType'=>GridView::FILTER_SELECT2,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>1, 'ATTR' =>['FIELD'=>'CREATE_AT','SIZE' => '10px','label'=>'DATE','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>2, 'ATTR' =>['FIELD'=>'KD_PO','SIZE' => '10px','label'=>'KD.PO','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>3, 'ATTR' =>['FIELD'=>'KD_COSTCENTER','SIZE' => '10px','label'=>'COSTCENTER','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
					['ID' =>4, 'ATTR' =>['FIELD'=>'SUPPLIER','SIZE' => '10px','label'=>'SUPPLIER','align'=>'left','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					['ID' =>5, 'ATTR' =>['FIELD'=>'NM_BARANG','SIZE' => '10px','label'=>'NM_BARANG','align'=>'left','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					['ID' =>6, 'ATTR' =>['FIELD'=>'QTY','SIZE' => '10px','label'=>'QTY','align'=>'right','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					['ID' =>7, 'ATTR' =>['FIELD'=>'UNIT','SIZE' => '10px','label'=>'UNIT','align'=>'right','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],					
					['ID' =>8, 'ATTR' =>['FIELD'=>'HARGA','SIZE' => '10px','label'=>'HARGA','align'=>'right','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'decimal','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],
					['ID' =>9, 'ATTR' =>['FIELD'=>'SUB_TTL','SIZE' => '10px','label'=>'Sub Total','align'=>'right','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'decimal','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],					
					['ID' =>10, 'ATTR' =>['FIELD'=>'PAJAK','SIZE' => '10px','label'=>'PPN','align'=>'right','warna'=>'74, 206, 231, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'74, 206, 231, 1']],					
				];
				$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
				
				/*GRIDVIEW ARRAY ACTION*/
				$attDinamik[]=[
					'class'=>'kartik\grid\ActionColumn',
					'dropdown' => true,
					'template' => '{view}',
					'dropdownOptions'=>['class'=>'pull-left dropdown','style'=>['disable'=>true]],
					'dropdownButton'=>[
						'class' => $actionClass,
						'label'=>$actionLabel,
						//'caret'=>'<span class="caret"></span>',
					],
					'buttons' => [
						'view' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'View PO'),
															['/sistem/personalia/view','id'=>$model->ID],[
															'id'=>'alias-cust-id',
															'data-toggle'=>"modal",
															'data-target'=>"#alias-cust",
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
						//'pageSummaryFunc'=>GridView::F_SUM,
						//'pageSummary'=>true,
						// 'pageSummaryOptions' => [
							// 'style'=>[
									// 'text-align'=>'right',
									//'width'=>'12px',
									// 'font-family'=>'tahoma',
									// 'font-size'=>'8pt',
									// 'text-decoration'=>'underline',
									// 'font-weight'=>'bold',
									// 'border-left-color'=>'transparant',
									// 'border-left'=>'0px',
							// ]
						// ],
					];
				};
				
				/*SHOW GRID VIEW LIST EVENT*/
				echo GridView::widget([
					'id'=>'puchase-list',
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,					
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
							'id'=>'puchase-list',
						],
					],
					'panel' => [
								'heading'=>'<h3 class="panel-title">LIST DATA PURCHASING</h3>',
								'type'=>'warning',
								//'showFooter'=>false,
					],
					'toolbar'=> [
						''//'{items}',
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>true,
				]);
			?>
		</div>
	</div>
</div>