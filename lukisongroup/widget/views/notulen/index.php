<?php
//use yii\helpers\Html;
use kartik\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\widgets\Pjax;

$JSCode = <<<EOF
	function(start, end) {
		// var title = prompt('Event Title:');
		var eventData;
		var dateTime1 = new Date(start);
		var dateTime2 = new Date(end);
		tgl1 = moment(dateTime1).format("YYYY-MM-DD HH:mm:ss");
		tgl2 = moment(dateTime2).format("YYYY-MM-DD HH:mm:ss");
		// if (title) {
			$.fn.modal.Constructor.prototype.enforceFocus = function(){};
			$.get('/widget/notulen/create',{'start':tgl1,'end':tgl2},function(data){
						$('#modal-notulen').modal('show')
						.find('#modalContentNotulen')
						.html(data);
		});
			// $.ajax({
			// 	url:'/sistem/personalia/jsoncalendar_add',
			// 	type: 'POST',
			// 	data:'title=' + title + '&start='+ tgl1 + '&end=' + tgl2,
			// 	dataType:'json',
			// 	success: function(result){
			// //alert('ok')
			// 	  $.pjax.reload({container:'#calendar-user'});
			// 	  //$.pjax.reload({container:'#gv-schedule-id'});
			// 	}
			// });
			/* calendar.fullCalendar('renderEvent', {
					title:title,
					start:start,
					end:end
				},
				true
			); */

		   /*  eventData = {
				title: title,
				start: start,
				end: end
			};
			//$('#w0').fullCalendar('renderEvent', eventData, true);
			*/
		// }

		//$('#w0').fullCalendar('unselect');
		//$('#w0').fullCalendar('unselect');
	}
EOF;
	
$JSDropEvent = <<<EOF
	function(date) {
		alert("Dropped on " + date.format());
		if ($('#drop-remove').is(':checked')) {
			// if so, remove the element from the "Draggable Events" list
			$(this).remove();
		}
	}
EOF;
	
$JSEventClick = <<<EOF
	function(calEvent, jsEvent, view) {
		alert('Event: ' + calEvent.id);
	   // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		//alert('View: ' + view.name);
		// change the border color just for fun
		$(this).css('border-color', 'red');
	}
EOF;


?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-6 col-md-6 col-lg-6" >
			<?php 
				/*
				 * MEMO CALENDAR 
				 * PERIODE 23-22
				 * @author ptrnov  [ptr.nov@gmail.com]
				 * @since 1.2
				*/
				$calenderRt=yii2fullcalendar\yii2fullcalendar::widget([
					'id'=>'calendar-notulen',
					'options' => [
						'lang' => 'id',
						//'firstDay' => ['default' => '6'],
					//... more options to be defined here!
					],
					// 'events'=> $events,
					// 'ajaxEvents' => Url::to(['/sistem/personalia/jsoncalendar']),
					'clientOptions' => [
						'selectable' => true,
						'selectHelper' => true,
						'droppable' => true,
						'editable' => true,
						'firstDay' =>'0',
						//'drop' => new JsExpression($JSDropEvent),
						'selectHelper'=>true,
						'select' => new JsExpression($JSCode),
						// 'eventClick' => new JsExpression($JSEventClick),
						'eventClick' => new JsExpression($JSCode),
						//'defaultDate' => date('Y-m-d')
					],
					//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
				]);
				
				echo Html::panel(
					['heading' => 'NOTULEN CLENDER ', 'body' =>$calenderRt],
					Html::TYPE_DANGER
				);	
			?>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6">
			<?php			
				/*
				 * LIST MEMO CALENDAR 
				 * PERIODE 23-22
				 * @author ptrnov  [piter@lukison.com]
				 * @since 1.2
				*/
				$actionClass='btn btn-info btn-xs';
				$actionLabel='Update';
				$attDinamikNotulen =[];				
				/*GRIDVIEW ARRAY FIELD HEAD*/
				$headColomnNotulen=[
					['ID' =>0, 'ATTR' =>['FIELD'=>'start','SIZE' => '10px','label'=>'DATE START','align'=>'left','warna'=>'97, 211, 96, 0.3']],				
					['ID' =>1, 'ATTR' =>['FIELD'=>'end','SIZE' => '10px','label'=>'DATE END','align'=>'left','warna'=>'97, 211, 96, 0.3']],
					['ID' =>2, 'ATTR' =>['FIELD'=>'title','SIZE' => '10px','label'=>'TITLE','align'=>'left','warna'=>'97, 211, 96, 0.3']],
				];
				$gvHeadColomnNotulen = ArrayHelper::map($headColomnNotulen, 'ID', 'ATTR');
				/*GRIDVIEW ARRAY ACTION*/
				$attDinamikNotulen[]=[
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
								return  '<li>' .Html::a('<span class="fa fa-eye"></span>'.Yii::t('app', 'View'),
															['/widget/notulen/view','id'=>$model->id],[
															'id'=>'notulen-id',
															// 'data-toggle'=>"modal",
															// 'data-target'=>"#alias-cust",
															]). '</li>' . PHP_EOL;
						},				
					],
					'headerOptions'=>[
						'style'=>[
							'text-align'=>'center',
							'width'=>'10px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'9pt',
							'background-color'=>'rgba(97, 211, 96, 0.3)',
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
				foreach($gvHeadColomnNotulen as $key =>$value[]){
					$attDinamikNotulen[]=[		
						'attribute'=>$value[$key]['FIELD'],
						'label'=>$value[$key]['label'],
						'filter'=>true,
						'hAlign'=>'right',
						'vAlign'=>'middle',
						//'mergeHeader'=>true,
						'noWrap'=>true,			
						'headerOptions'=>[		
								'style'=>[									
								'text-align'=>'center',
								'width'=>$value[$key]['FIELD'],
								'font-family'=>'tahoma, arial, sans-serif',
								'font-size'=>'8pt',
								//'background-color'=>'rgba(97, 211, 96, 0.3)',
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
									'width'=>'12px',
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
					'dataProvider' => $dataProviderNotulen,
					'filterModel' => $searchModelNotulen,
					'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
					'columns' => $attDinamikNotulen,
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
							'id'=>'absen-rekap',
						],
					],
					'panel' => [
								'heading'=>'<h3 class="panel-title">LIST NOTULEN</h3>',
								'type'=>'warning',
								'showFooter'=>false,
					],
					'toolbar'=> [
						//'{items}',
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>true,
				]); 		
			?>
		</div>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<?php
			
				// print_r($dataProviderNotulen);
			?>
		</div>
	</div>
</div>
<?php
// $this->registerJs("
// $('#calendar-notulen').fullCalendar({
                      
//             firstDay: 6,
// 			editable: true,
//  });
//  ",$this::POS_HEAD);


/*modal*/
Modal::begin([
    'id' => 'modal-notulen',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
	echo "<div id='modalContentNotulen'></div>";
	Modal::end(); 
 ?>