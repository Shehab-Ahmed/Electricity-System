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
    // Query Is GET Group Exisist
    
    if ( $do == "Manage" ){ ?>
        <div class="choosing">
            <div class="container">
                <a href="?do=memberchoosing" class=" btn btn-primary" title="تقرير تحصيل  المبالغ">تقرير تحصيل</a>
                <a href="?do=billschoosing" class="btn btn-primary" title="تقرير شامل للمشتركين بدون متأخرات">تقرير شامل</a>
                <a href="info-references-push.php" class="btn btn-primary" title="تقرير تسليم المبالغ التي تم استلمها من المشتركين">تقرير تسليم</a>

            </div>
        </div>            
    <?php
    } elseif( $do == "memberchoosing" ) {
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
                <h2 class="text-center">تقرير تحصيل المبالغ من المشتركين</h2>
                <div class="row">
                <form action="?do=choosemem" method="POST" class="form-group">
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
    <?php
    }
    elseif( $do == "billschoosing" ) {
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
                <h2 class="text-center">تقرير شامل للمشتركين بدون متأخرات</h2>
                <div class="row">
                <form action="?do=choosephoto" method="POST" class="form-group">
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
    <?php
    }elseif( $do == "adadchoosing" ) {

        echo '<div class="btn-print">
                    <div class="btn-pri">
                        <button onclick="window.print();return false;">
                         <i class="fa fa-print"> طباعة </i> </button>
                    </div>
                </div>';
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
                <h2 class="text-center">تقرير  تفصيلي للعدادات المركزية</h2>
                <div class="row">
                <form action="?do=choosemem" method="POST" class="form-group">
                <!--  Start Input Name Member -->
                <div class="text-right col-sm-2 control-label rtl-right stlab">
                    <label class="text-right">العداد</label>                               
                </div>
                <div class="col-md-4 rtl-right">
                    <select class="form-control type-shr" name="addad" required>
                        <option value='0'>,,كافة العدادات,,</option>
                        <?php 
                        foreach ( $rows as $row) {
                            echo "<option value='". $row["addad"] ."'>" . $row["name_ad"] . "</option>" ;
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
    <?php
    }elseif ( $do == "choosemem" ) {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ) { 
            $group      = $_POST["group"];
            $datefor    = $_POST["datefor"];
            $dateto     = $_POST["dateto"];
            echo '<div class="group-print">
                    <div class="no-print">
                        <button>المجموع الكلي</button>
                    </div>
                </div>';
            echo '<div class="btn-print">
                    <div class="btn-pri">
                        <button onclick="window.print();return false;">
                         <i class="fa fa-print"> طباعة </i> </button>
                    </div>
                </div>';
            if ( $group == 0 ) {
                $stmt = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND groupuser = ? ORDER BY `mem_name` ASC");
                $stmt->execute(array($usernow));
                $rowcount = $stmt->rowCount();
                $stmts = $stmt->fetchAll();

                $allclom = $con->prepare("SELECT SUM(shaer) AS shaersum , SUM(ph_descount) bii_descount, SUM(count_go) AS goin, SUM(price_going) AS price_goingsum, SUM(latest) AS latestsum, SUM(all_clom) AS all_sum FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND groupuser = ?  ORDER BY `mem_name` ASC");
                $allclom->execute(array($usernow));
                $allcloms = $allclom->fetch();
            }else {
                $stmt = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND mem_group = ? AND groupuser = ? ORDER BY `mem_name` ASC");
                $stmt->execute(array($group, $usernow));
                $rowcount = $stmt->rowCount();
                $stmts = $stmt->fetchAll();
                
                $allclom = $con->prepare("SELECT SUM(shaer) AS shaersum , SUM(count_go) AS goin, SUM(price_going) AS price_goingsum, SUM(latest) AS latestsum, SUM(all_clom) AS all_sum FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND mem_group = ? AND groupuser = ?  ORDER BY `mem_name` ASC");
                $allclom->execute(array($group, $usernow));
                $allcloms = $allclom->fetch();
            }
            
            $for = str_replace("-", "/", $datefor);
            $to = str_replace("-", "/", $dateto);
            echo "<div class='name-choosing choosing-toggle'>";
                echo "<h1 class='text-center'>تقرير  تحصيل  المبالغ من المشتركين</h1>";
                echo "<h2 class='text-center'>من تاريخ " . $for . " الى تاريخ " . $to . "</h2>";
            echo "</div>";   
            echo "<div class='margin choosing-toggle'></div>";
            echo "<div class='choosing-table choosing-toggle'>"; 
                echo "<table class='table-responsive text-center'>";
                    echo "<tr>";
                        echo "<td>العدد</td>";
                        echo "<td>الاسم</td>";
                        // echo "<td>الاشتراك</td>";
                        // echo "<td>الاستهلاك</td>";
                        // echo "<td>سعر الوحدة</td>";
                        // echo "<td>قيمة الاستهلاك</td>";
                        // echo "<td>المتاخرات</td>";
                        echo "<td>رقم الهاتف</td>";
                        echo "<td>الاجمالي</td>";                        
                        echo "<td>المُسلم</td>";                        
                    echo "</tr>";
            foreach ( $stmts as $number => $select ) {
                $tablesTd++;            
            if($tablesTd == 26){
                echo "<tr><td   style='border: none' colspan='11' border='0'><h1 class='text-center'>تقرير  تحصيل  المبالغ من المشتركين</h1>";
                echo "<h2 class='text-center'>من تاريخ" . $for . " الى تاريخ " . $to . "</h2></tr></td>";
            echo "</div>";
            echo "<tr>";
                        echo "<td>العدد</td>";
                        echo "<td>الاسم</td>";
                        // echo "<td>الاشتراك</td>";
                        // echo "<td>الاستهلاك</td>";
                        // echo "<td>سعر الوحدة</td>";
                        // echo "<td>قيمة الاستهلاك</td>";
                        // echo "<td>المتاخرات</td>";
                        echo "<td>رقم الهاتف</td>";
                        echo "<td>الاجمالي</td>";                                                
                        echo "<td>المُسلم</td>";
                    echo "</tr>";
            $tablesTd = 0;
            
            }
                    $num = $number + 1 ;
                        echo "<tr>";
                            echo "<td>" . $num . "</td>";
                            echo "<td style='width: 300px'>" . $select["mem_name"] . "</td>";
                            // echo "<td>" . $select["shaer"] . "</td>";
                            // echo "<td>" . $select["count_go"] . "</td>";
                            // echo "<td>" . $select["count_price"] . "</td>";
                            // echo "<td>" . $select["price_going"] . "</td>";
                            // echo "<td>" . $select["latest"] . "</td>";
                            echo "<td style='width: 200px'>" . $select["nphon"] . "</td>";                            
                            echo "<td  style='width: 200px'>" . $select["all_clom"] . "</td>";
                            echo "<td style='width: 200px'></td>";
                        echo "</tr>";
                    }
                echo "</table>";
            echo "</div>";
            echo "<div class='choosing-table all-cho'>"; 
                echo "<table class='table-responsive text-center'>";
                echo '<p class="h1 text-center">المجموع الكلي لتقرير</p>';
                echo "<h2 class='text-center'>من تاريخ " . $for . " الى تاريخ " . $to . "</h2>";                
                echo "<tr>";
                    echo "<td>عدد المشتركين</td>";
                    // echo "<td>مجمل الاشتراكات</td>";
                    // echo "<td>مجمل الاستهلاك</td>";
                    // echo "<td>مجمل قيمة الاستهلاك</td>";
                    // echo "<td>مجمل المتاخرات</td>";
                    echo "<td>مجمل الاجمالي</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>". $rowcount ."</td>";
                    // echo "<td>". $allcloms["shaersum"] ."</td>";
                    // echo "<td>". $allcloms["goin"] ."</td>";
                    // echo "<td>". $allcloms["price_goingsum"] ."</td>";
                    // echo "<td>". $allcloms["latestsum"] ."</td>";
                    echo "<td>". $allcloms["all_sum"] ."</td>";
                echo "</tr>";
                echo "</table>";
            }
            
        }
        elseif ( $do == "choosephoto" ) {
            if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
                echo '<div class="btn-print">
                    <div class="btn-pri">
                        <button onclick="window.print();return false;">
                         <i class="fa fa-print"> طباعة </i> </button>
                    </div>
                </div>';
                echo '<div class="group-print">
                    <div class="no-print">
                        <button>المجموع الكلي</button>
                    </div>
                </div>';
                $group      = $_POST["group"];
                $datefor    = $_POST["datefor"];
                $dateto     = $_POST["dateto"];
                if ( $group == 0 ) {
                    $stmt = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND groupuser = ? ORDER BY `mem_name` ASC");
                    $stmt->execute(array($usernow));
                    $rowcount = $stmt->rowCount();
                    $stmts = $stmt->fetchAll();
    
                    $allclom = $con->prepare("SELECT SUM(shaer) AS shaersum ,SUM(ph_descount) AS bill_descount, SUM(count_go) AS goin, SUM(price_going) AS price_goingsum, SUM(latest) AS latestsum, SUM(all_clom) AS all_sum FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND groupuser = ?  ORDER BY `mem_name` ASC");
                    $allclom->execute(array($usernow));
                    $allcloms = $allclom->fetch();
                }else {
                    $stmt = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND mem_group = ? AND groupuser = ? ORDER BY `mem_name` ASC");
                    $stmt->execute(array($group, $usernow));
                    $rowcount = $stmt->rowCount();
                    $stmts = $stmt->fetchAll();
                    
                    $allclom = $con->prepare("SELECT SUM(shaer) AS shaersum ,SUM(ph_descount) AS bill_descount , SUM(count_go) AS goin, SUM(price_going) AS price_goingsum, SUM(latest) AS latestsum, SUM(all_clom) AS all_sum FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND mem_group = ? AND groupuser = ?  ORDER BY `mem_name` ASC");
                    $allclom->execute(array($group, $usernow));
                    $allcloms = $allclom->fetch();
                }
                
                $for = str_replace("-", "/", $datefor);
                $to = str_replace("-", "/", $dateto);
    
                echo "<div class='margin'></div>";
                echo "<div class='choosing-table choosing-toggle'>";
                echo "<div class='name-choosing'>";
                    echo "<h1 class='text-center'>تقرير شامل  للمشتركين بدون متأخرات</h1>";
                    echo "<h2 class='text-center'>من تاريخ " . $for . " الى تاريخ " . $to . "</h2>";
                echo "</div>";
                    echo "<table class='table-responsive text-center'>";
                        echo "<tr>";
                            echo "<td>العدد</td>";
                            echo "<td>الاسم</td>";
                            echo "<td>الاشتراك</td>";
                            echo "<td>الخصم</td>";
                            echo "<td>الاستهلاك</td>";
                            echo "<td>سعر الوحدة</td>";
                            echo "<td>قيمة الاستهلاك</td>";
                            echo "<td>الاجمالي</td>";
                        echo "</tr>";
                foreach ( $stmts as $number => $select ) {

                    $tablesTd++;            
                    if($tablesTd == 26){
                        echo "<tr><td   style='border: none' colspan='11' border='0'><h1 class='text-center'>تقرير شامل  للمشتركين بدون متأخرات</h1>";
                            echo "<h2 class='text-center'>من تاريخ " . $for . " الى تاريخ " . $to . "</h2></tr></td>";
                        echo "</div>";
                        echo "<tr>";
                            echo "<td>العدد</td>";
                            echo "<td>الاسم</td>";
                            echo "<td>الاشتراك</td>";
                            echo "<td>الخصم</td>";
                            echo "<td>الاستهلاك</td>";
                            echo "<td>سعر الوحدة</td>";
                            echo "<td>قيمة الاستهلاك</td>";
                            echo "<td>الاجمالي</td>";                                                
                        echo "</tr>";
                        $tablesTd = 0;
                    }
                        $num = $number + 1 ;
                        $goinplssh = $allcloms["price_goingsum"] + $allcloms["shaersum"] - $allcloms["bill_descount"]; // Sum All Pricein Plus Shar
                        
                        $sumgoin = $select["price_going"] + $select["shaer"] - $select["ph_descount"]; // Sum Going Plus Shar
                            echo "<tr>";
                                echo "<td>" . $num . "</td>";
                                echo "<td>" . $select["mem_name"] . "</td>";
                                echo "<td>" . $select["shaer"] . "</td>";
                                echo "<td>" . $select["ph_descount"] . "</td>";
                                echo "<td>" . $select["count_go"] . "</td>";
                                echo "<td>" . $select["count_price"] . "</td>";
                                echo "<td>" . $select["price_going"] . "</td>";
                                echo "<td>" . $sumgoin . "</td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                echo "</div>";
                echo "<div class='choosing-table all-cho group-all' style='margin:200px'>"; 
                    echo "<table class='table-responsive text-center'>";
                    echo '<p class="h1 text-center">المجموع الكلي لتقرير</p>';
                    echo "<h2 class='text-center'>من تاريخ " . $for . " الى تاريخ " . $to . "</h2>";                
                    echo "<tr>";
                        echo "<td>عدد المشتركين</td>";
                        echo "<td>مجمل الاشتراكات</td>";
                        echo "<td>مجمل الخصومات</td>";
                        echo "<td>مجمل الاستهلاك</td>";
                        echo "<td>مجمل قيمة الاستهلاك</td>";
                        echo "<td>مجمل الاجمالي</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td>". $rowcount ."</td>";
                        echo "<td>". $allcloms["shaersum"] ."</td>";
                        echo "<td>". $allcloms["bill_descount"] ."</td>";
                        echo "<td>". $allcloms["goin"] ."</td>";
                        echo "<td>". $allcloms["price_goingsum"] ."</td>";
                        echo "<td>". $goinplssh ."</td>";
                    echo "</tr>";
                    echo "</table>";
                }
                
            }

        elseif ( $do == "chooseadad" ) {
            //if ( $_SERVER["REQUEST_METHOD"] == "POST" ) { 
                $group      = $_POST["group"];
                $datefor    = $_POST["datefor"];
                $dateto     = $_POST["dateto"];
   // echo "hello";
                /*if ( $group == 0 ) {
                    $stmt = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `addad` ON `mem-shr`.`id_adad` = `addad`.`id_ad` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND groupuser = ? ORDER BY `mem_name` ASC");
                    $stmt->execute(array($usernow));
                    $rowcount = $stmt->rowCount();
                    $stmts = $stmt->fetchAll();
    
                    $allclom = $con->prepare("SELECT SUM(shaer) AS shaersum , SUM(count_go) AS goin, SUM(price_going) AS price_goingsum, SUM(latest) AS latestsum, SUM(all_clom) AS all_sum FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE ( date_ver BETWEEN '$datefor' AND '$dateto' ) AND groupuser = ?");
                    $allclom->execute(array($usernow));
                    $allcloms = $allclom->fetch();
                }else { */
                    
                    
                    $allclom = $con->prepare("SELECT SUM(shaer) AS shaersum , SUM(count_go) AS goin, SUM(price_going) AS price_goingsum, SUM(latest) AS latestsum, SUM(all_clom) AS all_sum FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `addad` ON `mem-shr`.`id_adad` = `addad`.`ad_id` WHERE ( date_ver BETWEEN '2019-02-12' AND '2019-03-16' ) AND `id_adad` = 29 AND whereuser = 17 ORDER BY `mem_name` ASC");
                    $allclom->execute(array($group, $usernow));
                    $allcloms = $allclom->fetch();
                    
                //}
                $stmt = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `addad` ON `mem-shr`.`id_adad` = `addad`.`ad_id` WHERE ( date_ver BETWEEN '2019-02-12' AND '2019-03-16' ) AND `id_adad` = 29 AND whereuser = 17 ORDER BY `mem_name` ASC");
                    $stmt->execute();
                    $rowcount = $stmt->rowCount();
                    $stmts = $stmt->fetchAll();
                $for = str_replace("-", "/", $datefor);
                $to = str_replace("-", "/", $dateto);
    
                echo "<div class='name-choosing'>";
                    echo "<h1 class='text-center'>تقرير استهلاك العداد المركزي الكيبل الرئيسي</h1>";
                    echo "<h2 class='text-center'>من تاريخ 2019-02-28 الى تاريخ 2019-03-10</h2>";
                echo "</div>";
                echo "<div class='margin'></div>";
                echo "<div class='choosing-table'>"; 
                    echo "<table class='table-responsive text-center'>";
                        echo "<tr>";
                            echo "<td>العدد</td>";
                            echo "<td>الاسم</td>";
                            echo "<td>الاشتراك</td>";
                            echo "<td>الاستهلاك</td>";
                            echo "<td>سعر الوحدة</td>";
                            echo "<td>قيمة الاستهلاك</td>";
                            echo "<td>المتاخرات</td>";
                            echo "<td>الاجمالي</td>";
                        echo "</tr>";
                foreach ( $stmts as $number => $select ) {
                        $num = $number + 1 ;
                            echo "<tr>";
                                echo "<td>" . $num . "</td>";
                                echo "<td>" . $select["mem_name"] . "</td>";
                                echo "<td>" . $select["shaer"] . "</td>";
                                echo "<td>" . $select["count_go"] . "</td>";
                                echo "<td>" . $select["count_price"] . "</td>";
                                echo "<td>" . $select["price_going"] . "</td>";
                                echo "<td>" . $select["latest"] . "</td>";
                                echo "<td>" . $select["all_clom"] . "</td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                echo "</div>";
                echo "<div class='choosing-table all-cho' style='margin:200px'>"; 
                    echo "<table class='table-responsive text-center'>";
                    echo '<p class="h1 text-center">المجموع الكلي لتقرير</p>';
                    echo "<h2 class='text-center'>من تاريخ 2019-02-28 الى تاريخ 2019-03-10</h2>";                
                    echo "<tr>";
                        echo "<td>عدد المشتركين</td>";
                        echo "<td>مجمل الاشتراكات</td>";
                        echo "<td>مجمل الخصومات</td>";
                        echo "<td>مجمل الاستهلاك</td>";
                        echo "<td>مجمل قيمة الاستهلاك</td>";
                        echo "<td>مجمل المتاخرات</td>";
                        echo "<td>مجمل الاجمالي</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td>". $rowcount ."</td>";
                        echo "<td>". $allcloms["shaersum"] ."</td>";
                        echo "<td>". $allcloms["goin"] ."</td>";
                        echo "<td>". $allcloms["goin"] ."</td>";
                        echo "<td>". $allcloms["price_goingsum"] ."</td>";
                        echo "<td>". $allcloms["latestsum"] ."</td>";
                        echo "<td>". $allcloms["all_sum"] ."</td>";
                    echo "</tr>";
                    echo "</table>";
                }
                
            //}

    include "footer.php";
}else {
    header("location:index.php");
    exit();
}
    
?>