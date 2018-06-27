<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\States;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model backend\models\PollingUnit */
/* @var $form ActiveForm */
?>
<div class="viewpollingunitresult">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model2, 'state_id')->dropDownList(
                ArrayHelper::map(States::find()->all(),'state_id','state_name'),
        [
                'prompt'=>'Select State',
                'onchange'=>'
                    $.post("index.php?r=party/state&id='.'"+$(this).val(), function(data){
                    $("select#pollingunit-lga_id").html(data);
                    });'

        ]); ?>
        <?= $form->field($model, 'lga_id') ->dropDownList(
            [], [
                'prompt'=>'Select LGA',
            'onchange'=>'
                    $.post("index.php?r=party/lga&id='.'"+$(this).val(), function(data){
                    $("select#pollingunit-ward_id").html(data);
                    });'
            ]); ?>

    <?= $form->field($model, 'ward_id') ->dropDownList(
        [], [
        'prompt'=>'Select Ward',
        'onchange'=>'
                    $.post("index.php?r=party/ward&id='.'"+$(this).val(), function(data){
                    $("select#pollingunit-uniqueid").html(data);
                    });'
            ]); ?>

    <?= $form->field($model, 'uniqueid') ->dropDownList(
        [], [
        'prompt'=>'Select PollingUnit',
    ]); ?>


        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary','name'=>'submit']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <?php if(isset($_POST['submit'])){
      $uniqueid=$_POST['PollingUnit']['uniqueid'];
        echo GridView::widget([
        'dataProvider' => $searchModel->search($uniqueid),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'party_abbreviation',
            'party_score',
        ],
    ]);
    }?>
</div><!-- viewpollingunitresult -->
