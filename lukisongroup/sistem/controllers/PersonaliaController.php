<?php

namespace lukisongroup\sistem\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \DateTime;

use lukisongroup\hrd\models\AbsenDaily;
use lukisongroup\hrd\models\AbsenDailySearch;
use lukisongroup\hrd\models\Kar_finger;
use lukisongroup\sistem\models\Absensi;
use lukisongroup\sistem\models\AbsensiSearch;
/**
 * PersonaliaController implements the CRUD actions for Absensi model.
 */
class PersonaliaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Absensi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AbsensiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$date=new DateTime();
		$thn=strlen($date->format('Y'));
		$bln=strlen($date->format('m'));
		$hri=strlen($date->format('d'));
		$dateRlt=$thn."-".$bln."-".$hri;
		$searchModel = new AbsenDailySearch([
			//'tgllog'=>Yii::$app->ambilKonvesi->tglSekarang()
		]);
				
		/*REKAP ABSENSI*/
		//Field Label
		$dataProviderField = $searchModel->dailyFieldTglRange();
		//Value row
		$dataProvider = $searchModel->searchDailyTglRange(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			/*Daily Absensi*/
			'searchModel'=>$searchModel,
			'dataProviderField'=>$dataProviderField,
			'dataProvider'=>$dataProvider	
        ]);
    }

    /**
     * Displays a single Absensi model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Absensi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Absensi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idno]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Absensi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idno]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Absensi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Absensi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Absensi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Absensi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
