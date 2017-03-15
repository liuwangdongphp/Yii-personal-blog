<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin() ?>
    <?=$form->field($model, "name")->textInput()?>
    <?=$form->field($model, "age")->textInput()?>
    <?=$form->field($model, "email")->textInput()?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::button('取消', ['class' => 'btn btn-danger']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
