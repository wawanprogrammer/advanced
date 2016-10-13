<?php

namespace lukisongroup\widget\controllers;

use Yii;
use lukisongroup\widget\models\Notulen;
use lukisongroup\widget\models\NotulenModul;
use lukisongroup\hrd\models\Employe;
use lukisongroup\widget\models\NotulenSearch;
use lukisongroup\widget\models\PostPerson;
use lukisongroup\widget\models\Authmodel1;
use lukisongroup\widget\models\Authmodel2;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * NotulenController implements the CRUD actions for Notulen model.
 */
class NotulenController extends Controller
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

     
    /*array modul from table M0002*/
    public function getary_modul()
    {
        return $data =  ArrayHelper::map(NotulenModul::find()->where('STATUS <>3')->asArray()->all(),'ID','MODUL_NM');
    }

     /**
    *array employe
    **/
    public function get_aryEmploye()
    {
        $emp = \lukisongroup\hrd\models\Employe::find()->where('STATUS<>3')->all();
        return $dropemploy = ArrayHelper::map($emp,'EMP_ID', function ($emp, $defaultValue) {
          return $emp['EMP_NM'] . ' ' . $emp['EMP_NM_BLK'];
    });
    }

     /**
    *array employe
    **/
    public function get_aryPerson()
    {
        $emp = \lukisongroup\hrd\models\Employe::find()->where('STATUS<>3')->all();
        return $dropemploy = ArrayHelper::map($emp,'EMP_NM', function ($emp, $defaultValue) {
          return $emp['EMP_NM'] . ' ' . $emp['EMP_NM_BLK'];
    });
    }

    public function Get_profile()
    {
        return Yii::$app->getUserOpt->Profile_user();
    }

    /**
     * Lists all Notulen models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotulenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
			'searchModelNotulen' => $searchModel,
            'dataProviderNotulen' => $dataProvider,
        ]);
    }

    public function actionSetTanggal($id)
    {
        $model = self::findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view','id'=>$id]);
        } else {
            return $this->renderAjax('set_tanggal', [
                'model' => $model,
            ]);
        }
    }

     public function actionSetTitle($id)
    {
        $model = self::findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view','id'=>$id]);
        } else {
            return $this->renderAjax('set_title', [
                'model' => $model,
            ]);
        }
    }



      public function actionSetPerson($id)
    {
        $model = new PostPerson();

         $model->NotulenId = $id;


        if ($model->load(Yii::$app->request->post())) {


            $model->saveAccount();
            return $this->redirect(['view','id'=>$id]);
        } else {
            return $this->renderAjax('set_person', [
                'model' => $model,
                'id'=>$id,
                'items'=>self::get_aryPerson()
            ]);
        }
    }


      public function actionSetAcara($id)
    {
        $model = NotulenModul::find()->where(['NOTULEN_ID'=>$id])->one();
       
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
           return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->renderAjax('set_acara', [
                'model' => $model,
            ]);
        }
    }

    public function actionSetTime($id)
    {
        $model = NotulenModul::find()->where(['NOTULEN_ID'=>$id])->one();
       
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
           return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->renderAjax('set_time', [
                'model' => $model,
            ]);
        }
    }

     public function actionSetHasil($id)
    {
        $model = NotulenModul::find()->where(['NOTULEN_ID'=>$id])->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
             return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->renderAjax('set_hasil', [
                'model' => $model,
            ]);
        }
    }

     public function actionSignAuth1View($id){
        $auth1Mdl = new Authmodel1();
        $acara = NotulenModul::find()->where(['NOTULEN_ID' =>$id])->one();

            return $this->renderAjax('sign_auth1', [
                'acara' => $acara,
                'auth1Mdl' => $auth1Mdl,
            ]);

    }
    public function actionSignAuth1Save(){
        $auth1Mdl = new Authmodel1();
        /*Ajax Load*/
        if(Yii::$app->request->isAjax){
            $auth1Mdl->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($auth1Mdl));
        }else{  /*Normal Load*/
            if($auth1Mdl->load(Yii::$app->request->post())){
                if ($auth1Mdl->auth1_saved()){
                    $hsl = \Yii::$app->request->post();
                    $id = $hsl['Authmodel1']['NotuID'];
                    return $this->redirect(['view', 'id'=>$id]);
                }
            }
        }
    }

     public function actionSignAuth2View($id){
        $auth2Mdl = new Authmodel2();
        $acara = NotulenModul::find()->where(['NOTULEN_ID' =>$id])->one();
            return $this->renderAjax('sign_auth2', [
                'acara' => $acara,
                'auth2Mdl' => $auth2Mdl,
            ]);
    }
    public function actionSignAuth2Save(){
        $auth2Mdl = new Authmodel2();
        /*Ajax Load*/
        if(Yii::$app->request->isAjax){
            $auth2Mdl->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($auth2Mdl));
        }else{  /*Normal Load*/
            if($auth2Mdl->load(Yii::$app->request->post())){
                if ($auth2Mdl->auth2_saved()){
                    $hsl = \Yii::$app->request->post();
                    $id = $hsl['Authmodel2']['NotuID'];
                    return $this->redirect(['view', 'id'=>$id]);
                }
            }
        }
    }


    /**
     * Displays a single Notulen model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = self::findModel($id);
        $acara = $model->notulenTbl;
    
        return $this->render('view', [
            'model' => $model,
            'acara' =>  $acara,
            'ttd'=>self::Get_profile()->emp->SIGSVGBASE64,
            'profile'=>self::Get_profile()->emp,
            'emp_nm'=>self::Get_profile()->emp->EMP_NM
        ]);
    }

    /**
     * Creates a new Notulen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($start,$end)
    {
        $model = new Notulen();
        $model->scenario = Notulen::SCENARIO_NOTE;

        $model_modul = new NotulenModul();

        if ($model->load(Yii::$app->request->post())) {

              $transaction = Notulen::getDb()->beginTransaction();
                    try {
                            $model->start = $start;
                            $model->end = $end;
                            $model->CREATE_BY = self::Get_profile()->username;
                            $model->CREATE_AT = date("Y-m-d H:i:s");
                            $model->save();


                            $model_modul->NOTULEN_ID = $model->id;
                            $model_modul->save();
                        // ...other DB operations...
                        $transaction->commit();
                    } catch(\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
          
           return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'data_modul'=>self::getary_modul(),
                'data_emp'=>self::get_aryEmploye()
            ]);
        }
    }

    /**
     * Updates an existing Notulen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Notulen model.
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
     * Finds the Notulen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Notulen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notulen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     protected function findModul($id)
    {
        if (($model = NotulenModul::find(['NOTULEN_ID'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
