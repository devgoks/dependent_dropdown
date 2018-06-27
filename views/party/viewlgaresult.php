<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\States;
use backend\models\Party;


/* @var $this yii\web\View */
/* @var $model backend\models\PollingUnit */
/* @var $form ActiveForm */
?>
<div class="viewlgaresult">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'state_id')->dropDownList(
        ArrayHelper::map(States::find()->all(),'state_id','state_name'),
        [
            'prompt'=>'Select State',
            'onchange'=>'
                    $.post("index.php?r=party/state&id='.'"+$(this).val(), function(data){
                    $("select#lga-lga_id").html(data);
                    });'

        ]); ?>
    <?= $form->field($model, 'lga_id') ->dropDownList(
        [], [
        'prompt'=>'Select LGA',
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary','name'=>'submit']) ?>
    </div>
        </div>
    <?php
    if (isset($_POST['submit'])) {
        $lgaid = $_POST['Lga']['lga_id'];
        $party = ArrayHelper::map(Party::find()->all(), 'partyid', 'partyname');
        foreach ($party as $item => $partyname) {
            $sql = "select sum(party_score) as score from announced_pu_results where party_abbreviation='$partyname'
                and polling_unit_uniqueid IN (select uniqueid from polling_unit where lga_id=$lgaid)";
            $list = Yii::$app->getDb()->createCommand($sql)->queryAll();
            if ($list[0]['score'] == null) {
                echo "<div align='center'>$partyname     Nil <br></div>";
            } else {
                echo "<div align='center'>$partyname     " . $list[0]['score'] . " <br></div>";
            }
        }
    }
    ?>
    <?php ActiveForm::end(); ?>

</div><!-- viewlgaresult -->
