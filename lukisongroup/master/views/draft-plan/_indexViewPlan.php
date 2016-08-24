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
		var title = prompt('Event Title:');
		var eventData;
		var dateTime1 = new Date(start);
		var dateTime2 = new Date(end);
		tgl1 = moment(dateTime1).format("YYYY-MM-DD HH:mm:ss");
		tgl2 = moment(dateTime2).format("YYYY-MM-DD HH:mm:ss");
		if (title) {
			$.ajax({
				url:'/sistem/personalia/jsoncalendar_add',
				type: 'POST',
				data:'title=' + title + '&start='+ tgl1 + '&end=' + tgl2,
				dataType:'json',
				success: function(result){
			//alert('ok')
				  $.pjax.reload({container:'#calendar-user'});
				  //$.pjax.reload({container:'#gv-schedule-id'});
				}
			});
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
		}

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
		//alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		//alert('View: ' + view.name);
		// change the border color just for fun
		$(this).css('border-color', 'red');
	}
EOF;


	/*
	 * VIEW SCHEDULE PLAN 
	 * @author ptrnov  [ptr.nov@gmail.com]
	 * @since 1.2
	*/
	$calenderPlan=yii2fullcalendar\yii2fullcalendar::widget([
		'id'=>'scdl-plan',
		'options' => [
			'lang' => 'id',
			//'firstDay' => ['default' => '6'],
		//... more options to be defined here!
		],
		// 'events'=> $events,
		'ajaxEvents' => Url::to(['/master/draft-plan/jsoncalendar-plan']),
		'clientOptions' => [
			'selectable' => true,
			'selectHelper' => true,
			'droppable' => true,
			'editable' => true,
			'firstDay' =>'0',
			//'drop' => new JsExpression($JSDropEvent),
			'selectHelper'=>true,
			//'select' => new JsExpression($JSCode),
			'eventClick' => new JsExpression($JSEventClick),
			//'defaultDate' => date('Y-m-d')
		],
		//'ajaxEvents' => Url::toRoute(['/site/jsoncalendar'])
	]);
	
	$btn_exportPlan = Html::a('<i class="fa fa-file-excel-o"></i> Export Excel',
							'/master/draft-plan/export-modal?flag=1',
							[		
								'data-toggle'=>"modal",		
								'data-target'=>"#modal-export-plan",		
								'class' => 'btn btn-info btn-sm'		
						   ]
						);
	
	
	
	
	
	$vwScdlPlan= Html::panel(
					['heading' => $btn_exportPlan, 'body' =>$calenderPlan],
					Html::TYPE_DANGER
				);
	$viewDetailPlan= Html::panel(
					['heading' => 'DETAIl GROUP PLAN', 'body' =>''],
					Html::TYPE_DANGER
				);	
?>
<div class="row">
	<div class="col-sm-8 col-md-8 col-lg-8">
		<?=$vwScdlPlan?>
	</div>
	<div class="col-sm-4 col-md-4 col-lg-4">
		<?=$viewDetailPlan?>
	</div>
</div>

<?php		
 $this->registerJs("		
          $.fn.modal.Constructor.prototype.enforceFocus = function(){};		
          $('#modal-export-plan').on('show.bs.modal', function (event) {		
             var button = $(event.relatedTarget)		
             var modal = $(this)		
             var title = button.data('title')		
             var href = button.attr('href')		
             //modal.find('.modal-title').html(title)		
             modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')		
             $.post(href)		
                 .done(function( data ) {		
                     modal.find('.modal-body').html(data)		
                 });		
             })		
     ",$this::POS_READY);		
     Modal::begin([		
         'id' => 'modal-export-plan',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-file-excel-o"></div><div><h4 class="modal-title"> SCHEDULE PLAN</h4></div>',	
		 'size' => Modal::SIZE_SMALL,	
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
     Modal::end();
?>