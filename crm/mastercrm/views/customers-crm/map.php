
<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use lukisongroup\assets\MapAsset;
use kartik\nav\NavX;      /* CLASS ASSET CSS/JS/THEME Author: -wawan-*/
MapAsset::register($this);



$this->params['breadcrumbs'][] = $this->title;
// $this->sideCorp = 'Customers';                 				 /* Title Select Company pada header pasa sidemenu/menu samping kiri */
// $this->sideMenu = $sideMenu_control;//'umum_datamaster';   	 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Customers');   	 			 /* title pada header page */


function tombolCustomers(){
  $title1 = Yii::t('app', 'Customers');
  $options1 = [ 'id'=>'setting',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#",
          //'class' => 'btn btn-default',
          'style' => 'text-align:left',
  ];
  $icon1 = '<span class="fa fa-cogs fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * New|Change|Reset| Password Login
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolKota(){
  $title1 = Yii::t('app', 'Kota');
  $options1 = [ 'id'=>'password',
          // 'data-toggle'=>"modal",
          // 'data-target'=>"#profile-passwrd",
          //'class' => 'btn btn-default',
         // 'style' => 'text-align:left',
  ];
  $icon1 = '<span class="fa fa-shield fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index-city']);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Create Signature
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolProvince(){
  $title1 = Yii::t('app', 'Province');
  $options1 = [ 'id'=>'signature',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#profile-signature",
          //'class' => 'btn btn-default',
  ];
  $icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index-provinsi']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Persinalia Employee
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolKategori(){
  $title1 = Yii::t('app', 'Kategori Customers');
  $options1 = [ 'id'=>'personalia',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#profile-personalia",
          // 'class' => 'btn btn-primary',
  ];
  $icon1 = '<span class="fa fa-group fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index-kategori']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Performance Employee
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolMap(){
  $title1 = Yii::t('app', 'Map');
  $options1 = [ 'id'=>'performance',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#profile-performance",
          // 'class' => 'btn btn-danger',
  ];
  $icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-map']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

?>

<?php
   $navmenu= NavX::widget([
    'options'=>['class'=>'nav nav-tabs'],
    'encodeLabels' => false,
    'items' => [
      ['label' => 'MENU', 'active'=>true, 'items' => [
        ['label' => '<span class="fa fa-user fa-md"></span>Customers', 'url' => '/mastercrm/customers-crm/index'],
        ['label' => '<span class="fa fa-cogs fa-md"></span>Alias Customers', 'url' => '/mastercrm/customers-crm/login-alias','linkOptions'=>['id'=>'performance','data-toggle'=>'modal','data-target'=>'#formlogin']],
        '<li class="divider"></li>',
        ['label' => 'Properties', 'items' => [
          ['label' => '<span class="fa fa-flag fa-md"></span>Kota', 'url' => '/mastercrm/kota-customers-crm/index'],
          ['label' => '<span class="fa fa-flag-o fa-md"></span>Province', 'url' => '/mastercrm/provinsi-customers-crm/index'],
          ['label' => '<span class="fa fa-table fa-md"></span>Category', 'url' => '/mastercrm/kategori-customers-crm/index'],
          '<li class="divider"></li>',
          ['label' => '<span class="fa fa-map-marker fa-md"></span>Customers Map', 'url' => '/mastercrm/customers-crm/crm-map'],
        ]],
      ]],

    ]
  ]);
?>
<div class="content">
  <div  class="row" style="padding-left:3px">
    <div class="col-sm-12 col-md-12 col-lg-12" >
     <?php
        //echo  $test;
        echo $navmenu;
      ?>
      <!-- CUTI !-->
    </div>
   <div class="col-sm-12">
    <?php
    /*Display MAP*/
    echo $map = '<div id ="map" style="width:100%;height:400px"></div>';
     ?>

 </div>
  </div>
</div>


<!-- <div class="row"> -->
 
 <!-- </div> -->

 <?php
 /*js mapping */
 $this->registerJs("
   /*nampilin MAP*/
    var map = new google.maps.Map(document.getElementById('map'),
       {
       zoom: 12,
       center: new google.maps.LatLng(-6.229191531958687,106.65994325550469),
       mapTypeId: google.maps.MapTypeId.ROADMAP

     });

     var public_markers = [];
     var infowindow = new google.maps.InfoWindow();

   /*data json*/
    $.getJSON('/mastercrm/customers-crm/map', function(json) {

     for (var i in public_markers)
     {
       public_markers[i].setMap(null);
     }

     $.each(json, function (i, point) {
       // alert(point.MAP_LAT);

   //set the icon
   //     if(point.CUST_NM == 'asep')
   //         {
   //             icon = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
   //         }

         var marker = new google.maps.Marker({
         // icon: icon,
         position: new google.maps.LatLng(point.MAP_LAT, point.MAP_LNG),
         animation:google.maps.Animation.BOUNCE,
         map: map,
          icon : 'http://labs.google.com/ridefinder/images/mm_20_red.png'
       });

        public_markers[i] = marker;

        google.maps.event.addListener(public_markers[i], 'mouseover', function () {
          infowindow.setContent('<h1>' + point.ALAMAT + '</h1>' + '<p>' + point.CUST_NM + '</p>');
          infowindow.open(map, public_markers[i]);
        });


     });


    });
   // console.trace();
    ",$this::POS_READY);

    ?>
