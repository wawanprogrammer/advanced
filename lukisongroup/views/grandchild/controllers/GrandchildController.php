<?php

namespace lukisongroup\grandchild\controllers;

use Yii;
use lukisongroup\grandchild\models\Grandchild;
use lukisongroup\grandchild\models\GrandchildSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lukisongroup\child\models\Child;


/**
 * GrandchildController implements the CRUD actions for Grandchild model.
 */
class GrandchildController extends Controller
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

    /**
     * Lists all Grandchild models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GrandchildSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Grandchild model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($GRANDCHILD_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($GRANDCHILD_ID),
        ]);
    }
     public function actionGetChild() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $cat_id = $parents[0];
            $model = Child::find()->asArray()->where(['PARENT_ID'=>$cat_id])->all();
            foreach ($model as $key => $value) {
                   $out[] = ['id'=>$value['CHILD_ID'],'name'=> $value['CHILD_NAME']];
               }
 
               echo json_encode(['output'=>$out, 'selected'=>'']);
               return;
           }
       }
       echo Json::encode(['output'=>'', 'selected'=>'']);
   }

    /**
     * Creates a new Grandchild model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Grandchild();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             return $this->redirect(['/grandchild/grandchild']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Grandchild model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($GRANDCHILD_ID)
    {
        $model = $this->findModel($GRANDCHILD_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/grandchild/grandchild']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Grandchild model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($GRANDCHILD_ID)
    {
        $this->findModel($GRANDCHILD_ID)->delete();

        return $this->redirect(['/grandchild/grandchild']);
    }

    /**
     * Finds the Grandchild model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grandchild the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grandchild::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
