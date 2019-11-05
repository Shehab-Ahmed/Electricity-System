<?php

ob_start();

    session_start();

    $title = "Categories";

    if(isset($_SESSION['userhome'])) {
    function transitionpages($link = NULL, $scan = 3){
        if( $link == '' ){
            $url = "index.php";
        }else {
        if ( isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== '' ) {
            $url  = $_SERVER["HTTP_REFERER"];
            }else {
                $url = "index.php";
            }
        header("refresh:3;$url");
            
        }
    }

    include "ini.ttf";
    $sort = $_GET["sort"];
    $usernow = $_SESSION["login"];
    echo "<h1 class='text-center'>أخر التحديثات الصادرة عن الشركة</h1>";
    ?>
    <div class="buttons-update">
        <div class="container">
            <a class="btn btn-primary" href="info-bill.php">قطع الفواتير</a>
            <a class="btn btn-primary" href="info-push.php">ادراج تسليم</a>
        </div>
    </div>
    <?php 
}else {
    header("location:index.php");
    exit();
}
    
?>