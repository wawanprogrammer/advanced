<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
use lukisongroup\assets\AppAssetDahboardDatamaster;
AppAssetDahboardDatamaster::register($this);

//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'PT. Lukisongroup';                                   	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_personalia';                                       	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'HRM - Personalia Dashboard');             		/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                          	/* belum di gunakan karena sudah ada list sidemenu, on plan next*/

				
?>


<div id="dasboard-item" ng-app="ChartAllDashboardHrmPersonalia" ng-controller="CtrlChart" class="row" style="height:1100px"  >
 
	<div class="col-md-12" style="padding-left:15px; padding-right:15px;">
		<div class="row">
		
			<div class="col-lg-3 col-md-6">
				<!-- Employe Aktif!-->
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-group fa-2x"></i>
							</div>							
							<div class="col-xs-9 text-right">
								<!-- <div class="huge"  ng-repeat="nilai in Employe_Summary">{{nilai.emp_total}}</div> !-->
								<?php echo $cntAktifEmp!=''? $cntAktifEmp:'0';; ?> 								
								<div>Total Employee</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Employe Probation!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-file-photo-o fa-2x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<!--<div class="huge" ng-repeat="nilai in Employe_Summary">{{nilai.emp_probation}}</div>!-->
								<?php echo $cntProbaEmp!=''? $cntProbaEmp :'0'; ?> 
								<div>Probation</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Employee Kontrak!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-shopping-cart fa-2x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<?php echo $cntContrak!=''? $cntContrak :'0'; ?> 							
								<!--<div class="huge" ng-repeat="nilai in Employe_Summary">{{nilai.emp_contract}}</div>!-->
								<div>Contract</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Employee Tetap!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-support fa-2x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<?php echo $cntTetapEmp!=''? $cntTetapEmp :'0'; ?> 								
								<!--<div class="huge" ng-repeat="nilai in Employe_Summary">{{nilai.emp_tetap}}</div>!-->
								<div>Tetap</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Employee Support!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-blue1">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-support fa-2x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<?php echo $cntSptEmp!=''? $cntSptEmp :'0'; ?> 								
								<!--<div class="huge" ng-repeat="nilai in Employe_Summary">{{nilai.emp_tetap}}</div>!-->
								<div>Seqment Support</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Employee Bisnis!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-support fa-2x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<?php echo $cntBisnisEmp!=''? $cntBisnisEmp :'0'; ?> 								
								<!--<div class="huge" ng-repeat="nilai in Employe_Summary">{{nilai.emp_tetap}}</div>!-->
								<div>Seqment Bisnis</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Employee gender!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-support fa-2x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<?php echo ($cntGenderMEmp!=''? $cntGenderMEmp  :0) .' |   ' .  ($cntGenderFEmp!=''? $cntGenderFEmp:0); ?> 								
								<!--<div class="huge" ng-repeat="nilai in Employe_Summary">{{nilai.emp_tetap}}</div>!-->
								<div>Gender Male | Female</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<!-- Employee Resign!-->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-red">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-support fa-2x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<?php echo $cntResignEmp!=''? $cntResignEmp :'0'; ?> 								
								<!--<div class="huge" ng-repeat="nilai in Employe_Summary">{{nilai.emp_tetap}}</div>!-->
								<div>Resign</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>			
		</div>
	</div>
	<div class="col-md-12" style="padding-left:25px; padding-right:20px">
		<div class="row">
			<!-- Chart Line Sektor Support !-->
			<!--<div class="col-sm-6"  ng-init="load()">	!-->
			<div class="col-sm-6" >			
<!--
			 {{7+7}}
						 
			{{attrs_support}}			
			{{catg_support}}
			{{dataset_support}} 
				!-->
				<fusioncharts
					width= 100%,
					type="msline",
					chart='{{support_attrs}}',
					categories='{{support_catg}}',
					dataset='{{support_dataset}}'
				>
				</fusioncharts>			   
			</div>
			<!-- Chart Line Sektor Bisnis !-->
			<div class="col-sm-6">				
				<fusioncharts
					width= 100%
					type="msline"
					chart="{{bisnis_attrs}}"
					categories="{{bisnis_catg}}"
					dataset="{{bisnis_dataset}}"
				>
				</fusioncharts>					   
			</div>

		</div>
    </div>
	<div class="col-md-12" style="padding-left:25px; padding-right:20px">
		<div class="row">
			<!--Chart Type Pie PT.Sarana Sinar Surya !-->
			<div class="col-sm-4">
				<fusioncharts 
					width="400" 
					height="300"
					type="pie3d",
					datasource="{{sss_pie_myDatasource}}"
				></fusioncharts>			
			</div>
			<!--Chart Type Pie PT.Arhta Lipat Ganda !-->
			<div class="col-sm-4">
				<fusioncharts 
					width="400" 
					height="300"
					type="pie3d",
					datasource="{{lipat_pie_myDatasource}}"
				></fusioncharts>			
			</div>
			<!--Chart Type Pie PT.Effembi Sukses Makmur !-->
			<div class="col-sm-4">
				<fusioncharts 
					width="400" 
					height="300"
					type="pie3d",
					datasource="{{esm_pie_myDatasource}}"
				></fusioncharts>			
			</div>
		</div>
	</div>
</div>	
	
	
	
				