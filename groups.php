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
            header("refresh:$scan;$url");
        }
    }
    include "ini.ttf";
    $do = isset($_GET["do"]) ? $_GET["do"] : 'Manage';
    $sort = $_GET["sort"];
    $usernow = $_SESSION["login"];
    
    if ( $do == "Manage" ){
        if ( !isset($_GET["seargrou"]) ) {
            $stmt = $con->prepare("SELECT * FROM `groups` WHERE  groupuser = ?");
            $stmt->execute(array($usernow));
            $rows = $stmt->fetchAll();
        }else {
            $input = $_GET["seargrou"];
            $typesear = " groupuser = " . $usernow . " AND " . $_GET["typesear"];
            $memname = search("*","`groups`", $typesear, "'%$input%'","ORDER BY group_id $sort");
            $rows = $memname->fetchAll();
        }
        echo "<div class='container'>";
        echo "<div class='all-btns'>";
            echo "<a href='?do=Addgroup' class='btn btn-primary btn-root'>إضافة مجموعة</a>";            
            echo "<div class='search'>";
                echo "<form action='?do=searchphoto' method='GET'>";
                    echo "<input type='search' value='". $input ."' name='seargrou' placeholder='بحث في ...' class='form-control search' />"; ?>
                    <select class='btn btn-success' name='typesear'>
                        <option value='name_group'>اسم المجموعة</option>
                        <option <?php if ( $_GET["typesear"] == "num_group" ) { echo "selected"; } ?> value='num_group'>رقم المجموعة</option>
                    </select>
                </form>
                <?php 
            echo "</div>"; ?>
            <div class='pull-left sort'>
                <span>ترتيب : </span>
                    <a <?php if( isset($_GET["seargrou"]) ) {echo "href='?seargrou=" . $input . "&typesear=" . $typesear . "&sort=DESC'";} else { echo "href='?sort=DESC'"; } ?> class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?>'>تنازلي</a> |  
                    <a <?php if( isset($_GET["seargrou"]) ) {echo "href='?seargrou=" . $input . "&typesear=" . $typesear . "&sort=ASC'";} else { echo "href='?sort=ASC'"; } ?> class='<?php if (isset($sort) && $sort == "ASC"){echo "color";}elseif (!isset($sort) && $sort !== "ASC"){ echo "color";  }?>'>تصاعدي</a>
                <?php 
            echo "</div>";
            echo "</div>";
        echo "</div>";
        if ( isset($_GET["seargrou"])) {
        $rowcounts = $memname->rowCount();
        if ( $rowcounts > 0 ) {            
        echo "<div class='data-members'>";   
            echo "<table ='table-responsive text-center'>";
                    echo "<tr>";
                        echo "<td>دليل المجموعة</td>";
                        echo "<td>اسم المجموعة</td>";
                        echo "<td>رقم المجموعة</td>";
                        echo "<td>تاريخ الإضافة</td>";
                        echo "<td>عدد المشتركين</td>";
                        echo "<td>التحكم</td>";
                    echo "</tr>";
                    foreach ( $rows as $row ) {
                        $mem_group = $row["group_id"];
                        $stmt = $con->prepare("SELECT * FROM `mem-shr` WHERE mem_group = ?");
                        $stmt->execute(array($mem_group));
                        $rowmem = $stmt->rowCount();
                        
                        echo "<tr>";
                            echo "<td>" . $row["group_id"] . "</td>";
                            if ( isset($_GET["group_id"]) && $_GET["group_id"]   == $row["group_id"] ){
                                echo "<td id='". $row["group_id"] ."'><a  class='red' href='?do=ViewGroup&group_id=" .  $row["group_id"] . "'>" . $row["name_group"] . "</a></td>";
                            }else {
                                echo "<td><a href='?do=ViewGroup&group_id=" .  $row["group_id"] . "'>" . $row["name_group"] . "</a></td>";
                            }
                            echo "<td>" . $row["num_group"] . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            echo "<td>" . $rowmem . "</td>";
                            echo "<td><a href='?do=Deletegroup&group_id=". $row["group_id"] ."' class='text-danger confirm'> حذف </a><a href='?do=Editgroup&group_id=" . $row["group_id"] . "' class='text-success'> تعديل </a></td>";
                        echo "</tr>";
                    }
                }else {
                    echo "<h1 class='text-center'>لا يوجد اي نتائج</h1>";
            
                }
                    echo '<div class="rowcount">عدد النتائج : '. $rowcounts .'</div>';
            }       
                    if ( !isset($_GET["seargrou"]) ) {
                        echo "<div class='data-members'>";   
                            echo "<table ='table-responsive text-center'>";
                                    echo "<tr>";
                                        echo "<td>دليل المجموعة</td>";
                                        echo "<td>اسم المجموعة</td>";
                                        echo "<td>رقم المجموعة</td>";
                                        echo "<td>تاريخ الإضافة</td>";
                                        echo "<td>عدد المشتركين</td>";
                                        echo "<td>التحكم</td>";
                                    echo "</tr>";
                                    foreach ( $rows as $row ) {
                                        $mem_group = $row["group_id"];
                                        $stmt = $con->prepare("SELECT * FROM `mem-shr` WHERE mem_group = ?");
                                        $stmt->execute(array($mem_group));
                                        $rowmem = $stmt->rowCount();
                                        
                                        echo "<tr>";
                                            echo "<td>" . $row["group_id"] . "</td>";
                                            if ( isset($_GET["group_id"]) && $_GET["group_id"]   == $row["group_id"] ){
                                                echo "<td id='". $row["group_id"] ."'><a  class='red' href='?do=ViewGroup&group_id=" .  $row["group_id"] . "'>" . $row["name_group"] . "</a></td>";
                                            }else {
                                                echo "<td><a href='?do=ViewGroup&group_id=" .  $row["group_id"] . "'>" . $row["name_group"] . "</a></td>";
                                            }
                                            echo "<td>" . $row["num_group"] . "</td>";
                                            echo "<td>" . $row["date"] . "</td>";
                                            echo "<td>" . $rowmem . "</td>";
                                            echo "<td><a href='?do=Deletegroup&group_id=". $row["group_id"] ."' class='text-danger confirm'> حذف </a><a href='?do=Editgroup&group_id=" . $row["group_id"] . "' class='text-success'> تعديل </a></td>";
                                        echo "</tr>";
                                    } 
                                }
                echo "</table>";
        echo "</div>";

    }elseif ( $do == "ViewGroup" ) {
        $group_id = $_GET["group_id"];
        $stmt = $con->prepare("SELECT * FROM `mem-shr` WHERE mem_group = ?");
        $stmt->execute(array($group_id));
        $selemem = $stmt->fetchAll(); 
        $rowmem = $stmt->rowCount();
        $select = $con->prepare("SELECT * FROM `groups` WHERE groupuser = ? AND group_id = ?");
        $select->execute(array($usernow,$group_id));
        $rowcountgroups = $select->rowCount();
        $fetch = $select->fetch();

        // Sum Group Going

        $select = $con->prepare("SELECT SUM(relast) AS allrelast,  SUM(renow) AS allrenow  FROM `groups` INNER  JOIN `mem-shr` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE mem_group = ? ");
        $select->execute(array($group_id));
        $sumread = $select->fetch();

        // Sum Group Mony
        $allend = $con->prepare("SELECT SUM(sum_countgo) AS allends, price_going, SUM(shaer) AS shaer FROM `photo` INNER  JOIN `mem-shr` ON `mem-shr`.`sys_id` = `photo`.`sysid_ph` WHERE mem_group = ?");
        $allend->execute(array($group_id));
        $allends = $allend->fetch();

        $give = $con->prepare("SELECT SUM(end_cou) AS allgiveins FROM `ends` INNER  JOIN `mem-shr` ON `mem-shr`.`sys_id` = `ends`.`id_mem` WHERE mem_group = ? AND ends_status = 1");
        $give->execute(array($group_id));
        $togive = $give->fetch();

        $givends = $allends["allends"] - $togive["allgiveins"];
            
        
        $sumgroupgoing =  $sumread["allrenow"] - $sumread["allrelast"];

        // Sum Going Unit Price + Uint Shaer
        $stmt = $con->prepare("SELECT * , SUM(price_sh) AS price_shs FROM `mem-shr` WHERE mem_group = ?");
        $stmt->execute(array($group_id));
        $prish = $stmt->fetch();

        $countgoing = $allends["price_going"];
        if ( $rowcountgroups > 0 ) {
        $latest = $givends - $sumgoinshar;
        echo "<h1 class='text-center no-print'>" . $fetch["name_group"] . "</h1>";
        echo "<div class='container' >";
            echo "<a href='?group_id=" . $fetch["group_id"] . "#". $fetch["group_id"] ."' class='no-print btn-back'><i class='fa fa-arrow-right fa-3x'></i></a>";
            echo "<a class='no-print' href='mrmshar.php?groupid=". $fetch["group_id"] ."'><button>المشتركين</button></a>";
            echo "<a class='no-print' onclick='window.print();' href='mrmshar.php?groupid=". $fetch["group_id"] ."'><button>طباعة</button></a>";

            // Start Bill Print Data

            ?>
            <div class="bill-group ">
                <div class="container">
                    <div class="bill">
                        <table border="1" class="text-center">
                            <h3 class="text-center"> تقارير المجموعة </h3>
                            <p class="pull-left"> رقم المجموعة  : <?php echo $fetch["num_group"] ; ?></p>
                            <p> تاريخ اصدار الفاتورة : <?php echo $fetch["num_group"] ; ?></p>
                            <tr>
                                <td>اسم المجموعة</td>
                                <td>رقم المجموعة</td>
                                <td>عدد المشتركين</td>
                                <td>استهلاك المشتركين</td>
                                <td>مستحقات الاستهلاك</td>
                                <!-- <td>المتاخرات</td> -->
                                <!-- <td>الاجمالي</td> -->
                            </tr>
                            <tr>
                            <?php 
                                echo "<td>" . $fetch["name_group"] . "</td>";                            
                                echo "<td>" . $fetch["num_group"] . "</td>";
                                echo "<td>" . $rowmem ."</td>";
                                echo "<td>" .  $sumgroupgoing . "</td>";
                                echo "<td>" .  $sumgoinshar ." ريال </td>";                
                                // echo "<td>" .  $latest  ." ريال </td>";                
                                // echo "<td>" .  $givends ." ريال </td>";
                            ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php


            // End Bill Print Data

            echo "<a class='no-print' href='mrmshar.php?groupid=". $fetch["group_id"] ."'><button>المشتركين</button></a>";                        
            echo "<div class='detels no-print'>";
                echo "<p> <span>رقم المجموعه</span> <span>:</span> " . $fetch["num_group"] . "</p>";
                echo "<p> <span>اسم المجموعه</span> <span>:</span> " . $fetch["name_group"] . "</p>";
                echo "<p> <span>الملاحضات</span> <span>:</span> " . $fetch["group_title"] . "</p>";
                echo "<p> <span>تاريخ انشاها</span> <span>:</span> " . $fetch["date"] . "</p>";
                echo "<p> <span>عدد المشتركين</span> <span>:</span>" . $rowmem ."</p>";
                echo "<p> <span>استهلاك المشتركين</span> <span>:</span>" .  $sumgroupgoing . "</p>";
                echo "<p> <span> مستحقات الاستهلاك</span> <span>:</span>" .  $sumgoinshar ." ريال </p>";                
                echo "<p> <span>المتاخرات</span> <span>:</span>" .  $latest  ." ريال </p>";                
                echo "<p> <span>الاجمالي</span> <span>:</span>" .  $givends ." ريال </p>";

            echo "</div>";
        echo "</div>";
    }elseif ( $do == "Detelsemem" ) {
        $sys_id = $_GET["sys_id"];
        $select = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
        $select->execute(array($sys_id));
        $fetch = $select->fetch();

        $group_id = $fetch["mem_group"];
        $group = $con->prepare("SELECT * FROM `groups` WHERE group_id = ?");
        $group->execute(array($group_id));
        $groups = $group->fetch(); 
        
        $adad_id = $fetch["id_adad"];
        $adad = $con->prepare("SELECT * FROM `addad` WHERE ad_id = ?");
        $adad->execute(array($adad_id));
        $name_adad = $adad->fetch(); 

        $idmemtopho = $fetch["sys_id"];
        $bills = $con->prepare("SELECT * FROM `photo` WHERE sysid_ph = ?");
        $bills->execute(array($idmemtopho));
        $bill = $bills->fetchAll();
        $countphotomem = $bills->rowCount();

        $mans = $fetch["renow"] - $fetch["relast"];
        $allm = $mans * $fetch["nam_cou"];

        $forshar = $fetch["count_sh"] - $fetch["buyth"];
        echo "<div class='container'>";
            echo  "<h1 class='text-center'>" . $fetch["mem_name"] . "</h1>";
            echo "<a href='?do=Viewmembers&group_id=" . $fetch["mem_group"] . "&sys=". $fetch["sys_id"] ."#" . $fetch["sys_id"] ."' class='btn-back'><i class='fa fa-arrow-right fa-3x'></i></a>";
            echo "<a  href='mrmshar.php?do=Entervalrenew&sysid=". $fetch["sys_id"] ."'><button>ادخال قراءة جديدة</button></a>";                        
            echo "<a  href='?do=Ends&sysid=". $fetch["sys_id"] ."'><button>عرض السجل</button></a>";            
            echo "<a  href='?do=Entervalend&sysid=". $fetch["sys_id"] ."&stat=1'><button>ادراج تسليم</button></a>";
            echo "<a  href='?do=Entervalend&sysid=". $fetch["sys_id"] ."&stat=0'><button>ادراج متاخرات</button></a>";
            echo "<div class='detels'>";
                echo "<p> <span>رقم المشترك </span> <span>:</span> " . $fetch["sys_id"] . "</p>";
                echo "<p> <span>اسم المشترك </span> <span>:</span> " . $fetch["mem_name"] . "</p>";
                echo "<p> <span> الاسم التجاري </span> <span>:</span> " . $fetch["sub_name"] . "</p>";
                echo "<p> <span>العنوان </span> <span>:</span> " . $fetch["title_mem"] . "</p>";
                echo "<p> <span>نوع الاشتراك</span> <span>:</span> " . $fetch["type_mem"] . "</p>";
                echo "<p> <span> القراءة السابقه  </span> <span>:</span> " . $fetch["relast"] . "</p>";
                echo "<p> <span> القراءة الحاليه  </span> <span>:</span> " . $fetch["renow"] . "</p>";
                echo "<p> <span> الاستهلاك  </span> <span>:</span> " . $mans . "</p>";
                echo "<p> <span>سعر الكيلو </span> <span>:</span> " . $fetch["nam_cou"] . "</p>";
                echo "<p> <span>سعر الاشتراك</span> <span>:</span> " . $fetch["count_sh"] . "</p>";
                echo "<p> <span>تكلفة الاشتراك</span> <span>:</span> " . $fetch["buyth"] . "</p>";
                echo "<p> <span>فارق الاشتراك</span> <span>:</span> " . $forshar . "</p>";
                echo "<p> <span>الاشتراك الاسبوعي</span> <span>:</span> " . $fetch["price_sh"] . "</p>";               
                echo "<p> <span>المجموعة</span> <span>:</span> " . $groups["name_group"] . "</p>";
                echo "<p> <span>العداد المركزي</span> <span>:</span> " . $name_adad["name_ad"] . "</p>";
                echo "<p> <span>رقم الهاتف </span> <span>:</span> " . $fetch["nphon"] . "</p>";
                echo "<p> <span> تاريخ الاشتراك </span> <span>:</span> " . $fetch["date"] . "</p>";
                echo "<p> <span>عدد الفواتير</span> <span>:</span> " . $countphotomem . "<a href='?do=Billsmem&sys_id=". $fetch["sys_id"] ."'><button>عرض</button></a></p>";
            echo "</div>";
        echo "</div>";
    }else {
        header("location: ?");
    }
    }elseif ( $do == "Addgroup" ) {
        $stmt = $con->prepare("SELECT * FROM login");
        $stmt->execute();
        $addad = $stmt->fetchAll();
        ?>
    <div class="add-mem">
        <div class="container">
            <h1 class="text-center">إضافة مجموعة</h1>
            <form action="?do=Insertadad" method="POST" class="form-group">
                <div class="row">
                    <!--  Start Input Name Member -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">اسم المجموعة</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <input type="text" value="<?php echo ""; ?>" autocomplete="off" name="name_group" class="form-control" placeholder="ادخل اسم المجموعة" required pattern=".{4,}" title="يجب الايكون اسم المشترك اقل من  4 احرف">                                
                    </div>
                    <!--  End Input Name Member -->
                    <!--  Start Input Name Member -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">رقم المجموعة</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <input type="number" autocomplete="off" name="num_group" class="form-control" placeholder="ادخل رقم المجموعة" required>                                
                    </div>
                    <!--  End Input Name Member -->
                    <!--  Start Input Name Member -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">إضافة ملاحظة</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <input type="text" autocomplete="off" name="group_title" class="form-control" placeholder="ادخل ملاحظة" >                                
                    </div>
                    <!--  End Input Name Member -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">ترحيل لحساب</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <select class="form-control type-shr" name="groupuser" required>
                            <option value='0'>...</option>
                            <?php 
                                foreach ( $addad as $row) {
                                    echo "<option value='". $row["login_id"] ."'>" . $row["username"] . "</option>" ;
                                }
                            ?>
                        </select>                                
                    </div>
                    <div class="col-md-12 rtl-right">
                        <input type="submit" class="submit btn btn-success" value="إضافة">                               
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
} elseif ( $do == "Insertadad" ) {
    if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
        $name_group    = $_POST["name_group"];
        $num_group   = $_POST["num_group"];
        $group_title   = $_POST["group_title"];
        $groupuser   = $_POST["groupuser"];
        $formerror = array();
        if ( empty($name_group) ) {
            $formerror[] = "لايمكنك ترك حقل اسم المجموعة فارغ";
        }
        if ( empty($formerror) ){
            $exes = $con->prepare("SELECT name_group FROM `groups` WHERE name_group = ?");
            $exes->execute(array($name_group));
            $ron = $exes->rowCount();
            if ( $ron == 0 ) {
                echo "<h1 class='text-center nice-mass'>لقد تم إضافة مجموعة جديدة</h1>";
                $stmt = $con->prepare("INSERT INTO `groups` (`name_group`, `num_group`, `group_title`, `date`,`groupuser`)
                VALUES (:name_group, :num_group, :group_title, now(),:zgroupuser)");
                $stmt->execute(array(
                    "name_group" => $name_group,
                    "num_group" => $num_group,
                    "group_title" => $group_title,
                    "zgroupuser" => $groupuser,
                ));
                transitionpages("back", ".3");
                echo $typemem;
                
            }else {
                echo "<h1 class='text-center nice-mass'>هذا الاسم موجود موسبقاََ</h1>";
                transitionpages("back", 1);
            }
        }else {
            transitionpages("back", 3);
            foreach( $formerror as $errors ){
                echo "<h1 class='text-center nice-mass'>" . $errors . "</h1>";
            }
        }

    } else {
        transitionpages("back", 1);
    }
}elseif ( $do == "Editgroup" ) {
    $group_id = $_GET["group_id"];
    $stmt = $con->prepare("SELECT * FROM groups WHERE group_id = ?");
    $stmt->execute(array($group_id));
    $row = $stmt->fetch();

    $stmt = $con->prepare("SELECT * FROM login");
    $stmt->execute();
    $addad = $stmt->fetchAll();
    ?>
    <div class="add-mem">
        <div class="container">
            <h1 class="text-center">تعديل بيانات المجموعة</h1>
            <form action="?do=Updategro" method="POST" class="form-group">
                <div class="row">
                <input type="hidden" name="group_id" value="<?php echo $row["group_id"]; ?>" />
                    <!--  Start Input Name Member -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">اسم المجموعة</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <input type="text" value="<?php echo $row["name_group"]; ?>" autocomplete="off" name="name_group" class="form-control" placeholder="ادخل اسم المجموعة" required pattern=".{4,}" title="يجب الايكون اسم المشترك اقل من  4 احرف">                                
                    </div>
                    <!--  End Input Name Member -->
                    <!--  Start Input Name Member -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">رقم المجموعة</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <input type="text" value="<?php echo $row["num_group"]; ?>" autocomplete="off" name="num_group" class="form-control" placeholder="ادخل رقم المجموعة" required>                                
                    </div>
                    <!--  End Input Name Member -->
                    <!--  Start Input Name Member -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">إضافة ملاحظة</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <input type="text" value="<?php echo $row["group_title"]; ?>" autocomplete="off" name="group_title" class="form-control" placeholder="ادخل ملاحظة" >                                
                    </div>
                    <!--  End Input Name Member -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">ترحيل لحساب</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <select class="form-control type-shr" name="groupuser" required>
                            <option value='0'>...</option>
                            <?php 
                                foreach ( $addad as $addads) { ?>
                                    <option <?php if ($addads["login_id"] == $row["groupuser"]) { echo "selected"; }  ?> value='<?php echo $addads["login_id"] ?>'> <?php echo $addads["username"]; ?> </option>
                                <?php }
                            ?>
                        </select>                                
                    </div>
                    <div class="col-md-12 rtl-right">
                        <input type="submit" class="submit btn btn-primary" value="حفظ">                               
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    }elseif ( $do == "Updategro" ) {
        $name_group    = $_POST["name_group"];
        $num_group   = $_POST["num_group"];
        $group_title   = $_POST["group_title"];
        $group_id    = $_POST["group_id"];
        $groupuser    = $_POST["groupuser"];
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
            $stmt = $con->prepare("UPDATE `groups` SET `name_group` = ?, `num_group` = ?, `group_title` = ?, groupuser = ? WHERE `groups`.`group_id` = ?");
            $stmt->execute(array($name_group, $num_group,$group_title, $groupuser,$group_id));
            $count = $stmt->rowCount();
            if ( $count == 0 ) {
                echo "<h1 class='text-center nice-mass'>لايوجد اي تغيير</h1>";
                echo  transitionpages("back", ".4");
            }else{
                echo "<h1 class='text-center nice-mass'>تم حفظ الغيير</h1>";
                echo  transitionpages("back", ".4");
            }
        }else {
            header("location: groups.php");
        }
    }elseif ( $do == "Deletegroup" ) {
        $group_id = $_GET["group_id"];
        $stmt = $con->prepare("DELETE FROM `groups` WHERE `group_id` = ?");
        $stmt->execute(array($group_id));
        header("location: groups.php");
        echo "<h1 class='text-center'>تم حذف المجموعة بنجاح</h1>";
    }
    include "footer.php";
} else {
    header("location:index.php");
	exit();
}
