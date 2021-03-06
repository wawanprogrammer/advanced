<?php
/*extensions*/
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
// use lukisongroup\assets\AppAssetJqueryJSignature;
// AppAssetJqueryJSignature::register($this);

/* namespace models*/
use lukisongroup\master\models\Unitbarang;
use lukisongroup\purchasing\models\rqt\Requesttermstatus;

$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');

	/* LOCK STATUS TOMBOL */
	/* LOCK STATUS TOMBOL */
	 $headerStatus=$roHeader->STATUS;
	 $barangStatus = $roDetail->STATUS;

 $this->registerJs('
		$(document).ready(function($) {
			/* Data Signature1 from DB */
			var ro_datadb1 =\''. $roHeader->SIG1_SVGBASE64 . '\'
				var i = new Image();
					i.src = ro_datadb1
					$(i).appendTo($("#ro-view-approval-sig1"));
			/* Data Signature2 from DB */
			var ro_datadb2 =\''. $roHeader->SIG2_SVGBASE64 . '\'
				var j = new Image();
					j.src = ro_datadb2
					$(j).appendTo($("#ro-view-approval-sig2"));
		});
 ',$this::POS_BEGIN);

	/*Status Sign Signature Login*/
	$arrayStt= [
		  ['status' => 0, 'DESCRIP' => 'PROCESS'],
		  ['status' => 1, 'DESCRIP' => 'PENDING'],
		  ['status' => 101, 'DESCRIP' => 'APPROVED'],
		  ['status' => 4, 'DESCRIP' => 'REJECT'],
	];
	$valStt = ArrayHelper::map($arrayStt, 'status', 'DESCRIP');


	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[3=PO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(3)){
			return Yii::$app->getUserOpt->Modul_akses(3);
		}else{
			return false;
		}
	}
	//print_r(getPermission());
	/*
	 * Declaration Componen User Permission
	 * Function profile_user
	*/
	function getPermissionEmp(){
		if (Yii::$app->getUserOpt->profile_user()){
			return Yii::$app->getUserOpt->profile_user()->emp;
		}else{
			return false;
		}
	}
	//print_r(getPermissionEmp());


	/*
	 * STATUS FLOW DATA
	 * 1. NEW		= 0 	| Create First
	 * 2. APPROVED	= 1 	| Item Approved
	 * 3. PROCESS	= 101	| Sign Auth1 | Data Sudah di buat dan di tanda tangani
	 * 4. CHECKED	= 102	| Sign Auth2 | Data Sudah Di Check  dan di tanda tangani
	 * 5. APPROVED	= 103	| Sign Auth3 | Data Sudah Di disetujui dan di tanda tangani
	 * 6. DELETE	= 3 	| Data Hidden | Data Di hapus oleh pembuat petama, jika belum di Approved
	 * 7. REJECT	= 4		| Data tidak di setujui oleh manager atau Atasan  lain
	 * 8. PANDING	= 5		| Menunggu keputusan berikutnya.
	 * 9. UNKNOWN	<>		| Data Tidak valid atau tidak sah
	*/
	function statusProcessRo($model){
			if($model->STATUS==0){
				return Html::a('<i class="glyphicon glyphicon-retweet"></i> New', '#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
			}elseif($model->STATUS==1){
				return Html::a('<i class="glyphicon glyphicon-ok"></i> Approved', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
			}elseif ($model->STATUS==3){
				return Html::a('<i class="glyphicon glyphicon-remove"></i> DELETE', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
			}elseif ($model->STATUS==4){
				return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
			}elseif($model->STATUS==5){
				return Html::a('<i class="glyphicon glyphicon-retweet"></i> Pending', '#',['class'=>'btn btn-danger btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
			}elseif ($model->STATUS==100){
				return Html::a('<i class="glyphicon glyphicon-ok"></i> PROCESS', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
			}elseif ($model->STATUS==101){
				return Html::a('<i class="glyphicon glyphicon-ok"></i> CHECKED', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
			}elseif ($model->STATUS==102){
				return Html::a('<i class="glyphicon glyphicon-ok"></i> APPROVED', '#',['class'=>'btn btn-info btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
			}elseif ($model->STATUS==4){
				return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
			}
	    else{
				return Html::a('<i class="glyphicon glyphicon-question-sign"></i> UNKNOWN', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
			};
	}

	/*
	 * SIGNATURE AUTH1 | CREATED
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 1=CREATED]
	*/
	function SignCreated($roHeader){
		if(getPermission()){
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'ro-auth1-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#ro-auth1-sign",
							  'class'=>'btn btn-danger btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/request-term/sign-auth1-view','kd'=>$roHeader->KD_RIB]);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label,$url, $options);
				return $content;
			}else{
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'confirm-permission-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class'=>'btn btn-info btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$content = Html::button($label, $options);
				return $content;
			}
	}

	/*
	 * SIGNATURE AUTH2 | CHECKED
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 1=CREATED]
	*/
	function SignChecked($roHeader){
		if(getPermission()){
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'ro-auth2-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#ro-auth2-sign",
							  'class'=>'btn btn-warning btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/request-term/sign-auth2-view','kd'=>$roHeader->KD_RIB]);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label,$url, $options);
				return $content;
			}else{
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'confirm-permission-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class'=>'btn btn-info btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$content = Html::button($label, $options);
				return $content;
			}
	}

	/*
	 * SIGNATURE AUTH3 | Approved
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 101=Approved]
	*/
	function SignApproved($roHeader){
		if(getPermission()){
			if($roHeader->STATUS == 4)
	    {
	      $title = Yii::t('app', 'Reject');
				$btn = 'btn btn-danger btn-xs';
	    }else {
	      # code...
	      $title = Yii::t('app', 'Sign Hire');
				$btn = 'btn btn-warning btn-xs';
	    }
			
				$options = [ 'id'=>'ro-auth3-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#ro-auth3-sign",
							  'class'=>$btn,
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/request-term/sign-auth3-view','kd'=>$roHeader->KD_RIB]);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label,$url, $options);
				return $content;
			}else{
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'confirm-permission-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class'=>'btn btn-info btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$content = Html::button($label, $options);
				return $content;
			}
	}

	/**
	 * LINK  Note
	 * @author wawan  
     * @since 1.2
	*/
	function PoNote($kd){
			$title = Yii::t('app','');
			$options = [ 'id'=>'rqt-note-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#rqt-note-review",
						  'class'=>'btn btn-info btn-xs',
						  'title'=>'RQT Note'
			];
			$icon = '<span class="fa fa-plus fa-lg"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/request-term/update-note','id'=>$kd]);
			$content = Html::a($label,$url, $options);
			return $content;
	}


	/*
	 * Tombol Approval Item
	 * Permission Auth2 | Auth3
	 * Cancel Back To Process
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolApproval($url, $model){
		if(getPermission()){
			/* GF_ID>=4 Group Function[Director|GM|M|S] */
			$gF=getPermissionEmp()->GF_ID;
			$Auth2=getPermission()->BTN_SIGN2; // Auth2
			$Auth3=getPermission()->BTN_SIGN3; // Auth3
			if (($Auth2==1 or $Auth3==1) AND ($gF<=4)){
				$title = Yii::t('app', 'Approved');
				$options = [ 'id'=>'approved',
							 'data-pjax' => true,
							// 'data'=>['idc'=>$model->ID],
							 //'data-target'=>'#data-toggle-rodetail-approved',
							 'data-toggle-approved'=>$model->ID,
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				//$url = Url::toRoute(['/purchasing/request-order/approved_rodetail','kd'=>$model->KD_RIB]);
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
			}
		}
	}

	/*
	 * Tombol Reject Item
	 * Permission Auth2 | Auth3
	 * Cancel Back To Process
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolReject($url, $model) {
		if(getPermission()){
			/* GF_ID>=4 Group Function[Director|GM|M|S] */
			$gF=getPermissionEmp()->GF_ID;
			$Auth2=getPermission()->BTN_SIGN2; // Auth2
			$Auth3=getPermission()->BTN_SIGN3; // Auth3
			if (($Auth2==1 or $Auth3==1) AND ($gF<=4)){
				$title = Yii::t('app', 'Reject');
				$options = [ 'id'=>'reject',
							 'data-pjax'=>true,
							 'data-toggle-reject' => $model->ID
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				//$url = Url::toRoute(['/purchasing/request-order/approved','kd'=>$model->KD_RIB]);
				//$url = Url::toRoute(['/purchasing/request-order/approved']);
				//$url = Url::toRoute(['/purchasing/request-order/approved']);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
			}
		}
	}
	/*
	 * Tombol Cancel Item
	 * Permission Auth2 | Auth3
	 * Cancel Back To Process
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolCancel($url, $model){
		if(getPermission()){
			/* GF_ID>=4 Group Function[Director|GM|M|S] */
			$gF=getPermissionEmp()->GF_ID;
			$Auth2=getPermission()->BTN_SIGN2; // Auth2
			$Auth3=getPermission()->BTN_SIGN3; // Auth3
			if (($Auth2==1 or $Auth3==1) AND ($gF<=4)){
				$title = Yii::t('app', 'Cancel');
				$options = [ 'id'=>'cancel',
							 'data-pjax'=>true,
							 'data-toggle-cancel' => $model->ID
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
			}
		}
	}

	/*
	 * Tombol Modul Konci ->
	 * Permission [Status 101=10]
	 * CLOSED 101 or 10
	*/
	function tombolKonci($url, $model){
		$title = Yii::t('app', 'LOCKED');
		$options = [ 'id'=>'confirm-permission-id',
					  'data-toggle'=>"modal",
					  'data-target'=>"#confirm-permission-alert",
					  'class'=>'btn btn-info btn-xs',
					  'style'=>['width'=>'100px','text-align'=>'center'],
					  'title'=>'Signature'
		];
		$icon = '<span class="glyphicon glyphicon-retweet" style="text-align:center"></span>';
		$label = $icon . ' ' . $title;
		$content = Html::button($label, $options);
		return $content;

		// $title = Yii::t('app', 'LOCKED');
		// $options = [ 'id'=>'closed'];
		// $icon = '<span class="glyphicon glyphicon-lock "></span>';
		// $label = $icon . ' ' . $title;
		// return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
	}

?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<!-- HEADER !-->
	<div class="col-md-12">
		<div class="col-md-1" style="float:left;">
			<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
		</div>
		<div class="col-md-9" style="padding-top:15px;">
			<!--<h3 class="text-center"><b>Form Permintaan Barang & Jasa</b></h3>!-->
			<h3 class="text-center"><b>REVIEW REQUEST TERM</b></h3>
		</div>
			<dt style="float:left;">Status RT</dt>
			<dd>: <?=statusProcessRo($roHeader);?></dd>
		<div class="col-md-12"  style="padding-left:0px;">
			<hr>
		</div>
	</div>
	<!-- Title Descript !-->
	<div class="col-md-12">
		<dl>
			<dt style="width:100px; float:left;">Date</dt>
			<dd>: <?php echo date('d-M-Y'); ?></dd>
			<dt style="width:100px; float:left;">Kode Rqt</dt>
			<dd>: <?php echo $roHeader->KD_RIB; ?></dd>
			<dt style="width:100px; float:left;">Departement</dt>
			<dd>:
			<?php
				if (count($dept)!=0){
					echo $dept->DEP_NM;
				}else{
					echo 'Dept Set';
				}
			?>
			</dd>
		</dl>
	</div>
	<!-- Table Grid List RO Detail !-->
	<div class="col-md-12">
		<?php
		echo GridView::widget([
			'id'=>'rqt-process',
			'dataProvider'=> $dataProvider,
			'filterModel' => '',
			//'headerRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
			'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
			'beforeHeader'=>[
				[
					'columns'=>[
						['content'=>'', 'options'=>['colspan'=>2,'class'=>'text-center info',]],
						['content'=>'Quantity', 'options'=>['colspan'=>5, 'class'=>'text-center info']],
						['content'=>'Remark', 'options'=>['colspan'=>5, 'class'=>'text-center info']],
						//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']],
					],
				]
			],
			'columns' => [

				[
					/* Attribute Serial No */
					'class'=>'kartik\grid\SerialColumn',
					'contentOptions'=>['class'=>'kartik-sheet-style'],
					'width'=>'10px',
					'header'=>'No.',
					'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'verdana, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(126, 189, 188, 0.3)',
					]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'10px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
				/* ['attribute'=>'ID',], */
				[
					/* Attribute Items Barang */
					'label'=>'Type Investasi',
					'attribute'=>'nminvest',
					'hAlign'=>'left',
					'vAlign'=>'middle',
					'mergeHeader'=>true,
					'format' => 'raw',
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'150px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(126, 189, 188, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'150px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
				[
					/* Attribute Request Quantity */
					'class'=>'kartik\grid\EditableColumn',
					'attribute'=>'RQTY',
					'label'=>'Qty.Request',
					'vAlign'=>'middle',
					'hAlign'=>'center',
					'mergeHeader'=>true,
					'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
						//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
						return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
					},
					'editableOptions' => [
						'header' => 'Update Quantity',
						'inputType' => \kartik\editable\Editable::INPUT_TEXT,
						'size' => 'sm',
						'options' => [
							'pluginOptions' => ['min'=>0, 'max'=>50000]
						]
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'60px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(126, 189, 188, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'60px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
				[
					/* Attribute Submit Quantity */
					'attribute'=>'SQTY',
					'label'=>'Qty.Submit',
					'mergeHeader'=>true,
					'vAlign'=>'middle',
					'hAlign'=>'center',
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'60px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(126, 189, 188, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'60px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
				[
					/* Attribute Unit Barang */
					'attribute'=>'UNIT',
					'label'=>'Unit',
					'hAlign'=>'left',
					'vAlign'=>'middle',
					'mergeHeader'=>true,
					'value'=>function($model){
						$model=Unitbarang::find()->where('KD_UNIT="'.$model->UNIT. '"')->one();
						if (count($model)!=0){
							$UnitNm=$model->NM_UNIT;
						}else{
							$UnitNm='Not Set';
						}
						return $UnitNm;
					},
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'120px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(126, 189, 188, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'120px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
				[
					/* Attribute HARGA SUPPLIER */
					'class'=>'kartik\grid\EditableColumn',
					'attribute'=>'HARGA',
					'value'=>function($model){
						number_format($model->HARGA,2);
					},
					'label'=>'Price/Pcs',
					'vAlign'=>'middle',
					'hAlign'=>'center',
					'mergeHeader'=>true,
					// 'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
					// 	//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
					// 	return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
					// },
					'editableOptions' => [
						'header' => 'Update Price',
						'inputType' => \kartik\editable\Editable::INPUT_MONEY ,
						'size' => 'sm',
						// 'options' => [
						// 	'pluginOptions' => ['min'=>0, 'max'=>50000]
						// ]
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'100px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(126, 189, 188, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'right',
							'width'=>'100px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
				[
					/* Attribute */
					'class'=>'kartik\grid\EditableColumn',
					'attribute'=>'NOMER_INVOCE',
					'label'=>'No Invoce',
					'vAlign'=>'middle',
					'hAlign'=>'center',
					'mergeHeader'=>true,
					'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
						//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
						return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
					},
					'editableOptions' => [
						'header' => 'Update Invoice',
						'inputType' => \kartik\editable\Editable::INPUT_TEXT,
						'size' => 'sm',
						'options' => [
							'pluginOptions' => ['min'=>0, 'max'=>50000]
						]
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'120px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(126, 189, 188, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'120px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
				[
					/* Attribute */
					'class'=>'kartik\grid\EditableColumn',
					'attribute'=>'NOMER_FAKTURPAJAK',
					'label'=>'No faktur',
					'vAlign'=>'middle',
					'hAlign'=>'center',
					'mergeHeader'=>true,
					'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
						//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
						return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
					},
					'editableOptions' => [
						'header' => 'Update NoFaktur pajak',
						'inputType' => \kartik\editable\Editable::INPUT_TEXT,
						'size' => 'sm',
						'options' => [
							'pluginOptions' => ['min'=>0, 'max'=>50000]
						]
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'120px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(126, 189, 188, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'120px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
				[
					/* Attribute NOTE Barang */
					'class'=>'kartik\grid\EditableColumn',
					'attribute'=>'INVESTASI_PROGRAM',
					'label'=>'Notes',
					'hAlign'=>'left',
					'mergeHeader'=>true,
					'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
						return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0;
					},
					'editableOptions' => [
						'header' => 'Update program',
						'inputType' => \kartik\editable\Editable::INPUT_TEXTAREA,
						'size' => 'sm',
						'options' => [
							// 'pluginOptions' => ['min'=>0, 'max'=>50000]
						]
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'200px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>'rgba(126, 189, 188, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'left',
							'width'=>'200px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],

				[
					/* Attribute Status Detail RO */
					'attribute'=>'STATUS',
					'label'=>'Status',
					'hAlign'=>'center',
					'vAlign'=>'middle',
					'mergeHeader'=>true,
					'contentOptions'=>['style'=>'width: 100px'],
					'format' => 'html',
					'value'=>function ($model, $key, $index, $widget) {
								return statusProcessRo($model);
					},
					'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'100px',
						'font-family'=>'verdana, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(126, 189, 188, 0.3)',
					]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'100px',
							'font-family'=>'verdana, arial, sans-serif',
							'font-size'=>'8pt',
						]
					],
				],
			],
			'pjax'=>true,
			'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'rqt-process',
				 ],
			],
			'hover'=>true, //cursor select
			'responsive'=>true,
			'responsiveWrap'=>true,
			'bordered'=>true,
			'striped'=>'4px',
			'autoXlFormat'=>true,
			'export' => false,
		]);
		?>
	</div>

	<!-- PO Note !-->
	<div  class="row">
		<div  class="col-md-12" style="font-family: tahoma ;font-size: 9pt;">
			<dt><b>General Notes :</b></dt>
			<hr style="height:1px;margin-top: 1px; margin-bottom: 1px;font-family: tahoma ;font-size:8pt;">
			<div>
				<div style="float:right;text-align:right;">
					 <?= PoNote($roHeader->KD_RIB) ?>
				</div>
				<div style="margin-left:5px">
					<dd><?= $roHeader->NOTE ?></dd>
					<dt>Invoice exchange can be performed on Monday through Tuesday time of 09:00AM-16:00PM</dt>
				</div>
			</div>
			<hr style="height:1px;margin-top: 1px;">
		</div>
	</div>

	<!-- Signature !-->
	<div  class="col-md-12">
		<div  class="row" >
			<div class="col-md-6">
				<table id="tblRo" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
					<!-- Tanggal!-->
					 <tr>
						<!-- Tanggal Pembuat RO!-->
						<th  class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl1=$roHeader->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($roHeader->SIG1_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl1;
								?>
							</div>

						</th>
						<!-- Tanggal Pembuat RO!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl2=$roHeader->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($roHeader->SIG2_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl2;
								?>
							</div>

						</th>
						<!-- Tanggal PO Approved!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl3=$roHeader->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($roHeader->SIG3_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl3;
								?>
							</div>
						</th>

					</tr>
					<!-- Department|Jbatan !-->
					 <tr>
						<th  class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Created'; ?></b>
							</div>
						</th>
						<th class="col-md-1"  style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Checked'; ?></b>
							</div>
						</th>
						<th class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Approved'; ?></b>
							</div>
						</th>
					</tr>
					<!-- Signature !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle; height:40px">
							<?php
								$ttd1 = $roHeader->SIG1_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$roHeader->SIG1_SVGBASE64.'></img>' :SignCreated($roHeader);
								echo $ttd1;
							?>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
								$ttd2 = $roHeader->SIG2_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$roHeader->SIG2_SVGBASE64.'></img>' : SignChecked($roHeader);
								echo $ttd2;
							?>
						</th>
						<th  class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
							/*  author : wawan ver 1.0
									* jika tidak ada permission maka untuk tanda tangan yang akan approve hilang
									* jika BTN_SIGN3 adalah 0 maka untuk tanda tangan yang akan approve hilang
									* if status po header equal 4 then  button name Reject
							*/
							if(getPermission())
							{
								if(getPermission()->BTN_SIGN3 == 0)
								{
									$ttd3 = '';
									echo $ttd3;

								}else{
									$ttd3 = $roHeader->SIG3_SVGBASE64!='' ?  '<img src="'.$roHeader->SIG3_SVGBASE64.'" height="60" width="150"></img>' : SignApproved($roHeader);
									echo $ttd3;
								}
							}else{
								$ttd3 = '';
								echo $ttd3;
							}

							?>
						</th>
					</tr>
					<!--Nama !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm1=$roHeader->SIG1_NM!='none' ? '<b>'.$roHeader->SIG1_NM.'</b>' : 'none';
									echo $sigNm1;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm2=$roHeader->SIG2_NM!='none' ? '<b>'.$roHeader->SIG2_NM.'</b>' : 'none';
									echo $sigNm2;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm3=$roHeader->SIG3_NM!='none' ? '<b>'.$roHeader->SIG3_NM.'</b>' : 'none';
									echo $sigNm3;
								?>
							</div>
						</th>
					</tr>
				</table>
			</div>
			<!-- Button Submit!-->
			<div style="text-align:right; margin-top:80px; margin-right:15px">
				<!-- Button Back!-->
				<a href="/purchasing/request-term" class="btn btn-info btn-xs" role="button" style="width:90px">Kembali</a>
				<!-- Button Cetak!-->
				<?php
					echo Html::a('<i class="fa fa-print fa-fw fa-xs"></i> Print', ['cetakpdf','kd'=>$roHeader->KD_RIB,'v'=>'0'], ['target' => '_blank', 'class' => 'btn btn-success btn-xs','style'=>['width'=>'90px']]);
				?>
				<?php
					echo Html::a('<i class="fa fa-print fa-fw fa-xs"></i> Print Tmp', ['temp-cetakpdf','kd'=>$roHeader->KD_RIB,'v'=>'0'], ['target' => '_blank', 'class' => 'btn btn-success btn-xs','style'=>['width'=>'90px']]);
				?>
			</div>
		</div>
	</div>
</div>
<?php
	$this->registerJs("
		$(document).on('click', '[data-toggle-approved]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-approved');
			$.ajax({
					//url: '/purchasing/request-order/approved_rodetail?id=' + idx,
					url: '/purchasing/request-order/approved_rodetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							// Success
							$.pjax.reload({container:'#ro-process'});
						} else {
							// Fail
						}
					}
				});

		});
		$(document).on('click', '[data-toggle-reject]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-reject');
			$.ajax({
					url: '/purchasing/request-order/reject_rodetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container:'#ro-process'});
						}
					}
				});
		});

		$(document).on('click', '[data-toggle-cancel]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-cancel');
			$.ajax({
					url: '/purchasing/request-order/cancel_rodetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container:'#ro-process'});
						}
					}
				});
		});

	",$this::POS_READY);

	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#rqt-note-review').on('show.bs.modal', function (event) {
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
		'id' => 'rqt-note-review',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-pencil-square-o"></div><div><h4 class="modal-title">Note</h4></div>',
		//'size' => 'modal-lg',
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
			]
	]);
	Modal::end();

	/*SIGN AUTHOR1*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#ro-auth1-sign').on('show.bs.modal', function (event) {
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
			'id' => 'ro-auth1-sign',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*SIGN AUTHOR2*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#ro-auth2-sign').on('show.bs.modal', function (event) {
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
			'id' => 'ro-auth2-sign',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*SIGN AUTHOR3*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#ro-auth3-sign').on('show.bs.modal', function (event) {
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
			'id' => 'ro-auth3-sign',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*
	 * Button Modal Confirm Popup
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#confirm-permission-alert').on('show.bs.modal', function (event) {
				//var button = $(event.relatedTarget)
				//var modal = $(this)
				//var title = button.data('title')
				//var href = button.attr('href')
				//modal.find('.modal-title').html(title)
				//modal.find('.modal-body').html('')
				/* $.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)
					}); */
				}),
	",$this::POS_READY);
	Modal::begin([
			'id' => 'confirm-permission-alert',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/warning/denied.png',  ['class' => 'pnjg', 'style'=>'width:40px;height:40px;']).'</div><div style="margin-top:10px;"><h4><b>Permmission Confirm !</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
			]
		]);
		echo "<div>You do not have permission for this module.
				<dl>
					<dt>Contact : itdept@lukison.com</dt>
				</dl>
			</div>";
	Modal::end();
?>
