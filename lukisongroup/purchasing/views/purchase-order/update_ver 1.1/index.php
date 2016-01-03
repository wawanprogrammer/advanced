<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
//use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
//use yii\bootstrap\Modal;
//use yii\helpers\Json;
use kartik\form\ActiveForm;
use lukisongroup\master\models\Suplier;
use lukisongroup\hrd\models\Employe;

$this->title = 'Purchaseorder';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
function submitform()
{
  document.myform.submit();
}
</script>
<?php
	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[3=PO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(3)){
			return Yii::$app->getUserOpt->Modul_akses(3)->mdlpermission;
		}else{		
			return false;
		}	 
	}
	
	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[3=PO]
	*/
	function getPermissionEmployee(){
		if (Yii::$app->getUserOpt->Modul_akses(3)){
			return Yii::$app->getUserOpt->Modul_akses(3)->emp;
		}else{		
			return false;
		}	 
	}
	
	
	/*
	 * Tombol Modul Create
	 * permission crate PO
	*/
	function tombolCreate(){
		if(getPermission()){
			if(getPermission()->BTN_CREATE==1){
				$title1 = Yii::t('app', 'NEW PO');
				$options1 = [ 'id'=>'po-create',	
							  'data-toggle'=>"modal",
							  'data-target'=>"#new-po",											
							  'class' => 'btn btn-warning btn-sm',
				]; 
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
				return $content;								
			 }else{
				$title1 = Yii::t('app', 'CREATE NEW PO');
				$options1 = [ 'id'=>'po-create',						  									
							  'class' => 'btn btn-warning btn-sm',										  
							  'data-confirm'=>'Permission Failed !',
				]; 
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1, $options1);
				return $content;
			}; 
		}else{
				$title1 = Yii::t('app', 'CREATE NEW PO');
				$options1 = [ 'id'=>'ro-create',						  									
							  'class' => 'btn btn-warning btn-sm',										  
							  'data-confirm'=>'Permission Failed !',
				]; 
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$content = Html::button($label1,$options1);
				return $content;
		}	 		
	}
	
	/*
	 * Tombol Modul Barang-Umum
	 * No Permission
	*/
	function tombolBarangUmum(){
		$title = Yii::t('app', 'Barang Umum');
		$options = ['id'=>'barang-umum',	
					'data-toggle'=>"modal",
					'data-target'=>"#check-barang-umum",							
					'class' => 'btn btn-default btn-sm'
		]; 
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
		$content = Html::a($label,$url, $options);
		return $content;	
	}
	
	/*
	 * Tombol Modul Barang-Prodak
	 * No Permission
	*/
	function tombolBarangProdak(){
		$title = Yii::t('app', 'Barang Prodak');
		$options = ['id'=>'barang-prodak',	
					'data-toggle'=>"modal",
					'data-target'=>"#check-barang-prodak",							
					'class' => 'btn btn-default btn-sm'
		]; 
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
		$content = Html::a($label,$url, $options);
		return $content;	
	}
	
	/*
	 * Tombol Modul Supplier
	 * No Permission
	*/
	function tombolBarangSupplier(){
		$title = Yii::t('app', 'Supplier');
		$options = ['id'=>'po-spl',	
					'data-toggle'=>"modal",
					'data-target'=>"#po-spl",							
					'class' => 'btn btn-default btn-sm'
		]; 
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
		$content = Html::a($label,$url, $options);
		return $content;	
	}
	/*
	 * Tombol Modul Customer
	 * No Permission
	*/
	function tombolBarangCustomer(){
		$title = Yii::t('app', 'Customer');
		$options = ['id'=>'po-customer',	
					'data-toggle'=>"modal",
					'data-target'=>"#po-customer",							
					'class' => 'btn btn-default btn-sm'
		]; 
		$icon = '<span class="glyphicon glyphicon-search"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['#']);
		$content = Html::a($label,$url, $options);
		return $content;	
	}
	
	
	/*
	 * Tombol Modul View
	 * permission View [BTN_VIEW==1]
	 * Check By User login
	*/
	function tombolView($url, $model){
		if(getPermission()){	
			if(getPermission()->BTN_VIEW==1){
				$title = Yii::t('app', 'View');
				$options = [ 'id'=>'ro-view']; 
				$icon = '<span class="glyphicon glyphicon-zoom-in"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/purchase-order/view','kd'=>$model->KD_PO]);
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;	
			}
		}
	} 

	/*
	 * Tombol Modul Edit -> Check By User login
	 * Permission Edit [BTN_VIEW==1] & [Status 0=process 101=Approved]
	 * EMP_ID=UserLogin & BTN_EDIT==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_EDIT==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login yang bisa melakukan Edit Request Order yang sudah di Create user tersebut (Tanpa Kecuali)
	 * 2. Action EDIT Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
	*/
	function tombolEdit($url, $model){
		if(getPermission()){								
			if(getPermissionEmployee()->EMP_ID == $model->CREATE_BY AND getPermission()->BTN_EDIT==1){
				 if($model->STATUS == 0){ // 0=process 101=Approved
					$title = Yii::t('app', 'Edit Detail');
					$options = [ //'id'=>'ro-edit',
								//'data-toggle'=>"modal",
								//'data-target'=>"#add-ro",
								//'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
					]; 
					$icon = '<span class="fa fa-pencil-square-o fa-lg"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/purchase-order/edit','kd'=>$model->KD_PO]);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL; 
				}
			}
		}						
	}

	/*
	 * Tombol Modul Delete -> Check By User login
	 * Permission Edit [BTN_DELETE==1] & [Status 0=process 101=Approved]
	 * EMP_ID=UserLogin & BTN_DELETE==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_DELETE==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login yang bisa melakukan DELETE Request Order yang sudah di Create user tersebut (Tanpa Kecuali)
	 * 2. Action DELETE  Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
	*/
	function tombolDelete($url, $model){
		if(getPermission()){
			if(getPermissionEmployee()->EMP_ID == $model->CREATE_BY AND getPermission()->BTN_DELETE==1){
				if($model->STATUS == 0){ // 0=process 101=Approved
					$title = Yii::t('app', 'Delete');
					$options = [ 'id'=>'ro-delete',															
								'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
					]; 
					$icon = '<span class="fa fa-trash-o fa-lg"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/purchase-order/hapusro','kd'=>$model->KD_PO]);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
				}
			}
		}	
	}	

	/*
	 * Tombol Modul Approval -> Check By User login
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 101=Approved]
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login dengan permission modul RO=1 dengan BTN_SIGN1==1 dan Permission Jabatan SVP keatas yang bisa melakukan Approval (Tanpa Kecuali)
	 * 2. Action APPROVAL Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
	*/
	function tombolApproval($url, $model){
		if(getPermission()){
			//Permission Jabatan
			$a=getPermissionEmployee()->JOBGRADE_ID;
			$b=getPermission()->BTN_SIGN1;
			//if(getPermissionEmployee()->JOBGRADE_ID == 'S' OR getPermissionEmployee()->JOBGRADE_ID == 'M' OR getPermissionEmployee()->JOBGRADE_ID == 'SM' AND getPermission()->BTN_SIGN1==1 ){
			if($a == 'SEVP' OR $a == 'EVP' OR $a == 'SVP' OR $a == 'VP' OR $a == 'AVP' OR $a == 'SM' OR $a == 'M' OR $a == 'AM' OR $a == 'S' AND $b==1 ){
				 if($model->STATUS == 0 || $model->STATUS == 1 ){ // 0=process 101=Approved
					$title = Yii::t('app', 'approved');
					$options = [ //'id'=>'ro-approved',
								//'data-method' => 'post',
								 //'data-pjax'=>true,
								 //'data'=>$model->KD_PO,
								 //'data-pjax' => '0',
								 //'data-toggle-active' => $model->KD_PO
								//'data-confirm'=>'Anda yakin ingin menghapus RO ini?',
					]; 
					$icon = '<span class="glyphicon glyphicon-ok"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/purchasing/purchase-order/approved','kd'=>$model->KD_PO]);
					//$url = Url::toRoute(['/purchasing/purchase-order/approved']);
					//$url = Url::toRoute(['/purchasing/purchase-order/approved']);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, $url , $options) . '</li>' . PHP_EOL;
				}
			}
		}	
	}

	/*
	 * STATUS Prosess Request Order
	 * 1. PROCESS	=0 		| Pertama RO di buat
	 * 2. PENDING	=1		| Ro Tertunda
	 * 3. APPROVED	=101	| Ro Sudah Di Approved
	 * 4. COMPLETED	=10		| Ro Sudah selesai | RO->PO->RCVD
	 * 5. DELETE	=3 		| Ro Di hapus oleh pembuat petama, jika belum di Approved
	 * 6. REJECT	=4		| Ro tidak di setujui oleh Atasan manager keatas
	 * 7. UNKNOWN	<>		| Ro tidak valid
	*/
	function statusProcessPo($model){
		if($model->STATUS==0){
			return Html::a('<i class="glyphicon glyphicon-retweet"></i> PROCESS', '#',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif ($model->STATUS==1){
			return Html::a('<i class="glyphicon glyphicon-time"></i> PENDING', '#',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==101){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> APPROVED', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==10){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> COMPLETED', '#',['class'=>'btn btn-info btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==3){
			return Html::a('<i class="glyphicon glyphicon-remove"></i> DELETE', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);						
		}elseif ($model->STATUS==4){
			return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}else{
			return Html::a('<i class="glyphicon glyphicon-question-sign"></i> UNKNOWN', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);	
		};		
	}
	
    $idEmp = Yii::$app->user->identity->EMP_ID;
    $emp = Employe::find()->where(['EMP_ID'=>$idEmp])->one();
    $kr = $emp->DEP_SUB_ID;

?>



<script type="text/javascript">
function submitform()
{
  document.myform.submit();
}
</script>

<?php
	$gridColumns = [
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			], 		
		],		
		[
			'attribute'=>'KD_PO',
			'label'=>'Kode PO',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'130px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'130px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			], 		
		],
		[
			'attribute'=>'CREATE_AT',
			'label'=>'DateTime',
			'hAlign'=>'left',			
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
				return substr($model->CREATE_AT, 0, 10);
			},
			'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
						'filterWidgetOptions' =>([
							'attribute' =>'CREATE_AT',
							'presetDropdown'=>TRUE,
							'convertFormat'=>true,
							'pluginOptions'=>[
								'id'=>'tglpo',
								'format'=>'Y/m/d',
								'separator' => ' - ',
								'opens'=>'right'
							]									
			]),
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'80px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'80px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt'	
				]
			], 		
		],
		[
			'attribute'=>'namasuplier',
			'label'=>'Supplier',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/				
				if (strlen($model->namasuplier) <=26){
					return substr($model->namasuplier, 0, 26);
				}else{
					return substr($model->namasuplier, 0, 24). '..';
				}
			},
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'190px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'190px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			], 		
		],
        [
			'attribute'=>'SIG1_NM',
			'label'=>'Created By',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
				if (strlen($model->SIG1_NM) <=16){
					return substr($model->SIG1_NM, 0, 16);
				}else{
					return substr($model->SIG1_NM, 0, 14). '..';
				}
			},
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'125px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'125px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt'					
				],
				
			], 		
		],
		[
			'attribute'=>'SIG2_NM',
			'label'=>'Sumbition By',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
				if (strlen($model->SIG2_NM) <=16){
					return substr($model->SIG2_NM, 0, 16);
				}else{
					return substr($model->SIG2_NM, 0, 14). '..';
				}
			},
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'125px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'125px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			], 		
		],
		[
			'attribute'=>'SIG3_NM',
			'label'=>'Approved By',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			'value'=>function($model){
				/*
				 * max String Disply
				 * @author ptrnov <piter@lukison.com>
				*/
				if (strlen($model->SIG3_NM) <=16){
					return substr($model->SIG3_NM, 0, 16);
				}else{
					return substr($model->SIG3_NM, 0, 14). '..';
				}
			},
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'125px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'125px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			], 		
		],
		[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{view}{tambahEdit}{delete}{approved}',
			'dropdownOptions'=>['class'=>'pull-right dropup'],									
			'buttons' => [
				/* View RO | Permissian All */
				'view' => function ($url, $model) {
								return tombolView($url, $model);
						  },
						
				/* View RO | Permissian Status 0; 0=process | User created = user login  */
				'tambahEdit' => function ($url, $model) {
								return tombolEdit($url, $model);
							},										
				
				/* Delete RO | Permissian Status 0; 0=process | User created = user login */
				'delete' => function ($url, $model) {
								return tombolDelete($url, $model);
							},
				
				/* Approved RO | Permissian Status 0; 0=process | Dept = Dept login | GF >= M */
				'approved' => function ($url, $model) {
								return tombolApproval($url, $model);
							},
			],
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'150px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'9pt',
				]
			], 			
		],
		[
			'label'=>'Notification',
			'mergeHeader'=>true,
			'format' => 'raw',						
			'hAlign'=>'center',
			'value' => function ($model) {
							return statusProcessPo($model);
			},
			'headerOptions'=>[				
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'9pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],			
		], 		
		
        /* ['class' => 'yii\grid\ActionColumn',
		'template' => '{link} {edit}',
		'buttons' => [
			'link' => function ($url,$model) { return Html::a('', ['view','kd'=>$model->KD_PO],['class'=>'glyphicon glyphicon-eye-open', 'title'=>'Detail']);},

			'edit' => function ($url,$model) use ($kr) { 
				if( $kr == 'HR-02'){ 
					return Html::a('', ['create','kdpo'=>$model->KD_PO],['class'=>'glyphicon glyphicon-pencil', 'title'=>'Ubah RO']); 
				}
			} ,

			],
        ], */
		
	];

	$gridLisPo= GridView::widget([
			'id'=>'po-list',
			'dataProvider'=> $dataProvider,
			'filterModel' => $searchModel,
			'columns' => $gridColumns,
			'filterRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center'],
			'pjax'=>true,
			'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'po-list',
			   ],						  
			],
			'hover'=>true, //cursor select
			'responsive'=>true,
			'responsiveWrap'=>true,
			'bordered'=>true,
			'striped'=>'4px',
			'autoXlFormat'=>true,
			'export' => false,
			'toolbar'=> [
					['content'=>tombolCreate().tombolBarangUmum().tombolBarangProdak().tombolBarangSupplier().tombolBarangCustomer()],
					//'{export}',
					//'{toggleData}',
				],
			'panel'=>[
				//'type'=>GridView::TYPE_INFO,
				'heading'=>"<span class='fa fa-shopping-cart fa-xs'><b> LIST PURCHASE ORDER</b></span>",
			],	
		]);
		
?>
   
			
<div class="container-full">
	<div style="padding-left:15px; padding-right:15px">	
		<div>
		<?php 
			/*SHOW GRID VIEW*/
			echo $gridLisPo; 
		?>
		</div>
		
	</div>	
	<!-- Modal -->
	<div class="modal fade" id="new-po" tabindex="-1" role="dialog" aria-labelledby="create-poLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="create-poLabel">OPTION CREATE PO</h4>
			  </div>
			  
			<?php $form = ActiveForm::begin([
				'type' => ActiveForm::TYPE_HORIZONTAL,
				'method' => 'post',
				'action' => ['/purchasing/purchase-order/simpanpo'],
			]); ?>
			  <div class="modal-body">
				
			<?php $drop = ArrayHelper::map(Suplier::find()->where(['STATUS' => 1])->all(), 'KD_SUPPLIER', 'NM_SUPPLIER'); ?>
			<?= $form->field($model, 'KD_SUPPLIER')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Supplier'); ?>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" >Save changes</button>
			  </div> 
			<?php ActiveForm::end(); ?>
		</div>
	  </div>
	</div>	
  
</div>
