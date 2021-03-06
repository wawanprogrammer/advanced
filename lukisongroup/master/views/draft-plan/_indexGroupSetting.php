<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\DraftPlan;
Use ptrnov\salesforce\Jadwal;
use yii\helpers\Url;
      
/*
 * GRID draft_plan
 * @author wawan  [aditiya@lukison.com]
 * @since 1.2
*/

$actionClass='btn btn-info btn-xs';
$actionLabel='Update';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomn=[
	['ID' =>0, 'ATTR' =>['FIELD'=>'SCDL_GROUP','SIZE' => '10px','label'=>'GROUP CODE','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
	// ['ID' =>1, 'ATTR' =>['FIELD'=>'geonm','SIZE' => '20px','label'=>'GROUP_PRN','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>true]],
   ['ID' =>1, 'ATTR' =>['FIELD'=>'ganjilGenap','SIZE' => '20px','label'=>'Week','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>true]],
   ['ID' =>2, 'ATTR' =>['FIELD'=>'dayNm','SIZE' => '20px','label'=>'Day Name','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>true]],
    ['ID' =>3, 'ATTR' =>['FIELD'=>'geonm','SIZE' => '20px','label'=>'GROUP_PRN','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>true]],
	['ID' =>4, 'ATTR' =>['FIELD'=>'SUB_GEO','SIZE' => '20px','label'=>'GEO_SUB','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>true]],
   ['ID' =>5, 'ATTR' =>['FIELD'=>'useridNm','SIZE' => '20px','label'=>'UserName','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>true]],     	
];
$gvHeadColomnBT = ArrayHelper::map($headColomn, 'ID', 'ATTR');


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
  if($value[$key]['FIELD'] == 'geonm')
  {
      # code...
      $attDinamik[]=[
      'attribute'=>$value[$key]['FIELD'],
      'label'=>$value[$key]['label'],
      'filterType'=>GridView::FILTER_SELECT2,
      'filter' => $drop,
      'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
      ],
      'filterInputOptions'=>['placeholder'=>'Pilih Group'],
      'hAlign'=>'right',
      'vAlign'=>'middle',
      'noWrap'=>true,
      'group'=>true,
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
          'width'=>$value[$key]['SIZE'],
          'text-align'=>$value[$key]['align'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
      ];

    }elseif($value[$key]['FIELD'] == 'ganjilGenap'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => $pekan,
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
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
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];
  }elseif($value[$key]['FIELD'] == 'dayNm'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => DraftPlan::getDay(),
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
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
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];
  }elseif($value[$key]['FIELD'] == 'useridNm'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => $user,
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
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
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];
  }else{
      # code...
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
      'width'=>$value[$key]['SIZE'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ]
        ],
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
$gvGroupSetting=GridView::widget([
   'id'=>'gv-group-setting-id',
  'dataProvider' => $dataProviderGrp,
  'filterModel' => $searchModelGrp,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  // 'rowOptions'   => function ($model, $key, $index, $grid) {
  //        return ['id' => $model->SCL_NM,'onclick' => '$.pjax.reload({
  //             url: "'.Url::to(['/master/draft-plan/index']).'?SCL_NM="+this.id,
  //             container: "#gv-group-user-id",
  //             timeout: 10,
  //         });'];
  //       //  return ['data-id' => $model->USER_ID];
  //    },
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-group-setting-id',
    ],
  ],
  'panel' => [
       'heading'=>false,
        'type'=>'info',
       'before'=> Html::a('<i class="fa fa-gears"></i> '.Yii::t('app', 'add Group-Kode',
                            ['modelClass' => 'DraftPlanGroup',]),'/master/draft-plan/create-plan-group',[
                                'data-toggle'=>"modal",
                                    'data-target'=>"#modal-create-group",
                                        'class' => 'btn btn-danger btn-sm'
                                                    ]),
        'showFooter'=>false,
  ],
  /* 'export' =>['target' => GridView::TARGET_BLANK],
  'exportConfig' => [
    GridView::PDF => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
    GridView::EXCEL => [ 'filename' => 'kategori'.'-'.date('ymdHis') ], 
  ],*/
  'toolbar'=> [
        //'{export}',
    //'{items}',
  ],
  'hover'=>true, //cursor select
  'responsive'=>true,
  'responsiveWrap'=>true,
  'bordered'=>true,
  'striped'=>true,
]);
?>
<?=$gvGroupSetting?>

<?php
$this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-create-group').on('show.bs.modal', function (event) {
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
        'id' => 'modal-create-group',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-gears"></div><div><h4 class="modal-title">SETUP KODE</h4></div>',
         'size' => Modal::SIZE_SMALL,	
		'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(255, 129, 117, 1)',
        ],
    ]);
    Modal::end();

?>

