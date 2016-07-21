<?php
namespace console\controllers;

use Yii;
use zyx\phpmailer\Mailer;
use yii\base\DynamicModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use yii\console\Controller;			// Untuk console 
//use yii\console\Controller;		// Untuk app view 
//use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use scotthuangzl\export2excel\Export2ExcelBehavior;

class PostmanCustomerController extends Controller
{
    public function behaviors()
    {
        return [
			'export2excel' => [
				'class' => Export2ExcelBehavior::className(),
			],
			'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
        ];
    }

	// public function actions()
    // {
        // return [           
            // 'download' => [
                // 'class' => 'scotthuangzl\export2excel\DownloadAction',
            // ],
        // ];
    // } 
	
	// public function actionIndex(){
		// return $this->render('index');
	// }
	/*
	 * EXPORT DATA CUSTOMER TO EXCEL
	 * export_data
	*/
	public function actionExport(){
		
		//$custDataMTI=Yii::$app->db_esm->createCommand("CALL ERP_MASTER_CUSTOMER_export('CUSTOMER_MTI')")->queryAll(); 
		/* 22=NKA*/
		$cusDataProviderNKA= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("
				SELECT CUST_KD,CUST_NM,(SELECT CUST_KTG_NM FROM c0001k WHERE CUST_KTG=CUST_TYPE limit 1) AS TYPE_NM, ALAMAT,TLP1,PIC
				FROM c0001
				WHERE CUST_KTG='1' AND CUST_TYPE='22' #AND CUST_KD<>CUST_GRP
				ORDER BY CUST_GRP ASC			
			")->queryAll(),
		]);	
		$aryCusDataProviderNKA=$cusDataProviderNKA->allModels;
		
		/*15=MTI*/
		$cusDataProviderMTI= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("
				SELECT CUST_KD,CUST_NM,(SELECT CUST_KTG_NM FROM c0001k WHERE CUST_KTG=CUST_TYPE limit 1) AS TYPE_NM, ALAMAT,TLP1,PIC
				FROM c0001
				WHERE CUST_KTG='1' AND CUST_TYPE='15' #AND CUST_KD<>CUST_GRP
				ORDER BY CUST_GRP ASC			
			")->queryAll(),
		]);			
		$aryCusDataProviderMTI=$cusDataProviderMTI->allModels;
		
		/*OTHERS*/		
		$cusDataProvideOTHER= new ArrayDataProvider([
			'key' => 'ID',
			'allModels'=>Yii::$app->db_esm->createCommand("
				SELECT CUST_KD,CUST_NM,(SELECT CUST_KTG_NM FROM c0001k WHERE CUST_KTG=CUST_TYPE limit 1) AS TYPE_NM, ALAMAT,TLP1,PIC
				FROM c0001
				WHERE CUST_KTG='1' AND CUST_TYPE<>'15' AND CUST_TYPE<>22
				ORDER BY CUST_GRP ASC			
			")->queryAll(),
		]);			
		$aryCusDataProviderOTHER=$cusDataProvideOTHER->allModels;
		
		/*SOURCE NKA*/
		$excel_dataNKA = Export2ExcelBehavior::excelDataFormat($aryCusDataProviderNKA);
		//$excel_title = $excel_dataNKA['excel_title'];
		$excel_ceilsNKA = $excel_dataNKA['excel_ceils'];
		
		/*SOURCE MTI*/
		$excel_dataMTI = Export2ExcelBehavior::excelDataFormat($aryCusDataProviderMTI);      
        $excel_ceilsMTI = $excel_dataMTI['excel_ceils'];
		
		/*SOURCE OTHERS*/
		$excel_dataOTHER= Export2ExcelBehavior::excelDataFormat($aryCusDataProviderOTHER);      
        $excel_ceilsOTHER = $excel_dataOTHER['excel_ceils'];
		
		
		$excel_content = [
			 [
				'sheet_name' => 'NKA CUSTOMER',
                'sheet_title' => ['CUST_ID','CUST_NM','TYPE','ALAMAT','TLP','PIC'], //$excel_ceils,//'sad',//[$excel_title],
			    'ceils' => $excel_ceilsNKA,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
                     'TLP1' => Export2ExcelBehavior::getCssClass('header'),
                     'PIC' => Export2ExcelBehavior::getCssClass('header')              
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'MTI CUSTOMER',
                'sheet_title' => ['CUST_ID','CUST_NM','TYPE','ALAMAT','TLP','PIC'], //$excel_ceils,//'sad',//[$excel_title],
			    'ceils' => $excel_ceilsMTI,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
                     'TLP1' => Export2ExcelBehavior::getCssClass('header'),
                     'PIC' => Export2ExcelBehavior::getCssClass('header')              
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
			[
				'sheet_name' => 'OTHERS',
                'sheet_title' => ['CUST_ID','CUST_NM','TYPE','ALAMAT','TLP','PIC'], //$excel_ceils,//'sad',//[$excel_title],
			    'ceils' => $excel_ceilsOTHER,
                //'freezePane' => 'E2',
                'headerColor' => Export2ExcelBehavior::getCssClass("header"),
                'headerColumnCssClass' => [
					 'CUST_KD' => Export2ExcelBehavior::getCssClass('header'),
                     'CUST_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'TYPE_NM' => Export2ExcelBehavior::getCssClass('header'),
                     'ALAMAT' => Export2ExcelBehavior::getCssClass('header'),
                     'TLP1' => Export2ExcelBehavior::getCssClass('header'),
                     'PIC' => Export2ExcelBehavior::getCssClass('header')              
                ], //define each column's cssClass for header line only.  You can set as blank.
               'oddCssClass' => Export2ExcelBehavior::getCssClass("odd"),
               'evenCssClass' => Export2ExcelBehavior::getCssClass("even"),
			],
		];		
		$excel_file = "PostmanCustomer";
		$this->export2excel($excel_content, $excel_file,0); 
	}
	
	/*SEND EMAIL*/
	public function  actionSend(){
		
		/*Content template*/
		$cusCount=Yii::$app->db_esm->createCommand("SELECT COUNT(CUST_KD) as CNT_ALL FROM `c0001` WHERE CUST_KD<>CUST_GRP")->queryAll();
			
		/*path & Name File*/
		//$rootyii=dirname(dirname(__DIR__)).'/cronjob/';
		$rootyii='/var/www/advanced/lukisongroup/cronjob/temp/';
		//$folder=$rootyii.'/cronjob/'.$filename;
		//$baseRoot = Yii::getAlias('@webroot') . "/uploads/temp/";
		$filename = 'PostmanCustomer';
		//$filenameAll=$baseRoot.$filename;
		$filenameAll=$rootyii.$filename.'.xlsx';
		
		if (file_exists($filenameAll)) {
			
			/* Get Content*/
			$contentBody= $this->renderPartial('_postmanBody',[
				'cusCount'=>$cusCount
			]);	
			
			/* Send Mail*/
			Yii::$app->mailer->compose()
			->setFrom(['postman@lukison.com' => 'LG-ERP-POSTMAN'])
			//->setTo(['it-dept@lukison.com'])
			//->setTo(['piter@lukison.com'])
			->setTo(['sales_esm@lukison.com','marketing_esm@lukison.com'])
			->setSubject('WEEKLY POSTMAN-CUSTOMER')
			->setHtmlBody($contentBody)
			->attach($filenameAll,[$filename,'xlsx'])
			->send(); 		
		} else {
			//echo "The file $filenameAll does not exist";
		}	
	}
	
	
	
}
?>