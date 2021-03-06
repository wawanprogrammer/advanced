<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');   

$tes = '<img style="width:80; height:40px" src=data:image/jpeg;'.$data->ISI_TERM.'></img>';
echo $tes;

echo '<img src="data:image/jpeg;base64,' . $data->ISI_TERM . '" />';

            $aryStt= [
                ['STATUS' => 0, 'STT_NM' => 'DISABLE'],
                ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
            ];
            $valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');

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
                      'background-color'=>'rgba(97, 211, 96, 0.3)',
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
                  'attribute' => 'SUBJECT',
                  'label'=>'General Term',
                  'hAlign'=>'left',
                  'vAlign'=>'middle',
                  'headerOptions'=>[
                    'style'=>[
                      'text-align'=>'center',
                      'width'=>'150px',
                      'font-family'=>'tahoma, arial, sans-serif',
                      'font-size'=>'9pt',
                      'background-color'=>'rgba(97, 211, 96, 0.3)',
                    ]
                  ],
                  'contentOptions'=>[
                    'style'=>[
                      'text-align'=>'left',
                      'width'=>'150px',
                      'font-family'=>'tahoma, arial, sans-serif',
                      'font-size'=>'9pt',
                    ]
                  ],
                ],
                [
                  'attribute' => 'ISI_TERM',
                  'label'=>'Isi Perjanjian',
                  'hAlign'=>'left',
                  'vAlign'=>'middle',
                  'headerOptions'=>[
                    'style'=>[
                      'text-align'=>'center',
                      'width'=>'200px',
                      'font-family'=>'tahoma, arial, sans-serif',
                      'font-size'=>'9pt',
                      'background-color'=>'rgba(97, 211, 96, 0.3)',
                    ]
                  ],
                  'contentOptions'=>[
                    'style'=>[
                      'text-align'=>'left',
                      'width'=>'200px',
                      'font-family'=>'tahoma, arial, sans-serif',
                      'font-size'=>'9pt',
                    ]
                  ],
                ],
                [
                  'attribute' => 'STATUS',
                  'filter' => $valStt,
                  'format' => 'raw',
                  'hAlign'=>'center',
                  'value'=>function($model){
                     if ($model->STATUS == 1) {
                      return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
                    } else if ($model->STATUS == 0) {
                      return Html::a('<i class="fa fa-close"></i> &nbsp;Disable', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
                    }
                  },
                  'hAlign'=>'left',
                  'vAlign'=>'middle',
                  'headerOptions'=>[
                    'style'=>[
                      'text-align'=>'center',
                      'width'=>'80px',
                      'font-family'=>'tahoma, arial, sans-serif',
                      'font-size'=>'9pt',
                      'background-color'=>'rgba(97, 211, 96, 0.3)',
                    ]
                  ],
                  'contentOptions'=>[
                    'style'=>[
                      'text-align'=>'center',
                      'width'=>'80px',
                      'font-family'=>'tahoma, arial, sans-serif',
                      'font-size'=>'9pt',
                    ]
                  ],
                ],
                [
                  'class'=>'kartik\grid\ActionColumn',
                  'dropdown' => true,
                  'template' => '{view}{update}',
                  'dropdownOptions'=>['class'=>'pull-right dropup'],
                  'buttons' => [
                      'view' =>function($url, $model, $key){
                          return  '<li>' .Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'View'),
                                        ['/master/term-general/view','id'=>$model->ID],[
                                        'data-toggle'=>"modal",
                                        'data-target'=>"#modal-view",
                                        // 'data-title'=> $model->ID_TERM,
                                        ]). '</li>' . PHP_EOL;
                      },
                      'update' =>function($url, $model, $key){
                          return  '<li>' . Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'Update'),
                                        ['/master/term-general/update','id'=>$model->ID],[
                                        'data-toggle'=>"modal",
                                        'data-target'=>"#modal-create",
                                        // 'data-title'=> $model-,
                                        ]). '</li>' . PHP_EOL;
                      },

                          ],
                          'headerOptions'=>[
                    'style'=>[
                      'text-align'=>'center',
                      'width'=>'150px',
                      'font-family'=>'tahoma, arial, sans-serif',
                      'font-size'=>'9pt',
                      'background-color'=>'rgba(97, 211, 96, 0.3)',
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

                  ];
            ?>


            <div class="container-full">
            	<div style="padding-left:15px; padding-right:15px">
            		<?= $grid = GridView::widget([
            				'id'=>'gv-term-invest',
            				'dataProvider'=> $dataProvider,
            				'filterModel' => $searchModel,
            				'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
            				'columns' => $gridColumns,
            				'pjax'=>true,
            					'pjaxSettings'=>[
            						'options'=>[
            							'enablePushState'=>false,
            							'id'=>'gv-term-invest',
            						],
            					 ],
            				'toolbar' => [
            					'{export}',
            				],
            				'panel' => [
            					'heading'=>'<h3 class="panel-title">Type Investasi</h3>',
            					'type'=>'warning',
            					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add',
            							['modelClass' => 'Termcustomers',]),'/master/term-general/create',[
            								'data-toggle'=>"modal",
            									'data-target'=>"#modal-create",
            										'class' => 'btn btn-success'
            													]),
            					'showFooter'=>false,
            				],

            				'export' =>['target' => GridView::TARGET_BLANK],
            				'exportConfig' => [
            					GridView::PDF => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
            					GridView::EXCEL => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
            				],
            			]);
            		?>
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
              'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
              'headerOptions'=>[
                  'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
              ],
              ]);
              Modal::end();


              $this->registerJs("
                 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
                 $('#modal-view').on('show.bs.modal', function (event) {
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
                    'id' => 'modal-view',
                'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
                'headerOptions'=>[
                    'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
                ],
                ]);
                Modal::end();
