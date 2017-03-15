<?php
use yii\widgets\LinkPager;

?>
<?php foreach ($countries as $key=>$value) { ?>

<h1><?= $value["code"]?>------<?= $value["name"]?></h1>
<?php } ?>
<div id="pagination"><?= LinkPager::widget(['pagination' => $pagination]) ?></div>
<hr>
<?php foreach ($countries as $key=>$value): ?>
<h1><?= $value["code"]?>------<?= $value["name"]?></h1>
<?php endforeach;?>
