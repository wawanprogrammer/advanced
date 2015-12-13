<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use kartik\builder\FormGrid;
use kartik\tabs\TabsX;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'options'=>['enctype'=>'multipart/form-data']]);
$ProfAttribute1 = [
    [
        'label'=>'',
        'attribute' =>'EMP_IMG',
        'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
        //'group'=>true ,
        //'groupOptions'=>[
        //	'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
        //],
        'format'=>['image',['width'=>'auto','height'=>'auto']],
        //'inputWidth'=>'20%'
        //'inputContainer' => ['class'=>'col-md-1'],
    ],
];
$this->title = 'Workbench <i class="fa  fa fa-coffee"></i> ' . $model->EMP_NM . ' ' . $model->EMP_NM_BLK .'</a>';
$prof=$this->render('login_index/_info', [
    'model' => $model,
	'dataProvider' => $dataProvider,
]);
$EmpDashboard=$this->render('login_index/_dashboard', [
    'model' => $model,
]);
?>

<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
					<?php
					echo Html::panel(
						[
							'heading' => '<div>Employee Dashboard</div>',
							'body'=>$prof,
						],
						Html::TYPE_DANGER
					);
					?>
			</div>
		</div>
       <div class="row" >
			<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4">
				<?php
					echo Html::panel([
							'id'=>'home1',
							'heading' => '<b>WIDGET</b>',
							'postBody' => Html::listGroup([
									[
										'content' => 'Berita Acara ',
										'url' => '/widget/berita',
										'badge' => '14'
									],
									[
										'content' => 'Chating ',
										'url' => '/widget/chat',
										'badge' => '14'
									],
									[
										'content' => 'Memo',
										'url' => '/widget/memo',
										'badge' => '2'
									],
									[
										'content' => 'Notulen',
										'url' => '/widget/notulen',
										'badge' => '2'
									],
									[
										'content' => 'email',
										'url' => '/email/mail-box',
										'badge' => '2'
									],	
									[
										'content' => 'Profile',
										'url' => '/sistem/user-profile',
										
									],										

								]),
						],
						Html::TYPE_DANGER
					);
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4" >
				
				<?php
					echo Html::panel([
							'id'=>'home1',
							'heading' => '<b>TASK MANAGE </b>',
							'postBody' => Html::listGroup([
									[
										'content' => 'Pilot Project',
										'url' => '/widget/pilotproject',
										'badge' => '2'
									],	
									[
										'content' => 'Daily Jobs',
										'url' => '/widget/jobsdaily',
										'badge' => '14'
									],									
									[
										'content' => 'Head Jobs ',
										'url' => '/widget/headjob',
										'badge' => '14'
									],									
									[
										'content' => 'Additional Jobs',
										'url' => '/widget/addjob',
										'badge' => '2'
									],
									[
										'content' => 'Arsip File',
										'url' => '/widget/arsip',
										'badge' => '2'
									],
									[
										'content' => 'Documentation',
										'url' => '/widget/docdba',
										'badge' => '2'
									],									

								]),
						],
						Html::TYPE_DANGER
					);
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-dm-4  col-lg-4" >
			<?php
					echo Html::panel([
							'id'=>'home1',
							'heading' => '<b>REQUEST AND APPROVAL</b>',
							'postBody' => Html::listGroup([
									[
										'content' => 'Administration ',
										'url' => '/hrd/administrasi'
									],
									[
										'content' => 'Request Order',
										'url' => '/purchasing/request-order',
										'badge' => '1'
									],	
									[
										'content' => 'Sales Order',
										'url' => '/sales/sales-order',
										'badge' => '14'
									],											
									[
										'content' => 'Purchase Order',
										'url' => '/purchasing/purchase-order',
										'badge' => '2'
									],
									[
										'content' => 'Reimburse',
										'url' => '/widget/inv',
										'badge' => '2'
									],
									[
										'content' => 'SPJD',
										'url' => '/widget/sj',
										'badge' => '2'
									],
								]),
						],
						Html::TYPE_DANGER
					);
				?>
				
			</div>
		</div>
		<div class="row" >
			<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12" >
				<div class="pre-scrollable alert alert-info" style="height:75px">				  
				  <strong>Info ! </strong> Let's try to use ERP (Enterprise resource planning), hopefully this can !, remember, simplify, speed up and tidying your work.
					Erp first launched with ver 0.1, probably still a lot of homework, but we've tried to set the foundation for the next update. We need feedback for the next version
				</div>
				<?php
			
				
				/* $items=[
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i>Jobsdesk','content'=>'asdasdasd',
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i>Master Plan','content'=>'asdasdsad',
						//'active'=>true,

					],

					[
						'label'=>'<i class="glyphicon glyphicon-home"></i>Attendance','content'=>'asdasdasd',
					],
					[
						'label'=>'<i class="glyphicon glyphicon-home"></i>Mutation','content'=>'asdasdasd',                ],

					[
						'label'=>'<i class="glyphicon glyphicon-home"></i>Regulations','content'=>'asdasdsadasd',
					],


				];

				echo TabsX::widget([
					'items'=>$items,
					'position'=>TabsX::POS_ABOVE,
					//'height'=>'tab-height-xs',
					'bordered'=>true,
					'encodeLabels'=>false,
					//'align'=>TabsX::ALIGN_LEFT,

				]); */
				?>
				
			</div>
			</div>
			<div class="row" style="padding-top:20px" >
				<?php                       
					/* echo Html::panel(
						[
							'heading' => '<div></div>',
							'body'=>$EmpDashboard,
						],
						Html::TYPE_INFO
					); */
				?>
				
			</div>
		

 </div>

   <!-- <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>!-->
    </body>
    </html>
<?php ActiveForm::end(); ?>