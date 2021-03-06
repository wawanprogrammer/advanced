<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\DraftPlan;
Use ptrnov\salesforce\Jadwal;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\DraftPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Produk');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;   

?>
<div class="draft-plan-index">



<?php
         $data_draft = DraftPlan::find()->all();
        $dynamick =  new DraftPlan();

    //     /*converting obejct to array*/
        $data = ArrayHelper::toArray($data_draft, [
        'lukisongroup\master\models\DraftPlan' => [
            'ID' => function ($dynamick) {
                return $dynamick->IdDinamikScdl;
            },
            'GEO_ID',
            'LAYER_ID',
            'DAY_ID',
            'DAY_VALUE'
        ],
    ]);

        foreach ($data as $value) {
          # code...
          // echo $value['ID'];
            $dua[] = Jadwal::getArrayDateCust('2016','C','1','1','',$value['ID'],'66');
            
        }

      

    
        // print_r($dynamick->IdDinamikScdl);
        // die();
 
            // print_r($dua);
            // die();
 // $dua= DraftPlan::getDateVal();
 // print_r($dua);
 // die();
  

 // print_r(\ptrnov\salesforce\Jadwal::getDateOfWeekAndDayname('2016','34','1'));
 // die();
/*
 * GRID draft_plan
 * @author wawan  [aditiya@lukison.com]
 * @since 1.2
*/

$actionClass='btn btn-info btn-xs';
$actionLabel='Update';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomnBT=[
	['ID' =>0, 'ATTR' =>['FIELD'=>'IdDinamikScdl','SIZE' => '10px','label'=>'ID','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>true]],
	['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '10px','label'=>'Customers.id','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>2, 'ATTR' =>['FIELD'=>'custgeo.GEO_NM','SIZE' => '10px','label'=>'Geo','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>3, 'ATTR' =>['FIELD'=>'custlayer.LAYER_NM','SIZE' => '10px','label'=>'Layer','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>4, 'ATTR' =>['FIELD'=>'DayNm','SIZE' => '10px','label'=>'Name Of Day','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>5, 'ATTR' =>['FIELD'=>'DAY_ID','SIZE' => '10px','label'=>'Day','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>6, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'Status','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
];
$gvHeadColomnBT = ArrayHelper::map($headColomnBT, 'ID', 'ATTR');


$attDinamik[] =[
  'class'=>'kartik\grid\SerialColumn',
  //'contentOptions'=>['class'=>'kartik-sheet-style'],
  'width'=>'10px',
  'header'=>'No.',
  'headerOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'10px',
      'font-family'=>'verdana, arial, sans-serif',
      'font-size'=>'9pt',
      'background-color'=>'rgba(73, 162, 182, 1)',
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
];


/*GRIDVIEW ARRAY ROWS*/
foreach($gvHeadColomnBT as $key =>$value[]){
  if($value[$key]['FIELD'] == 'STATUS')
  {
    $attDinamik[]=[
		'attribute'=>$value[$key]['FIELD'],
		'label'=>$value[$key]['label'],
		'filterType'=>GridView::FILTER_SELECT2,
		'filter' => $valStt,
		'filterWidgetOptions'=>[
		  'pluginOptions'=>['allowClear'=>true],
		],
		'filterInputOptions'=>['placeholder'=>'Pilih'],
		 'format' => 'raw',
		'value'=>function($model){
				   if ($model->STATUS == 1) {
						return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
					} else if ($model->STATUS == 0) {
						return Html::a('<i class="fa fa-close"></i> &nbsp;DRAFT', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
					}
				},
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>$value[$key]['SIZE'],
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba('.$value[$key]['warna'].')',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>$value[$key]['align'],
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
		'width'=>'8px',
    ];
  }elseif($value[$key]['FIELD'] == 'DAY_ID'){
      # code...
      $attDinamik[]=[
        'attribute'=>$value[$key]['FIELD'],
        'label'=>$value[$key]['label'],
        'filter'=>true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'format' =>'raw',
        'value'=>function($model){
            //$label = $model->DAY_ID != ''?$model->DAY_ID:'Day';
			if (!$model->GEO_ID OR !$model->LAYER_ID){
				$label = 'Data Not Compelte';
				return	$label;			
			}else{
				$label = 'SETUP SCHEDULE';
				return Html::a(Yii::t('app',$label,['modelClass' => 'DayName',]), 
								['day','id'=>$model->CUST_KD],
								['data-toggle'=>"modal",
								'data-target'=>"#modal-day",
								'class' => 'btn btn-default btn-xs',
								// 'style'=>'width:50px;height:40px'
								]
						);
			}
           
        },
        'noWrap'=>true,
        'headerOptions'=>[
            'style'=>[
            'text-align'=>'center',
            'width'=>$value[$key]['SIZE'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
            'background-color'=>'rgba('.$value[$key]['warna'].')',
          ]
        ],
        'contentOptions'=>[
          'style'=>[
            'text-align'=>$value[$key]['align'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ]
        ],
              'width'=>'12px',
      ];


  }else{
      # code...
      $attDinamik[]=[
        'attribute'=>$value[$key]['FIELD'],
        'label'=>$value[$key]['label'],
        'filter'=>true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'noWrap'=>true,
		'group'=>$value[$key]['grp'],
        'headerOptions'=>[
            'style'=>[
            'text-align'=>'center',
            'width'=>$value[$key]['SIZE'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
            'background-color'=>'rgba('.$value[$key]['warna'].')',
          ]
        ],
        'contentOptions'=>[
          'style'=>[
            'text-align'=>$value[$key]['align'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ]
        ],
              'width'=>'12px',
      ];

    }



  };

   /*GRIDVIEW ARRAY ACTION*/
   /*  $attDinamik[]=[
      'class'=>'kartik\grid\ActionColumn',
      'dropdown' => true,
      'dropdownOptions'=>['class'=>'pull-left dropup','style'=>['disable'=>true]],
      'dropdownButton'=>[
        'class' => $actionClass,
      ],
      'buttons' => [
        'view' =>function($url, $model, $key){
            return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
                          ['view','id'=>$model->ID],[
                          'id'=>'gv-grid-draft-id',
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
    ]; */



/*SHOW GRID VIEW LIST*/
$gvDraftPlan=GridView::widget([
  'id'=>'gv-draft-id',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-draft-id',
    ],
  ],
  'panel' => [
        'heading'=>'<h3 class="panel-title">Draft Plan Maintain </h3>',
        'type'=>'info',
       'before'=> Html::a('<i class="fa fa-sign-in"></i> '.Yii::t('app', 'Start Plan',
                            ['modelClass' => 'DraftPlan',]),'/master/draft-plan/create',[
                                'data-toggle'=>"modal",
                                    'data-target'=>"#modal-create",
                                        'class' => 'btn btn-success'
                                                    ]).' '.
                Html::a('<i class="fa fa-paper-plane"></i> '.Yii::t('app', 'Send Draft',
                            ['modelClass' => 'DraftPlan',]),'/master/draft-plan/send-draft',[
                                        'class' => 'btn btn-info'
                                                    ]),
        'showFooter'=>false,
  ],
  'export' =>['target' => GridView::TARGET_BLANK],
  'exportConfig' => [
    GridView::PDF => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
    GridView::EXCEL => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
  ],
  'toolbar'=> [
        '{export}',
    //'{items}',
  ],
  'hover'=>true, //cursor select
  'responsive'=>true,
  'responsiveWrap'=>true,
  'bordered'=>true,
  'striped'=>true,
]);
?>

<div class="content">
	<div  class="row" style="padding-left:3px">
		<div class="col-sm-12 col-md-12 col-lg-12" >
			<?php
				echo $gvDraftPlan;
			?>
		</div>
	</div>
</div>
<?php
$this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-create').on('show.bs.modal', function (event) {
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
        'id' => 'modal-create',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search-plus"></div><div><h4 class="modal-title">GEOGRAFIS FILTER To PLAN MAINTAIN</h4></div>',
        'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
        ],
    ]);
    Modal::end();


    $this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-day').on('show.bs.modal', function (event) {
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
        'id' => 'modal-day',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> SCHEDULE OF CUSTOMER </h4></div>',
        'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
        ],
    ]);
    Modal::end();
