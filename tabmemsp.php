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
    $sort = $_GET["sort"];
    $usernow = $_SESSION["login"];
    $stmtusers = $con->prepare("SELECT * FROM login WHERE login_id = ?");
    $stmtusers->execute(array($usernow));
    $username = $stmtusers->fetch();
    // Query Is GET Group Exisist
    
    if( $do == "Manage" ) {

        echo "<a href='?do=Togroup'><button>كشف تحصيل القراءت حسب المجموعات</button></a>";
        echo "<a href='?do=Toadad'><button>كشف تحصيل القراءت حسب العدادات المركزية</button></a>";

        ?>
          
    <?php
    }elseif ( $do == "Togroup" ) {
        $select = $con->prepare("SELECT * FROM `groups` WHERE groupuser = ? ");
        $select->execute(array($_SESSION["login"]));
        $rows = $select->fetchAll();

        $todays = $con->prepare("SELECT CURDATE() AS today ");
        $todays->execute(array());
        $today = $todays->fetch();
    ?>
        <div class="form-choosing">
            <div class="add-mem">
            <div class="container">
                <h2 class="text-center">  كشف تحصيل القراءت حسب المجموعة </h2>
                <div class="row">
                <form action="?do=Reading" method="POST" class="form-group">
                <!--  Start Input Name Member -->
                <div class="text-right col-sm-2 control-label rtl-right stlab">
                    <label class="text-right">المجموعة</label>                               
                </div>
                <div class="col-md-4 rtl-right">
                    <select class="form-control type-shr" name="group" required>
                        <option value='0'>,,كافة المجموعات,,</option>
                        <?php 
                        foreach ( $rows as $row) {
                            echo "<option value='". $row["group_id"] ."'>" . $row["name_group"] . "</option>" ;
                        }
                        ?>
                    </select>
                </div>
                <!--  End Input Name Member -->
                <div class="col-md-12 rtl-right">
                    <input type="submit" class="submit btn btn-success" value="إضافة">                               
                </div>
                    </form>
                </div> 
            </div> 
        </div>  
        
    <?php
    }
        elseif ( $do == "Toadad" ) {
            $select = $con->prepare("SELECT * FROM `addad` WHERE whereuser = ? ");
            $select->execute(array($_SESSION["login"]));
            $rows = $select->fetchAll();

            $todays = $con->prepare("SELECT CURDATE() AS today ");
            $todays->execute(array());
            $today = $todays->fetch();
    ?>
        <div class="form-choosing">
            <div class="add-mem">
            <div class="container">
                <h2 class="text-center">كشف تحصيل القراءت حسب العداد المركزي </h2>
                <div class="row">
                <form action="?do=Readadad" method="POST" class="form-group">
                <!--  Start Input Name Member -->
                <div class="text-right col-sm-2 control-label rtl-right stlab">
                    <label class="text-right">المجموعة</label>                               
                </div>
                <div class="col-md-4 rtl-right">
                    <select class="form-control type-shr" name="group" required>
                        <option value='0'>,,كافة النقاط,,</option>
                        <?php 
                        foreach ( $rows as $row) {
                            echo "<option value='". $row["ad_id"] ."'>" . $row["name_ad"] . "</option>" ;
                        }
                        ?>
                    </select>
                </div>
                <!--  End Input Name Member -->
                <div class="col-md-12 rtl-right">
                    <input type="submit" class="submit btn btn-success" value="إضافة">                               
                </div>
                    </form>
                </div> 
            </div> 
        </div>  
        
    <?php
    }elseif ( $do == "Reading" ) {
              
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ) { 
            $group      = $_POST["group"];

            if ( $group == 0 ) {
                $stmt = $con->prepare("SELECT * FROM `mem-shr` JOIN `groups` ON `mem-shr`.mem_group = `groups`.group_id  WHERE  groupuser = ? ORDER BY `mem_name` ASC");
                $stmt->execute(array($usernow));
                $rowcount = $stmt->rowCount();
                $stmts = $stmt->fetchAll();

            }else {
                $stmt = $con->prepare("SELECT * FROM `mem-shr` JOIN `groups` ON `mem-shr`.mem_group = `groups`.group_id  WHERE mem_group = ? AND groupuser = ? ORDER BY `mem_name` ASC");
                $stmt->execute(array($group, $usernow));
                $rowcount = $stmt->rowCount();
                $stmts = $stmt->fetchAll();
            }
            
            if ( $group !== "0" ):
                $nameval = $con->prepare("SELECT * FROM groups WHERE group_id = ?");
                $nameval->execute(array($group));
                $stmtname = $nameval->fetch();
                $nameplace = $stmtname["name_group"];
                else :
                  $nameplace = "كافة المجموعات";  
                ;
            endif;

            echo "<div class='name-choosing'>";
            echo "<h1 class='text-center'> كشف تحصيل القراءت  (". $nameplace .")</h1>";
            echo "</div>";
            echo "<div class='margin'></div>";
            echo "<div class='choosing-table'>"; 
                echo "<table class='table-responsive text-center'>";
                    echo "<tr>";
                        echo "<td>الرقم</td>";
                        echo "<td>الاسم</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                    echo "</tr>";
            foreach ( $stmts as $number => $select ) {
                $tablesTd++;
                    if($tablesTd == 18){
                        echo "<tr border='0' style='border: none'>";
                        echo "<td  style='border: none' colspan='11' border='0'><h1 class='text-center'> كشف تحصيل القراءت  (". $nameplace .")</h1></td>";
                        echo "</tr>";
                    $tablesTd = 0;
                    echo "<tr>";
                        echo "<td>الرقم</td>";
                        echo "<td>الاسم</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                    echo "</tr>";
                    
                    }
                    $num = $number + 1 ;
                    
                        echo "<tr>";
                            echo "<td>" . $num . "</td>";
                            echo "<td>" . $select["mem_name"] . "</td>";
                            echo "<td>". $select["renow"] ."</td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                        echo "</tr>";
                    }
                echo "</table>";
            echo "</div>";
            echo "<div class='btn-print'>";
                echo "<div class='btn-pri'>";
                    echo "<button onclick='window.print()'> <i class='fa fa-print'> طباعة </i> </button>";
                echo "</div>";
            echo "</div>";
            
            }
            
        }elseif ( $do == "Readadad" ) {
              
            if ( $_SERVER["REQUEST_METHOD"] == "POST" ) { 
                $adad      = $_POST["group"];
    
                if ( $adad == 0 ) {
                    $stmt = $con->prepare("SELECT * FROM `mem-shr` JOIN `addad` ON `mem-shr`.id_adad = `addad`.ad_id  WHERE whereuser = ?  ORDER BY `mem_name` ASC");
                    $stmt->execute(array($usernow));
                    $rowcount = $stmt->rowCount();
                    $stmts = $stmt->fetchAll();
                }else {
                    $stmt = $con->prepare("SELECT * FROM `mem-shr` JOIN `addad` ON `mem-shr`.id_adad = `addad`.ad_id  WHERE  id_adad = ? AND whereuser = ? ORDER BY `mem_name` ASC");
                    $stmt->execute(array($adad, $usernow));
                    $rowcount = $stmt->rowCount();
                    $stmts = $stmt->fetchAll();
                }
                if ( $adad !== "0" ):
                    $nameval = $con->prepare("SELECT * FROM addad WHERE ad_id = ?");
                    $nameval->execute(array($adad));
                    $stmtname = $nameval->fetch();
                    $nameplace = $stmtname["name_ad"];
                    else :
                      $nameplace = "كافة النقاط";  
                    ;
                endif;
    
                echo "<div class='name-choosing'>";
                 echo "<h1 class='text-center'> كشف تحصيل القراءت  (". $nameplace .")</h1>";
                echo "</div>";
                echo "<div class='margin'></div>";
                echo "<div class='choosing-table'>"; 
                    echo "<table class='table-responsive text-center'>";
                        echo "<tr>";
                            echo "<td>الرقم</td>";
                            echo "<td>الاسم</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "</tr>";
                foreach ( $stmts as $number => $select ) {
                    $tablesTd++;
                        if($tablesTd == 18){
                            echo "<tr border='0' style='border: none'>";
                            echo "<td  style='border: none' colspan='11' border='0'><h1 class='text-center'> كشف تحصيل القراءت  (". $nameplace .")</h1></td>";
                            echo "</tr>";
                        $tablesTd = 0;
                        echo "<tr>";
                            echo "<td>الرقم</td>";
                            echo "<td>الاسم</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                            echo "<td><span>ق-تاريخ <br>&ensp;&ensp;/ &ensp; / 2019</td>";
                        echo "</tr>";
                        
                        }
                        $num = $number + 1 ;
                        
                            echo "<tr>";
                                echo "<td>" . $num . "</td>";
                                echo "<td>" . $select["mem_name"] . "</td>";
                                echo "<td>".$select["renow"]."</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                echo "</div>";
                echo "<div class='btn-print'>";
                    echo "<div class='btn-pri'>";
                        echo "<button onclick='window.print()'> <i class='fa fa-print'> طباعة </i> </button>";
                    echo "</div>";
                echo "</div>";
                
                }
                
            }
        
    include "footer.php";
}else {
    header("location:index.php");
    exit();
}
    
?>