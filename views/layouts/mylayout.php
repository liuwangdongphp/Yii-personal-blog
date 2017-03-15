<?php $this->beginPage() ?>
<html>
    <head>
        <title>title</title>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <h1>自定义头部</h1>
        <!--======================================================================-->
        
        <?php echo $content;?>

        
        <!--======================================================================-->
         <h1>自定义尾部</h1>
         <?php $this->endBody() ?>
    </body>    
</html>
<?php $this->endPage() ?>