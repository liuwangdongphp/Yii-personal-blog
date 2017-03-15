<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;
use yii\web\Controller;
/**
 * Description of HelloController
 *
 * @author Administrator
 */
class HelloController extends Controller{
    //put your code here
   public $layout = "mylayout"; 
    public function actionIndex(){
        //tp5 request();
        //Yii 需要自己实例化
//        $request = \Yii::$app->request;        
//        //$response = Yii::$app->response;
//        $gets = $request->get();
//        $name=$request->get("name");
//        //参数2:字段的默认值
//        $name=$request->get("name","没有姓名");
//        if($request->isGet){
//            echo '这是一个get请求'.'<br>';
//        }
//        echo $request->url.'<br>';
//        echo $request->absoluteUrl.'<br>';
//        echo $request->queryString.'<br>';
//        
//        $header = $request->headers;      
//        echo $header->get("accept-language").'<br>';
//        echo $request->userIP.'<hr>';
//        echo $request->userHost.'<hr>';
//        
//        $response =  \Yii::$app->response;
//        //tp5 json(****,404);状态码
//       // $response->statusCode=404;
//        $response->headers->add("name","zhangsan");  
//        $response->headers->add("server","Nginx");
//        //$response->redirect('http://www.baidu.com', 301)->send();
//        //sendFile适合返回小文件
//        //sendStreamAsFile 适合大文件
//        $response->sendFile('robots.txt');
//        var_dump($name);
        
        
        //session的存储和处理
//        $session =  \Yii::$app->session;
//        //Yii中\Yii::$app->session;用的时候没开会自动开启
//        //$_SESSION PHP原生的代码 session_start();
//        $session['name']="zhangsan";
//            if ($session->isActive) {
//            echo 'session已经开启';
//        } else {
//            echo 'session没有开启';
//        }
//        if(!$session->has("age")){
//            echo 'session中没有存储age';
//        }
//        echo "<br>"."存储的姓名为:".$session['name']."<br>";
//        $session->remove("name");
//        $session->destroy();
        
        
        
        
       //COOKIE的使用
        
        $cookie = \Yii::$app->response->cookies;
        $cookie->add(new \yii\web\Cookie([
        'name' => 'name',
        'value' => 'lisi',
        'expire'=>time() + 60*60*24*7
        ]));

       //浏览器把cookie发给服务器
        $cookie =  \Yii::$app->request->cookies;
        if (isset($cookie['name'])) {
              echo "从浏览器发过来的cookie是:".$cookie['name']."<hr>";            
        }

        
        
    }


    public function actionSayhello(){
        echo 'Hello World';
        return $this->render("index");
    }
    public function actionTest(){
        //参数2数组
        $name =  \Yii::$app->request->get("name");   
        $images =['1.png','2.png','3.png'];
        return $this->render("test",
                ["name"=>$name,
                "pic"=>$images,
                "address"=>"<h1 style='coloe:red;'>河南郑州</h1>"
                ]
                );
    }
}
