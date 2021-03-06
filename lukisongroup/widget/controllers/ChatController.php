<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\widget\controllers;

/* VARIABLE BASE YII2 Author: -YII2- */
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;

/* namespace models */
use lukisongroup\widget\models\Chat;
use lukisongroup\widget\models\ChatTest;
use lukisongroup\widget\models\ChatSearch;
use lukisongroup\widget\models\ChatroomSearch;
use lukisongroup\widget\models\Chatroom;
use lukisongroup\sistem\models\Userlogin;
/* VARIABLE PRIMARY JOIN/SEARCH/FILTER/SORT Author: -ptr.nov- */


/**
 * CHAT | CONTROLLER EMPLOYE .
 */
class ChatController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
					//'save' => ['post'],
                ],
            ],
        ];
    }

	   public function beforeAction($action){
            if (Yii::$app->user->isGuest)  {
                 Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
            }
            // Check only when the user is logged in
            if (!Yii::$app->user->isGuest)  {
               if (Yii::$app->session['userSessionTimeout']< time() ) {
                   // timeout
                   Yii::$app->user->logout();
                   $id = Yii::$app->getUserOpt->profile_user()->id;
                   $this->getofline($id);
                   $this->redirect(array('/site/login'));  //
               } else {
                 $id = Yii::$app->getUserOpt->profile_user()->id;
                
                   //Yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
                   Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
                   return true;

               }
            } else {
                return true;
            }
    }

   



    /**
     * ACTION INDEX
     */

    public function actionIndex()
    {
			//return $this->redirect('http://chat.lukisongroup.com:8890','htmloptions'=>['target' => '_blank']]);
			//echo Html::a('http://chat.lukisongroup.com:8890', ['target'=>'_blank']);
			return $this->render('loadtab');
			
    }

    



public function actionSendChat()
{

  // componen user
    $profile = Yii::$app->getUserOpt->profile_user()->emp;
   
  
  # code...
  if (Yii::$app->request->post()) {

    $request = Yii::$app->request;
    $chat = $request->post('message');
    $emp_nm = $profile->EMP_NM.' '.$profile->EMP_NM_BLK;
    $emp_img = $profile->IMG_BASE64;
    $emp_id = $profile->EMP_ID;
    $date = date('Y-m-d h:i:s');

    $chattest = new ChatTest();
    $chattest->attributes = ['name' => $emp_nm];
    $chattest->attributes = ['message' => $chat];
    $chattest->attributes = ['date' => $date];
    $chattest->attributes = ['emp_id' =>$emp_id];
    $chattest->attributes = ['image_profile' =>$emp_img];

    $chattest->save();
    echo $chattest->id; // id will automatically be incremented if not set explicitly

     if($chattest->id %2 == 0){
                $idx = true;
             }else{
                 $idx = false;
             }

     /* set list key name */
      Yii::$app->redis->executeCommand('RPUSH', [
            'key'=>'chats:',
            'value'=>Json::encode(['name' => $emp_nm, 'message' => $chat,'tgl'=>$date,'base64'=>$emp_img,'id'=>$idx])
          ]);

    return Yii::$app->redis->executeCommand('PUBLISH', [
        'channel' => 'notification',
        'message' => Json::encode(['name' =>$emp_nm, 'message' => $chat,'tgl'=>$date,'base64'=>$emp_img,'id'=>$idx])
      ]);

  }
   return $this->render('index');
  
}


public function CariYouandme($emp_id){

  $query = ChatTest::find()->where(['emp_id'=>$emp_id])->count();

  switch ($query %2 == 0) {
    case true:
      # code...
     return "me";
      break;

    case false:
      # code...
     return "you";
      break;
    
    default:
    return "me";
      # code...
      break;
  }

}

public function actionGetdata()
{
  $hasil = ChatTest::find()->all();

  echo json_encode($hasil);
}


	public function actionLogin(){
		return $this->render('test');
		//echo "ok";
	}

}
