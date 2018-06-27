<?php

namespace backend\controllers;

use backend\models\searchAnnouncedPuResults;
use Yii;
use backend\models\Party;
use backend\models\PartySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use  backend\models\PollingUnit;
use  backend\models\AnnouncedPuResults;
use  backend\models\States;
use  backend\models\Lga;
use  backend\models\Ward;
use  backend\models\Transact;
use  backend\models\Surveytest;
use yii\helpers\ArrayHelper;
//use backend\assets\AppAsset;





/**
 * PartyController implements the CRUD actions for Party model.
 */
class PartyController extends Controller
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
     * Lists all Party models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PartySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Party model.
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
     * Creates a new Party model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Party();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Party model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing Party model.
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
     * Finds the Party model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Party the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Party::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewpollingunitresult()

    {

        $model = new PollingUnit();
        $model2=new States;
        $model3=new AnnouncedPuResults;
       $searchModel = new searchAnnouncedPuResults();
        return $this->render('viewpollingunitresult', [

            'model' => $model,'model2'=>$model2,'model3'=>$model3,'searchModel'=>$searchModel

        ]);

    }

    public function actionSubmit()
    {
        $model = new Surveytest();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->render('submit', [
                    'model' => $model,
                ]);            }
        }

        return $this->render('submit', [
            'model' => $model,
        ]);
    }
    
    public function actionViewlgaresult()
    {

        $model = new Lga;
        return $this->render('viewlgaresult', ['model' => $model,]);
    }
    public function actionDemo()
    {

        $model = new Lga;
        $model=new Transact;
        $model->cardno="test";//$result['data']['authorization']['last4'];
        $model->status="test";//$result['data']['status'];
        $model->message="test";//$result['message'];
        $model->amount="test";//$result['data']['amount'];
        $model->access_code="test";//$result['data']['authorization']['authorization_code'];
        $model->reference="test";//$result['data']['reference'];
        $model->date="test";//date('Y-m-d h:i:s');
        $model->update(array('cardno','status','message','amount','access_code','reference','date')); 
        return $this->render('demo', ['model' => $model,]);
    }
    public function actionDemo2()
    {

        $model = new Lga;
        return $this->render('demo2', ['model' => $model,]);
    }
    public function actionVerify()
    {

        $model = new Lga;
        return $this->render('verify', ['model' => $model,]);
    }
        public function actionPopup()
    {

        $model = new Lga;
        return $this->render('popup', ['model' => $model,]);
    }
    public function actionNewpollingunit()

    {
        $model = new AnnouncedPuResults;
        $model2 = new PollingUnit();
        $model3= new States;
        if (isset($_POST['submit'])) {
            $model2->attributes = $_POST['PollingUnit'];
            $model2->user_ip_address=Yii::$app->getRequest()->getUserIP();
            $model2->date_entered=date('Y-m-d h:i:s');
            $model2->entered_by_user=$_POST['AnnouncedPuResults']['entered_by_user'];
            $model2->save();
            $party_score = $_POST['party_score'];
            $party_abbreviation = $_POST['party_abbreviation'];
            foreach (array_combine($party_score, $party_abbreviation) as $score => $abbrev) {
               $model= new AnnouncedPuResults;
                $model->attributes = $_POST['AnnouncedPuResults'];
                $model->entered_by_user=$_POST['AnnouncedPuResults']['entered_by_user'];
                $model->user_ip_address=Yii::$app->getRequest()->getUserIP();
                $model->date_entered=date('Y-m-d h:i:s');
                $model->party_score = $score;
                $model->polling_unit_uniqueid= $model2->uniqueid;
                $model->party_abbreviation = $abbrev;
                $model->save();
            }
           return $this->redirect(['success','user' => $model->entered_by_user,'pollingunit' => $model2->polling_unit_name]);
        }
        return $this->render('newpollingunit', ['model' => $model,'model2'=>$model2,'model3' => $model3]);

    }
    
        public function actionNewpollingunitjx()

    {
        $model = new AnnouncedPuResults;
        $model2 = new PollingUnit();
        $model3= new States;
        if (isset($_POST['submit'])) {
            $model2->attributes = $_POST['PollingUnit'];
            $model2->user_ip_address=Yii::$app->getRequest()->getUserIP();
            $model2->date_entered=date('Y-m-d h:i:s');
            $model2->entered_by_user=$_POST['AnnouncedPuResults']['entered_by_user'];
            $model2->save();
            $party_score = $_POST['party_score'];
            $party_abbreviation = $_POST['party_abbreviation'];
            foreach (array_combine($party_score, $party_abbreviation) as $score => $abbrev) {
               $model= new AnnouncedPuResults;
                $model->attributes = $_POST['AnnouncedPuResults'];
                $model->entered_by_user=$_POST['AnnouncedPuResults']['entered_by_user'];
                $model->user_ip_address=Yii::$app->getRequest()->getUserIP();
                $model->date_entered=date('Y-m-d h:i:s');
                $model->party_score = $score;
                $model->polling_unit_uniqueid= $model2->uniqueid;
                $model->party_abbreviation = $abbrev;
                $model->save();
            }
           return $this->redirect(['success','user' => $model->entered_by_user,'pollingunit' => $model2->polling_unit_name]);
        }
        return $this->renderAjax('newpollingunit', ['model' => $model,'model2'=>$model2,'model3' => $model3]);

    }
    
    public function actionSuccess($user,$pollingunit)
    {
        return $this->render('success',['user'=>$user,'pollingunit'=>$pollingunit]);
    }

    public function actionState($id)
    {
        $lga=Lga::find()->where (['state_id'=>$id])->all();
        foreach ($lga as $lgaa){
            echo "<option value='".$lgaa->lga_id."'>".$lgaa->lga_name."</option>";
        }
    }

    public function actionLga($id)
    {
        $ward=Ward::find()->where (['Lga_id'=>$id])->all();
        foreach ($ward as $wardd){
            echo "<option value='".$wardd->ward_id."'>".$wardd->ward_name."</option>";
        }
    }

    public function actionWard($id)
    {
        $pollingunit=PollingUnit::find()->where (['ward_id'=>$id])->all();
        foreach ($pollingunit as $unit){
            echo "<option value='".$unit->uniqueid."'>".$unit->polling_unit_name."</option>";
        }
    }
}
