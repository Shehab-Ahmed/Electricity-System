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

    $do = isset($_GET["do"]) ? $_GET["do"] : 'Manage';

    if ( $do ==  'Manage' ) {

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
                <h2 class="text-center">تقرير تسليم المبالغ التي تم استلمها من المشتركين</h2>
                <div class="row">
                <form action="?do=Show-Stmt" method="POST" class="form-group">
                <!--  Start Input Name Member -->
                <div class="text-right col-sm-2 control-label rtl-right stlab">
                    <label class="text-right">المجموعة</label>                               
                </div>
                <div class="col-md-4 rtl-right">
                    <select class="form-control type-shr" name="group_id" required>
                        <?php 
                        foreach ( $rows as $row) {
                            echo "<option value='". $row["group_id"] ."'>" . $row["name_group"] . "</option>" ;
                        }
                        ?>
                    </select>
                </div>
                <!--  End Input Name Member -->
                <!--  Start Input Name Member -->
                <div class="text-right col-sm-2 control-label rtl-right stlab">
                    <label class="text-right">من تارخ</label>                                
                </div>
                <div class="col-md-4 rtl-right">
                    <input type="date" name="datefor" value="<?php echo $today["today"]; ?>" class="form-control">                                
                </div>
                <!--  End Input Name Member -->
                <!--  Start Input Name Member -->
                <div class="text-right col-sm-2 control-label rtl-right stlab">
                    <label class="text-right">الى تاريخ</label>                                
                </div>
                <div class="col-md-4 rtl-right">
                    <input type="date" name="dateto" value="<?php echo $today["today"]; ?>" class="form-control">                                                                                
                </div>
                <div class="col-md-12 rtl-right">
                    <input type="submit" class="submit btn btn-success" value="إضافة">                               
                </div>
                <!--  End Input Name Member -->
                    </form>
                </div> 
            </div> 
        </div>    

    <?php  } else if ( $do == "Show-Stmt" ) {

                if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {

                    echo '<div class="group-print">
                    <div class="no-print">
                        <button>المجموع الكلي</button>
                    </div>
                </div>';

                    $group_id = $_POST["group_id"];
                    $datefor = $_POST["datefor"];
                    $dateto = $_POST["dateto"];

                    $stmt = $con->prepare("SELECT * FROM `ends` JOIN `mem-shr` ON ends.id_mem = `mem-shr`.`sys_id`  WHERE end_date BETWEEN '$datefor' AND '$dateto'  AND mem_group = ? ORDER BY mem_name ASC");
                    $stmt->execute(array($group_id));
                    $rows = $stmt->fetchAll();

                    // Get Statment Collector
                    $stmtcollr = $con->prepare("SELECT SUM(end_cou) AS collector, COUNT(name_id) AS count_coll FROM `ends` JOIN `mem-shr` ON ends.id_mem = `mem-shr`.`sys_id`  WHERE end_date BETWEEN '$datefor' AND '$dateto'  AND mem_group = ? ORDER BY mem_name ASC");
                    $stmtcollr->execute(array($group_id));
                    $Collector = $stmtcollr->fetch();

                    echo "<div class='margin'></div>";
                    echo "<div class='choosing-table choosing-toggle'>";
                    echo "<div class='name-choosing'>";
                        echo "<h1 class='text-center'>تقرير تسليم المبالغ التي تم استلمها من المشتركين</h1>";
                        echo "<h2 class='text-center'>من تاريخ $datefor الى تاريخ  $dateto</h2>";
                    echo "</div>";
                    echo "<table class='table-responsive text-center table-hover'>";
                        echo "<tr>";
                            echo "<td>الرقم</td>";
                            echo "<td>أسم المشترك</td>";
                            echo "<td>رقم الهاتف</td>";
                            echo "<td>المبلغ المسلم</td>";
                        echo "</tr>";

                    foreach ( $rows as $number => $row  ) {
                        $number = $number + 1;
                        $tablesTd++;            
                        if($tablesTd == 26){
                            echo "<tr><td   style='border: none' colspan='11' border='0'><h1 class='text-center'>تقرير تسليم المبالغ التي تم استلمها من المشتركين</h1>";
                            echo "<h2 class='text-center'>من تاريخ $datefor الى تاريخ  $dateto</h2></tr></td>";
                            echo "</div>";
                            echo "<tr>";
                                echo "<td>الرقم</td>";
                                echo "<td>أسم المشترك</td>";
                                echo "<td>رقم الهاتف</td>";
                                echo "<td>المبلغ المسلم</td>";
                            echo "</tr>";
                            $tablesTd = 0;
                        }
                        echo "<tr>";
                            echo "<td>". $number ."</td>";
                            echo "<td>". $row["mem_name"] ."</td>";
                            echo "<td>". $row["nphon"] ."</td>";
                            echo "<td>". $row["end_cou"] ."</td>";
                        echo "</tr>";
                        
                    }

                    echo "</table>";
                echo "</div>";
                echo "<div class='choosing-table all-cho group-all' style='margin:200px'>"; 
                echo "<table class='table-responsive text-center'>";
                    echo '<p class="h1 text-center">المجموع الكلي لتقرير</p>';
                    echo "<h2 class='text-center'>من تاريخ " . $datefor . " الى تاريخ " . $dateto . "</h2>";                
                    echo "<tr>";
                        echo "<td>عد التسليمات</td>";
                        echo "<td>مجموع التسليم</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td>". $Collector["count_coll"] ."</td>";
                        echo "<td>". $Collector["collector"] ."</td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</div>";
                echo '<div class="btn-print">
                    <div class="btn-pri">
                        <button onclick="window.print();return false;">
                         <i class="fa fa-print"> طباعة </i> </button>
                    </div>
                </div>';

                }


        }

    include "footer.php";
}else {
    header("location:index.php");
    exit();
}
    
?>