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
    $do = isset($_GET["do"]) ? $_GET["do"] : 'Manage';

    // Get User Regiester Now
    $usernow = $_SESSION["login"];

    // Get Count Members
    $select = $con->prepare("SELECT * FROM `mem-shr` JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ?");
    $select->execute(array($usernow));
    $membersCount = $select->rowCount();

    // Get Count Bills
    $select = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ?");
    $select->execute(array($usernow));
    $billsCount = $select->rowCount();

    if ( $do == "Manage") { ?>
        <div class="items">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a href="info-bill.php">
                            <div class="box-item">    
                                <i class="fa fa-object-ungroup fa-5x"></i>
                                <h2>إضافة فواتير</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="mrmshar.php?do=Addsha">
                            <div class="box-item item-1">    
                                <i class="fa fa-user-plus fa-5x"></i>
                                <h2>إضافة مشترك</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="addadd.php?do=AddAdada">
                            <div class="box-item">    
                                <i class="fa fa-sliders fa-5x"></i>
                                <h2>إضافة نقطة</h2>
                            </div>
                        </a>
                    </div>
                </div>    
            </div>
        </div>
        <div class="data-home">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="data">
                            <p>عدد الفواتير :  <?php echo $billsCount; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="data">
                            <p> عدد المشتركين : <?php echo $membersCount; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="data">
                            <p> عدد النقاط : <?php echo sumallcol("*","addad", "whereuser = $usernow"); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    }else {
        header("location:index.php");
        exit();
    }