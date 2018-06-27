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
<div class="newpollingunit">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model3, 'state_id')->dropDownList(
        ArrayHelper::map(States::find()->all(),'state_id','state_name'),
        [
            'prompt'=>'Select State',
            'onchange'=>'
                    $.post("index.php?r=party/state&id='.'"+$(this).val(), function(data){
                    $("select#pollingunit-lga_id").html(data);
                    });'

        ]); ?>
    <?= $form->field($model2, 'lga_id') ->dropDownList(
        [], [
        'prompt'=>'Select LGA',
        'onchange'=>'
                    $.post("index.php?r=party/lga&id='.'"+$(this).val(), function(data){
                    $("select#pollingunit-ward_id").html(data);
                    });'
    ]); ?>

    <?= $form->field($model2, 'ward_id') ->dropDownList([], ['prompt'=>'Select Ward']); ?>

        <?= $form->field($model2, 'polling_unit_name') ?>
        <?= $form->field($model2, 'polling_unit_number') ?>
        <?= $form->field($model2, 'polling_unit_id') ?>
        <?= $form->field($model2, 'polling_unit_description') ?>
        <?= $form->field($model, 'entered_by_user') ?>
        <?php
        $party = ArrayHelper::map(Party::find()->all(), 'partyid','partyname');
        foreach ($party as $id => $name) {
            echo "<div class=\"row\">";
            echo "<div class=\"col-md-6\">";
            echo $form->field($model,'party_abbreviation')->textInput(['value'=>$name,'name' => 'party_abbreviation[]','readOnly'=>true]);
            echo "</div>";
            echo "<div class=\"col-md-6\">";
            echo $form->field($model,'party_score')->textInput(['name' => 'party_score[]']) ;
            echo "</div>";
            echo "</div>";
        } ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary','name'=>'submit']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- newpollingunit -->
