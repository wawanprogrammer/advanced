<?php

namespace lukisongroup\master\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \DateTime;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Scheduleheader;
use lukisongroup\master\models\ScheduleheaderSearch;
use lukisongroup\sistem\models\Userlogin;
use lukisongroup\sistem\models\UserloginSearch;

/**
 * ScheduleHeaderController implements the CRUD actions for Scheduleheader model.
 */
class ScheduleHeaderController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction(){
            if (Yii::$app->user->isGuest)  {
                 Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
            }
            // Check only when the user is logged in
            if (!Yii::$app->user->isGuest)  {
               if (Yii::$app->session['userSessionTimeout']< time() ) {
                   // timeout
                   Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
               } else {
                   //Yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
                   Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
                   return true;
               }
            } else {
                return true;
            }
    }

    /**
     * Lists all Scheduleheader models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new ScheduleheaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModelUser = new UserloginSearch();
        $dataProviderUser = $searchModelUser->searchCustGroup(Yii::$app->request->queryParams);

        return $this->render('index', [
			       'dataProviderUser'=>$dataProviderUser,
			       'searchModelUser'=>$searchModelUser,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }






    /**
     * Displays a single Scheduleheader model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Scheduleheader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Scheduleheader();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new User Login.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */

    public function actionCreateUser()
    {
        $model = new Userlogin();
        $model->scenario = 'createuser';
        if ($model->load(Yii::$app->request->post())  ) {
          $post = Yii::$app->request->post();
          $datapostion = $post['Userlogin']['POSITION_LOGIN'];
          if($datapostion == 1)
          {
              $auth = "SALESMAN";// auth key untuk salesmen
          }
          else{
            $auth = "SALES PROMOTION";// auth key untuk sales promotion
          }
          $model->POSITION_LOGIN = $datapostion;
          $model->POSITION_SITE = "CRM"; // untuk login crm
          $pass = $model->password_hash;
          $security = Yii::$app->security->generatePasswordHash($pass);
          $authkey =  Yii::$app->security->generatePasswordHash($auth);
          $model->password_hash = $security;
          $model->auth_key = $authkey;
          $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Scheduleheader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Scheduleheader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Scheduleheader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Scheduleheader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Scheduleheader::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


	 /**
     * [actionJsoncalendar description]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @param  [type] $_     [description]
     * @return [type]        [description]
     */
    public function actionJsoncalendar($start=NULL,$end=NULL,$_=NULL){
        $events = array();

        //Demo
        $Event = new \yii2fullcalendar\models\Event();

        // $Event->id = 1;
        // $Event->title = 'Testing';
        // $Event->start = date('Y-m-d\TH:m:s\Z');
        // $events[] = $Event;
        // $Event = new \yii2fullcalendar\models\Event();
        // $Event->id = 2;
        // $Event->title = 'Testing';
        // $Event->start = date('Y-m-d\TH:m:s\Z',strtotime('tomorrow 8am'));
        // $events[] = $Event;
        // $event3 = new DateTime('+2days 10am');
        // $Event = new \yii2fullcalendar\models\Event();
        // $Event->id = 2;
        // $Event->title = 'Testing';
        // $Event->start = $event3->format('Y-m-d\Th:m:s\Z');
        // $Event->end = $event3->modify('+3 hours')->format('Y-m-d\TH:m:s\Z');
        // $events[] = $Event;
        header('Content-type: application/json');
        echo Json::encode($events);
        Yii::$app->end();
    }

	 public function actionJsoncalendar_add(){

		if (Yii::$app->request->isAjax) {
			$request= Yii::$app->request;
			$model =  new Scheduleheader();
			$end=$request->post('end');
      $start=$request->post('start');
			$title=$request->post('title');
			$model->TGL1 = $start;
      $model->TGL2 = $end;
			$model->USER_ID = $title;
			$model->save();

		}
		return true;

		//$model->TGL = $_POST['start'];
		//
		//$end = explode('+', $_POST['end']);
		//$model->end_date = urldecode($end[0]);
		//

		//$model->SCDL_GROUP = $_POST['title'];
		//$model->resource_id = $_POST['resourse'];

		// if ($model->save()) {
			// echo 'saved';
		// } else {
			// echo 'error';
		// }
	 }
}
