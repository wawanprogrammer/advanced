<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
//use kartik\editable\Editable;
use kartik\grid\GridView;


use lukisongroup\esm\models\Barang;
use lukisongroup\purchasing\models\ro\Requestorder;
use lukisongroup\purchasing\models\ro\Rodetail;
use lukisongroup\purchasing\models\ro\RodetailSearch;

use lukisongroup\master\models\Barangumum;
use lukisongroup\purchasing\models\pr\Podetail;
use lukisongroup\hrd\models\Employe;


		
$idEmp = Yii::$app->user->identity->EMP_ID;
$emp = Employe::find()->where(['EMP_ID'=>$idEmp])->one();
$kr = $emp->DEP_SUB_ID;


	/*
	 * LINK ETD
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function link_etd($poHeader){
		$title = Yii::t('app',$poHeader->ETD);
		$options = [ 'id'=>'po-etd',	
					  'data-toggle'=>'modal',
					  'data-target'=>'#frm-etd',				 
					  'title'=>'Estimate Time Delivery'
		]; 
		$url = Url::toRoute(['/purchasing/purchase-order/etd-view','kdpo'=>$poHeader->KD_PO]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($title,$url, $options);
		return $content;	
	} 
	
	/*
	 * LINK ETD
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function link_eta($poHeader){
		$title = Yii::t('app',$poHeader->ETA);
		$options = [ 'id'=>'po-eta',	
					  'data-toggle'=>'modal',
					  'data-target'=>'#frm-eta',				 
					  'title'=>'Estimate Time Arriver'
		]; 
		$url = Url::toRoute(['/purchasing/purchase-order/eta-view','kdpo'=>$poHeader->KD_PO]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($title,$url, $options);
		return $content;	
	} 
	
	/*
	 * LINK BUTTON SELECT SUPPLIER
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function SupplierSearch($poHeader){
		$title = Yii::t('app','');
		$options = [ 'id'=>'select-spl-id',	
					  'data-toggle'=>"modal",
					  'data-target'=>"#search-spl",											
					  'class'=>'btn btn-warning btn-xs', 
					  //'style'=>['width'=>'150px'],
					  'title'=>'Set Supplier'
		]; 
		$icon = '<span class="glyphicon glyphicon-open"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/purchase-order/supplier-view','kdpo'=>$poHeader->KD_PO]);
		$content = Html::a($label,$url, $options);
		return $content;	
	} 
	
	/*
	 * LINK BUTTON SELECT SHIPPLING
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function ShippingSearch($poHeader){
		$title = Yii::t('app','');
		$options = [ 'id'=>'select-shp-id',	
					  'data-toggle'=>"modal",
					  'data-target'=>"#search-shp",											
					  'class'=>'btn btn-info btn-xs', 
					  //'style'=>['width'=>'150px'],
					  'title'=>'Set Shipping'
		]; 
		$icon = '<span class="glyphicon glyphicon-save"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/purchase-order/shipping-view','kdpo'=>$poHeader->KD_PO]);
		$content = Html::a($label,$url, $options);
		return $content;	
	} 
	
	/*
	 * LINK BUTTON SELECT BILLING
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function BillingSearch($poHeader){
		$title = Yii::t('app','');
		$options = [ 'id'=>'select-bil-id',	
					  'data-toggle'=>"modal",
					  'data-target'=>"#search-bil",											
					  'class'=>'btn btn-info btn-xs', 
					  //'style'=>['width'=>'150px'],
					  'title'=>'Set Billing'
		]; 
		$icon = '<span class="glyphicon glyphicon-import"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/purchase-order/billing-view','kdpo'=>$poHeader->KD_PO]);
		$content = Html::a($label,$url, $options);
		return $content;	
	} 
	
	/*
	 * COLUMN GRID VIEW CREATE PO
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	$gridColumns = [
		[/* Attribute Serial No */
			'class'=>'kartik\grid\SerialColumn',
			'width'=>'10px',
			'header'=>'No.',
			'hAlign'=>'center',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',							
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',								
				]
			], 
			'pageSummaryOptions' => [
				'style'=>[
						'border-right'=>'0px',									
				]
			]
		],	
		/* [
			'attribute'=>'KD_PO',
			'hidden'=>true,
			'group'=>false,
			'groupFooter'=>function ($model, $key, $index, $widget) {
				$subttl=[
					 'mergeColumns'=>[[1,5]],
					  'content'=>[             // content to show in each summary cell
                        1=>'Summary',
                        6=>GridView::F_SUM,
                    ],
				 ];
				return $subttl;
			},

		], */
		
		[/* Attribute Items Barang */
			'attribute'=>'KD_BARANG',
			'label'=>'SKU',						
			'hAlign'=>'left',	
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'format' => 'raw',	
			'headerOptions'=>[
				//'class'=>'kartik-sheet-style'							
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',								
				]
			],
			'contentOptions'=>[
				'style'=>[
					'width'=>'150px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',								
				]
			], 
			'pageSummaryOptions' => [
				'style'=>[
						'border-left'=>'0px',
						'border-right'=>'0px',									
				]
			]
		],
		[/* Attribute Items Barang */
			'label'=>'Items Name',
			'attribute'=>'NM_BARANG',
			'hAlign'=>'left',	
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'format' => 'raw',	
			'headerOptions'=>[
				//'class'=>'kartik-sheet-style'							
				'style'=>[
					'text-align'=>'center',
					'width'=>'200px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',								
				]
			],
			'contentOptions'=>[
				'style'=>[
					'width'=>'200px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',								
				]
			], 
			'pageSummaryOptions' => [
				'style'=>[
						'border-left'=>'0px',
						'border-right'=>'0px',									
				]
			]
		],
		[/* Attribute Request Quantity */
			'attribute'=>'QTY',
			'label'=>'Qty',						
			'vAlign'=>'middle',
			'hAlign'=>'center',	
			'mergeHeader'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'60px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',								
				]
			],
			'contentOptions'=>[
				'style'=>[
						'text-align'=>'right',
						'width'=>'60px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						//'border-right'=>'0px',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
						'border-left'=>'0px',
						'border-right'=>'0px',									
				]
			]
		],					
		[/* Attribute Unit Barang */
			'attribute'=>'NM_UNIT',
			'mergeHeader'=>true,
			'label'=>'UoM',										
			'vAlign'=>'middle',	
			'hAlign'=>'right',	
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',								
				]
			],						
			'contentOptions'=>[
				'style'=>[
						'text-align'=>'left',		
						'width'=>'150px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',	
						'border-left'=>'0px',									
				]
			],	
			'pageSummaryOptions' => [
				'style'=>[
						'border-left'=>'0px',
						'border-right'=>'0px',									
				]
			],
			'pageSummary'=>function ($summary, $data, $widget){ 
							return 	'<div>Sub Total :</div>								
									<div>Discount :</div>
									<div>TAX :</div>
									<div>Delevery.Cost :</div>
									<div><b>GRAND TOTAL :</b></div>'; 
						},
			'pageSummaryOptions' => [
				'style'=>[
						'font-family'=>'tahoma',
						'font-size'=>'8pt',	
						'text-align'=>'right',
						'border-left'=>'0px',
						'border-right'=>'0px',						
				]
			],			
		],
		[
			/* Attribute Unit Barang */
			'attribute'=>'HARGA',
			'mergeHeader'=>true,
			'label'=>'Price',										
			'vAlign'=>'middle',	
			'hAlign'=>'right',	
			'headerOptions'=>[
				//'class'=>'kartik-sheet-style'							
				'style'=>[
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',								
				]
			],						
			'contentOptions'=>[
				'style'=>[
						'text-align'=>'right',		
						'width'=>'100px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',									
				]
			],
			'format'=>['decimal', 2],
			'pageSummary'=>function ($summary, $data, $widget) use ($poHeader){ 
							return '<div>IDR</div >
									<div>  
									'.Html::a($poHeader->DISCOUNT,Url::toRoute(['/purchasing/purchase-order/discount-view','kdpo'=>$poHeader->KD_PO]),['id'=>'discount','data-toggle'=>'modal','data-target'=>'#frm-discount']).'
									%</div >
									<div>  
									'.Html::a($poHeader->PAJAK,Url::toRoute(['/purchasing/purchase-order/pajak-view','kdpo'=>$poHeader->KD_PO]),['id'=>'pajak','data-toggle'=>'modal','data-target'=>'#frm-pajak']).'
									%</div >
									<div>IDR</div >									
									<div>IDR</div >';								
									
						},
			'pageSummaryOptions' => [
				'style'=>[
						'font-family'=>'tahoma',
						'font-size'=>'8pt',	
						'text-align'=>'right',
						'border-left'=>'0px',																
				]
			],
		],
		[
			'class'=>'kartik\grid\FormulaColumn', 
			'header'=>'Amount', 
			'mergeHeader'=>true,
			'vAlign'=>'middle',
			'hAlign'=>'right', 
			//'width'=>'7%',					
			'value'=>function ($model, $key, $index, $widget) { 
				$p = compact('model', 'key', 'index');
				return $widget->col(3, $p) != 0 ? $widget->col(3, $p) * $widget->col(5, $p) : 0;
				//return $widget->col(3, $p) != 0 ? $widget->col(5 ,$p) * 100 / $widget->col(3, $p) : 0;
			},						
			'headerOptions'=>[
				//'class'=>'kartik-sheet-style'							
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',								
				]
			],	
			'contentOptions'=>[
				'style'=>[
						'text-align'=>'right',		
						'width'=>'150px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',									
				]
			],	
			'pageSummaryFunc'=>GridView::F_SUM,
			'pageSummary'=>true,
			'pageSummary'=>function ($summary, $data, $widget) use ($poHeader)	{	
					/*
					 * Definition SUMMARY TOTAL
					 * @author ptrnov  <piter@lukison.com>
					 * @since 1.1
					 */
					$subtotal=$summary;
					$discount=($poHeader->DISCOUNT)/100;
					$tax=($poHeader->PAJAK)/100;
					$delivery=$poHeader->DELIVERY_COST; 
					
					/*
					 * Calculate SUMMARY TOTAL
					 * @author ptrnov  <piter@lukison.com>
					 * @since 1.1
					 */
					$ttlDiscount=$poHeader->DISCOUNT!=0 ? $discount*$subtotal:0.00;
					$ttlTax = $poHeader->PAJAK!=0 ? $tax*$subtotal :0.00;
					$ttlDelivery=$poHeader->DELIVERY_COST!=0 ? $delivery:0.00;
					$grandTotal=$subtotal + $ttlDiscount + $ttlTax + $ttlDelivery;	
					
					/*
					 * DISPLAY SUMMARY TOTAL
					 * LINK Modal Editing Discount | tax
					 * @author ptrnov  <piter@lukison.com>
					 * @since 1.1
					 */
					return '<div>'.$subtotal.',</div>
						<div>'.$ttlDiscount.'</div>
						<div>'.$ttlTax.'</div>
						<div>'.Html::a($ttlDelivery,Url::toRoute(['/purchasing/purchase-order/delivery-view','kdpo'=>$poHeader->KD_PO]),['id'=>'delivery','data-toggle'=>'modal','data-target'=>'#frm-delivery']).'</div>	
						<div><b>'.$grandTotal.'</b></div>';  
			},
			'pageSummaryOptions' => [
				'style'=>[
						'text-align'=>'right',		
						'width'=>'100px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',	
						//'text-decoration'=>'underline',
						//'font-weight'=>'bold',
						//'border-left-color'=>'transparant',		
						'border-left'=>'0px',									
				]
			],											
			'footer'=>true,						
		],				
	];
	
	
	/*
	 * GRID VIEW CREATE PO
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	$gvPoDetail= GridView::widget([
		'id'=>'gv-po-detail',
		'dataProvider'=> $poDetailProvider,				
		'showPageSummary' => true,
		'columns' => $gridColumns,
		'pjax'=>true,
		'pjaxSettings'=>[
		 'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-po-detail',
		   ],						  
		],
		/* 'panel' => [
			//'footer'=>false,
			'heading'=>false,						
		], */
		/* 'toolbar'=> [
			//'{items}',
		],  */				
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false, 
	]);	

	/*
	 * GRID VIEW CREATE PO -> BY REQUEST ORDER
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	$gvROSendPO=GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			'KD_RO',
			[
				'format'=>'raw',
				'value' => function ($data){
					$count = Rodetail::find()
						->where([
							'KD_RO'=>$data->KD_RO,
						])
						->count();
	 
					if(!empty($count)){
						return  Html::a('<button type="button" class="btn btn-primary btn-xs">View</button>',['detail','kd_ro'=>$data->KD_RO,'kdpo'=>$_GET['kdpo']],[
									'data-toggle'=>"modal",
									'data-target'=>"#myModal",
									'data-title'=> $data->KD_RO,
								]); // ubah ini
					} else {
						return '<button type="button" class="btn btn-danger btn-xs">No Data</button>';
					}
				}
			],
		],
	]); 
		
	/*
	 * MODAL SELECT REQUEST ORDER 
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.1
     */
	$this->registerJs("
		$('#myModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title') 
			var href = button.attr('href') 
			modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			});
	",$this::POS_READY);
	Modal::begin([
		'id' => 'myModal',
		'header' => '<h4 class="modal-title">...</h4>',
	]);	 
		echo '...';	 
	Modal::end();

?>

<!-- Stack the columns on mobile by making one full-width and the other half-width -->
<div class="row">
	<!-- SIDE LEFT | REQUEST ORDER | SALES ORDER !-->
	<div class="col-xs-12 col-md-3">
		<?php echo $gvROSendPO; ?>
	</div>	
	<div class="col-xs-12 col-md-9">
		<div class="row">
			<!-- Title Left Side Descript Supplier !-->
			<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;">
				<dl>
					<?php
						$splName = $supplier!='' ? $supplier->NM_SUPPLIER : 'Supplier No Set';
						$splAlamat = $supplier!='' ? $supplier->ALAMAT : 'Address No Set';
						$splKota = $supplier!='' ? $supplier->KOTA : 'City No Set';
						$splTlp = $supplier!='' ? $supplier->TLP : 'Phone No Set';
						$splFax = $supplier!='' ? $supplier->FAX : 'FAX No Set';
						$splEmail= $supplier!='' ? $supplier->EMAIL : 'Email No Set';
					?>
					<dt><?=$splName; ?></dt>
					<dt><?=$splAlamat; ?></dt>
					<dt><?=$splKota; ?></dt>					
					<dt style="width:80px; float:left;">Telp / Fax</dt>
					<dd>:	<?=$splTlp; ?> / <?=$splFax; ?></dd>				
					<dt style="width:80px; float:left;">Email</dt>
					<dd>:	<?=$splEmail; ?></dd>    					
				</dl>			
			</div>			
			<!-- Title Right Side Descript Purchase !-->	
			<div class="col-xs-5 col-sm-5 col-md-5" style="font-family: tahoma ;font-size: 9pt;">
				<dl>
					<?php
						$poID = $poHeader!='' ? $poHeader->KD_PO: 'PO Not Set';
						$tglCreate=$poHeader!='' ? \Yii::$app->formatter->asDate($poHeader->CREATE_AT,'Y-M-d') :'';
					?>
					<dt style="width:80px; float:left;">Date</dt>
					<dd>:	<?=$tglCreate; ?></dd>     	  
					
					<dt style="width:80px; float:left;">No.Order</dt>
					<dd>:	<?=$poID; ?></dd>     	  
					
					<dt style="width:80px; float:left;">Order By</dt>
					<dd>:	<?= Yii::$app->user->identity->username; ?></dd> 
					
					<dt style="width:80px; float:left;">ETD</dt>
					<dd>:	<?php echo link_etd($poHeader); ?></dd> 
					
					<dt style="width:80px; float:left;">ETA</dt>
					<dd>:	<?php echo link_eta($poHeader); ?></dd> 
				</dl>				
			</div>
			<!-- Button Select |Supplier|Shipping|Billing !-->
			<div class="col-xs-1 col-sm-1 col-md-1" style="font-family: tahoma ;font-size: 9pt;">
				<div>
					<?php echo SupplierSearch($poHeader); ?>
				</div>
				<div  Style="margin-top:2px">
					<?php echo ShippingSearch($poHeader); ?>
				</div>
				<div Style="margin-top:2px">
					<?php echo BillingSearch($poHeader); ?>
				</div>
				
			</div>
		</div>
		<hr/>
		<!-- GRID PO Detail !-->	
		<div>
			<?php  echo $gvPoDetail; ?>
		</div>
		<!-- Title BOTTEM Descript !-->	
		<div  class="row">
				<div class="col-md-5" style="font-family: tahoma ;font-size: 9pt;float:left;">
					<dl>
						<?php
							$shipNm= $ship !='' ? $ship->NM_ALAMAT : 'Shipping Not Set';
							$shipAddress= $ship!='' ? $ship->ALAMAT_LENGKAP :'Address Not Set';
							$shipCity= $ship!='' ? $ship->KOTA : 'City Not Set';
							$shipPhone= $ship!='' ? $ship->TLP : 'Phone Not Set';
							$shipFax= $ship!='' ? $ship->FAX : 'Fax Not Set';
							$shipPic= $ship!='' ? $ship->CP : 'PIC not Set';
						?>
						<dt><h6><u><b>Shipping Address :</b></u></h6></dt>
						<dt><?=$shipNm; ?></dt> 				
						<dt><?=$shipAddress;?></dt>				
						<dt><?=$shipCity?></dt>
						<dt style="width:80px; float:left;">Tlp</dt>
						<dd>:	<?=$shipPhone;?></dd> 					
						<dt style="width:80px; float:left;">FAX</dt>
						<dd>:	<?=$shipFax; ?></dd>  					
						<dt style="width:80px; float:left;">CP</dt>
						<dd>:	<?=$shipPic; ?></dd> 
					</dl>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-5" style="font-family: tahoma ;font-size: 9pt;float:left;">
					<dl>
						<?php
							$billNm= $bill !='' ? $bill->NM_ALAMAT : 'Billing Not Set';
							$billAddress= $bill!='' ? $bill->ALAMAT_LENGKAP :'Address Not Set';
							$billCity= $bill!='' ? $bill->KOTA : 'City Not Set';
							$billPhone= $bill!='' ? $bill->TLP : 'Phone Not Set';
							$billFax= $bill!='' ? $bill->FAX : 'Fax Not Set';
							$billPic= $bill!='' ? $bill->CP : 'PIC not Set';
						?>
						<dt><h6><u><b>Billing Address :</b></u></h6></dt>
						<dt><?=$billNm;?></dt>				
						<dt><?=$billAddress;?></dt>				
						<dt><?=$billCity;?></dt>

						<dt style="width:80px; float:left;">Tlp</dt>
						<dd>:	<?=$billPhone;?></dd>     	  
						
						<dt style="width:80px; float:left;">FAX</dt>
						<dd>:	<?=$billFax;?></dd>     	  
						
						<dt style="width:80px; float:left;">CP</dt>
						<dd>:	<?=$billPic;?></dd> 
					</dl>
				</div>			
		</div>	
		<div  class="row">
			<div class="col-md-9">
				<table id="tblRo" class="table table-bordered" style="width:360px;font-family: tahoma ;font-size: 8pt;">
					<!-- Tanggal!-->
					 <tr>
						<!-- Tanggal Pembuat RO!-->
						<th style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl1=$poHeader->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG1_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl1;  
								?>
							</div> 
						
						</th>		
						<!-- Tanggal Pembuat RO!-->
						<th style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl2=$poHeader->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG2_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl2;  
								?>
							</div> 
						
						</th>		
						<!-- Tanggal PO Approved!-->				
						<th style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl3=$poHeader->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($poHeader->SIG3_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl3;  
								?>
							</div> 				
						</th>	
						
					</tr>
					<!-- Signature !-->
					 <tr>
						<th style="text-align: center; vertical-align:middle;width:180; height:60px">
							<?php 
								$ttd1 = $poHeader->SIG1_SVGBASE64!=0 ?  '<img src="'.$poHeader->SIG1_SVGBASE64.'" height="120" width="150"></img>' : '';
								echo $ttd1;
							?> 	
						</th>								
						<th style="text-align: center; vertical-align:middle;width:180">
							<?php 
								$ttd2 = $poHeader->SIG2_SVGBASE64!=0 ?  '<img src="'.$poHeader->SIG2_SVGBASE64.'" height="120" width="150"></img>' : '';
								echo $ttd2;
							?> 
						</th>
						<th style="text-align: center; vertical-align:middle;width:180">
							<?php 
								$ttd3 = $poHeader->SIG3_SVGBASE64!=0 ?  '<img src="'.$poHeader->SIG3_SVGBASE64.'" height="120" width="150"></img>' : '';
								echo $ttd3;
							?> 
						</th>
					</tr>
					<!--Nama !-->
					 <tr>
						<th style="text-align: center; vertical-align:middle;height:20; background-color:rgba(0, 95, 218, 0.3);text-align: center;">
							<div>		
								<?php
									$sigNm1=$poHeader->SIG1_NM!='none' ? '<b>'.$poHeader->SIG1_NM.'</b>' : 'none';
									echo $sigNm1;
								?>
							</div>
						</th>								
						<th style="text-align: center; vertical-align:middle;height:20; background-color:rgba(0, 95, 218, 0.3);text-align: center;">
							<div>		
								<?php
									$sigNm2=$poHeader->SIG2_NM!='none' ? '<b>'.$poHeader->SIG2_NM.'</b>' : 'none';
									echo $sigNm2;
								?>
							</div>
						</th>
						<th style="text-align: center; vertical-align:middle;height:20; background-color:rgba(0, 95, 218, 0.3);text-align: center;">
							<div>		
								<?php
									$sigNm3=$poHeader->SIG3_NM!='none' ? '<b>'.$poHeader->SIG3_NM.'</b>' : 'none';
									echo $sigNm3;
								?>
							</div>
						</th>
					</tr>
					<!-- Department|Jbatan !-->
					 <tr>
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>		
								<b><?php  echo 'Purchaser'; ?></b>
							</div>
						</th>								
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>		
								<b><?php  echo 'F & A'; ?></b>
							</div>
						</th>
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>		
								<b><?php  echo 'Director'; ?></b>
							</div>
						</th>
					</tr>
				</table>				
			</div>
		</div>		
	</div>
</div>



<?php
	$this->registerJs("
		/* $(document).on('click', '[data-toggle-discount]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-discount');
			var disc = $('#discount1').attr('DISCOUNT');
			$.ajax({
					url: '/purchasing/purchase-order/discount',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx  + '&disc='+ disc,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container:'#gv-po-detail'});
						} 
					}
				});
		}); */
		
		/* $(document).on('click', '[data-toggle-tax]', function(e){
			e.preventDefault();
			var idtax = $(this).data('toggle-tax);
			var tax = $('#tax').attr('PAJAX');
			$.ajax({
					url: '/purchasing/purchase-order/tax',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx + '&tax='+ tax,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container:'#gv-po-detail'});
						} 
					}
				});
		}); */
		
	",$this::POS_READY);
	
	/*
	 * JS MODAL Discount
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			//$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#frm-discount').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
	",$this::POS_READY);
	Modal::begin([
			'id' => 'frm-discount',
			'header' => '<h4 class="modal-title">PERSEN DISCOUNT</h4>',
			//'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			//'size' => 'modal-xs'
			'size' => Modal::SIZE_SMALL,
			/* 'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			] */
		]);
	Modal::end();
	
	/*
	 * JS MODAL Pajak
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			//$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#frm-pajak').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
	",$this::POS_READY);
	Modal::begin([
			'id' => 'frm-pajak',
			'header' => '<h4 class="modal-title">PERSEN PAJAK</h4>',
			'size' => Modal::SIZE_SMALL,
			/* 'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			] */
		]);
	Modal::end();
	
	/*
	 * JS MODAL Delivery Cost
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			//$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#frm-delivery').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
	",$this::POS_READY);
	Modal::begin([
			'id' => 'frm-delivery',
			'header' => '<h4 class="modal-title">DELIVERY COST</h4>',
			'size' => Modal::SIZE_SMALL,
			/* 'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			] */
		]);
	Modal::end();
	
	/*
	 * JS MODAL ETD
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#frm-etd').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
	",$this::POS_READY);
	Modal::begin([
			'id' => 'frm-etd',
			'header' => '<h4 class="modal-title">Estimate Time Delivery</h4>',
			'size' => Modal::SIZE_SMALL,
			/* 'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			] */
		]);
	Modal::end();
	
	/*
	 * JS MODAL ETA
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#frm-eta').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
	",$this::POS_READY);
	Modal::begin([
			'id' => 'frm-eta',
			'header' => '<h4 class="modal-title">Estimate Time Arrival</h4>',
			'size' => Modal::SIZE_SMALL,
			/* 'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			] */
		]);
	Modal::end();
	
	/*
	 * JS MODAL SHEEPING
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#search-shp').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
	",$this::POS_READY);
	Modal::begin([
			'id' => 'search-shp',
			'header' => '<h4 class="modal-title">Shipping Address</h4>',
			'size' => Modal::SIZE_SMALL,
		]);
	Modal::end();
	
	/*
	 * JS MODAL SUPPLIER
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#search-spl').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
	",$this::POS_READY);
	Modal::begin([
			'id' => 'search-spl',
			'header' => '<h4 class="modal-title">Supplier Address</h4>',
			'size' => Modal::SIZE_SMALL,
		]);
	Modal::end();
	
	/*
	 * JS MODAL BILLING
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#search-bil').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
	",$this::POS_READY);
	Modal::begin([
			'id' => 'search-bil',
			'header' => '<h4 class="modal-title">Billing Address</h4>',
			'size' => Modal::SIZE_SMALL,
		]);
	Modal::end();
?>

