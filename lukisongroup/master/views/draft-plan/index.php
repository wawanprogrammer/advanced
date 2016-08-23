<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\DraftPlan;
Use ptrnov\salesforce\Jadwal;
use kartik\tabs\TabsX;
use yii\widget\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\DraftPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Produk');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;   

	$newDraftPlan=$this->render('_indexDraftPlan',[
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
		'valStt'=>$valStt,
		'pekan'=>$pekan,
		'layer'=>$layer,
		'drop'=>$drop,
		'dropcus'=>$dropcus
	]);
	$MaintainPlan=$this->render('_indexMaintainPlan',[
		'searchModelMaintain' =>$searchModelMaintain,
		'dataProviderMaintain' =>$dataProviderMaintain,
		'dropcus'=>$dropcus,
		'valStt'=>$valStt,
		'pekan'=>$pekan,
		'layer_nm'=>$layer_nm,
		'scdl_group'=>$scdl_group

	]);
	$groupIndex=$this->render('_indexGroup',[
		'searchModelGrp'=>$searchModelGrp,
		'dataProviderGrp'=>$dataProviderGrp,
		'searchModelUser'=>$searchModelUser,
		'dataProviderUser'=>$dataProviderUser,
		'drop'=>$drop,
		'SCL_NM'=>$SCL_NM,
		'Stt'=>$Stt,
		'pekan'=>$pekan,
		'user'=>$user
	]);
	$vwSchedulePlan=$this->render('_indexViewPlan');
	$vwScheduleActual=$this->render('_indexViewActual');
		
	if($tab==0){
		$tab0=true;
		$tab1=false;
		$tab2=false;
		$tab3=false;
		$tab4=false;
	}elseif($tab==1){
		$tab0=false;
		$tab1=true;
		$tab2=false;
		$tab3=false;
		$tab4=false;
	}elseif($tab==2){
		$tab0=false;
		$tab1=false;
		$tab2=true;
		$tab3=false;
		$tab4=false;
	}elseif($tab==3){
		$tab0=false;
		$tab1=false;
		$tab2=false;
		$tab3=true;
		$tab4=false;
	}elseif($tab==4){
		$tab0=false;
		$tab1=false;
		$tab2=false;
		$tab3=false;
		$tab4=true;
	}
	
	$items=[
		[
			'label'=>'<i class="fa fa-wrench fa-2x"></i> Plan Draft','content'=>$newDraftPlan,
			'active'=>$tab0,
		],
		[
			'label'=>'<i class="fa fa-braille fa-2x"></i> Plan Detail Maintain','content'=>$MaintainPlan,
			'active'=>$tab1,
		],		
		[
			'label'=>'<i class="fa fa-calendar-minus-o fa-2x"></i>  Schedule-Plan','content'=>$vwSchedulePlan,
			'active'=>$tab2,
		],
		[
			'label'=>'<i class="fa fa-calendar-plus-o fa-2x"></i>  Schedule-Actual','content'=>$vwScheduleActual,
			'active'=>$tab3,
		],
		[
			'label'=>'<i class="fa fa-key	 fa-2x"></i> Group Setting','content'=>$groupIndex,
			'active'=>$tab4,
		],
	];

	$tabSchedulingSales= TabsX::widget([
		'id'=>'sales-plan-scdl',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'bordered'=>true,
		'encodeLabels'=>false,
		'pluginEvents' => [
				"tabsX.click" => 'function() { 
							var aryidx = [];
								
							setTimeout(function() {								
								/*
								* find array by ptrnov
								* @author ptr.nov [ptr.nov@gmail.com]
								*/
								function isInArray(findValue) {
									//Tab load by js
									if((window.location.href).indexOf("?") != -1) {
										var queryString = (window.location.href).substr((window.location.href).indexOf("?") + 1); 
										aryidx = (queryString.split("="))[1];
									}
									//add Tab normal
									array1=[8,9,10];
									ary = array1.concat(aryidx);
									//alert(ary);
									for(var i=0; i<ary.length; i++) {
										if (ary[i] == findValue) return true;
									}
									
								};
								
								/*
								* GET Eelemet ul li 
								* @author ptr.nov [ptr.nov@gmail.com]
								*/
								var idx = $("ul li.active").index();
								if(isInArray(idx) != true){
									//alert(isInArray(idx));
									//set URL by ?tab=idx
									document.location.href = "/master/draft-plan?tab="+idx;
								};
							}, 1);							
				 }'				 
		]
	]);	
		
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div  class="col-lg-12" >
		<div class="row">
		<?=$tabSchedulingSales?>
		</div>
	</div>
</div>


