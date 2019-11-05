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
    
    if ( isset($_GET["groupid"]) ){
        $groupids = "groupid=" .  $_GET["groupid"] . "&";
    }else {
        $groupids= "";
    }
    if ( $do == "Manage" ){
        $select = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? ORDER BY mem_name $sort");
        $select->execute(array($usernow));
        $rows = $select->fetchAll();
        $rowcount = $select->rowCount();
        if ( isset($_GET["groupid"]) ){
            $groupid = $_GET["groupid"];
            $select = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND mem_group = ? ORDER BY mem_name $sort");
            $select->execute(array($usernow,$groupid));
            $rowcountgroup = $select->rowCount();
            if ( $rowcountgroup > 0 ){
                $rows = $select->fetchAll();
                // Query To Get Name Group
                $selegroup = $con->prepare("SELECT * FROM groups WHERE group_id = ?");
                $selegroup->execute(array($groupid));
                $namegroup = $selegroup->fetch();
            }else{
                echo "<div class='h2 nice-mass'>لا يوجد اي مشتركين بهذا الرقم</div>";
            }
        }
        if ( !isset($_GET["searmem"]) ) {
            echo "<div class='container'>";
                echo "<div class='all-btns'>";
                    if ( isset($_GET["groupid"]) && $rowcountgroup > 0 ){
                        echo "<p class='box-group'>مشتركين مجموعة : " . $namegroup["name_group"] . " </p>";
                    }else{
                        echo "<a href='?do=Addsha' class='btn btn-primary btn-root'>إضافة مشترك</a>";   
                    }
                    // Search In Members
                        echo "<div class='search'>";
                        echo "<form action='?do=searchmem' method='GET'>";                    
                        if ( isset($_GET["groupid"]) && $rowcountgroup > 0 ){
                            echo "<input type='hidden' name='groupid' value='". $groupid ."'>";
                        }
                            echo "<input type='search' name='searmem' placeholder='بحث في ...' class='form-control search' />";
                                echo "<select class='btn btn-success' name='typesear'>
                                    <option value='mem_name'>اسم المشترك</option>
                                    <option value='sub_name'>الأسم التجاري</option>
                                    <option value='sys_id'>رقم المشترك</option>
                                    <option value='type_mem'> نوع الاشتراك </option>
                                    <option value='nphon'>رقم الهاتف</option>
                                </select>"; 
                        echo "</form>";
                echo "</div>";
                    if ( isset($_GET["groupid"]) && $rowcountgroup > 0 ){ ?>
                        <div class='pull-left sort'>
                            <span>ترتيب : </span>                    
                            <a href='?groupid=<?php echo $groupid; ?>&sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?>'>تنازلي</a> |  
                            <a href='?groupid=<?php echo $groupid; ?>&sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";}elseif (!isset($sort) && $sort !== "ASC"){ echo "color";  }  ?>'>تصاعدي</a> 
                        <?php
                    }else{ ?>
                        <div class='pull-left sort'>
                            <span>ترتيب : </span>                    
                            <a href='?sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?>'>تنازلي</a> |  
                            <a href='?sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";}elseif (!isset($sort) && $sort !== "ASC"){ echo "color";  }  ?>'>تصاعدي</a> 
                        <?php
                    }
                echo "</div>"; 
                echo "</div>";
                echo "</div>";
                if ( $rowcount > 0 ) {                
                echo "<div class='data-members'>";   
                    echo "<table ='table-responsive text-center'>";
                            echo "<tr>";
                                echo "<td>رقم المشترك</td>";
                                echo "<td>الاسم</td>";
                                echo "<td>الأسم التجاري</td>";
                                echo "<td>الرقم</td>";
                                echo "<td>تاريخ الاشتراك</td>";
                                echo "<td>التحكم</td>";
                            echo "</tr>";
                        foreach ( $rows as $row ) {
                            echo "<tr>";
                                echo "<td>" . $row["sys_id"] . "</td>";
                                if ( isset($_GET["sys"]) && $_GET["sys"]   == $row["sys_id"] ){
                                    echo "<td id='". $row["sys_id"] ."'><a  class='red' href='?".$groupids."do=Detelsemem&sys_id=" .  $row["sys_id"] . "'>" . $row["mem_name"] . "</a></td>";
                                }else {
                                    echo "<td><a href='?".$groupids."do=Detelsemem&sys_id=" .  $row["sys_id"]."'>" . $row["mem_name"] . "</a></td>";
                                }
                                echo "<td>" . $row["sub_name"] . "</td>";
                                echo "<td>" . $row["nphon"] . "</td>";
                                //echo "<td>" . $allcount = $row["renow"] - $row["relast"] . "</td>";
                                echo "<td>" . $row["date"] . "</td>";
                                echo "<td><a href='?do=Deletedmem&sysid=". $row["sys_id"] ."' class='text-danger confirm'> حذف </a> <a href='?do=Edmem&sys_id=" . $row["sys_id"] . "' class='text-success'> تعديل </a></td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                echo "</div>";
            } else{
                echo "<div class='h2 nice-mass text-center'>لا يوجد مشتركين</div>";
            }           
            }else {
                $input = $_GET["searmem"];
                $typesear = $_GET["typesear"];
                $groupinlike = $_GET["groupid"];
                echo $groupinlike;
                echo "<div class='container'>";
                echo "<div class='all-btns'>";
                    if ( isset($_GET["groupid"]) && $rowcountgroup > 0 ){
                        echo "<p class='box-group'>مشتركين مجموعة : " . $namegroup["name_group"] . " </p>";
                    }else{
                        echo "<a href='?do=Addsha' class='btn btn-primary btn-root'>إضافة مشترك</a>";   
                    }
                    echo "<div class='search'>";
                    echo "<form action='?do=searchmem' method='GET'>";
                    if ( isset($_GET["groupid"]) && $rowcountgroup > 0 ){
                        echo "<input type='hidden' name='groupid' value='". $groupid ."'>";
                    }
                        echo "<input type='search' value='" . $input . "' name='searmem' placeholder='بحث في ...' class='form-control search' />";
                        echo "<select class='btn btn-success' name='typesear'>";?>
                            <option <?php if ( $typesear == "mem_name" ){echo "selected";} ?> value='mem_name'>اسم المسترك</option>
                            <option <?php if ( $typesear == "sub_name" ){echo "selected";} ?> value='sub_name'>الأسم التجاري</option>
                            <option <?php if ( $typesear == "sys_id" ){echo "selected";} ?> value='sys_id'>رقم المشترك</option>
                            <option <?php if ( $typesear == "type_mem" ){echo "selected";} ?> value='type_mem'> نوع الاشتراك </option>
                            <option <?php if ( $typesear == "nphon" ){echo "selected";} ?> value='nphon'>رقم الهاتف</option>
                        <?php echo "</select>"; 
                    echo "</form>";
                echo "</div>";
                if ( isset($_GET["groupid"]) && $rowcountgroup > 0 ){ ?>
                    <div class='pull-left sort'>
                        <span>ترتيب : </span>                    
                        <a href='?groupid=<?php echo $groupid; ?>&typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?>'>تنازلي</a> |  
                        <a href='?groupid=<?php echo $groupid; ?>&typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";}elseif (!isset($sort) && $sort !== "ASC"){ echo "color";  }?>'>تصاعدي</a>               
                    <?php
                }else{ ?>
                    <div class='pull-left sort'>
                        <span>ترتيب : </span>                    
                        <a href='?typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?>'>تنازلي</a> |  
                        <a href='?typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";}elseif (!isset($sort) && $sort !== "ASC"){ echo "color";  }?>'>تصاعدي</a>               
                    <?php
                }    
                echo "</div>";
                echo "</div>";
                echo "</div>";
                if ( isset($_GET["groupid"]) && $rowcountgroup > 0 ){
                    $typememingrou = "mem_group = " . $groupinlike . " AND " . $typesear;
                    $memname = search("*","`mem-shr`", $typememingrou, "'%$input%'","ORDER BY sys_id $sort");
                    $memnames = $memname->fetchAll();
                    $rowcounts = $memname->rowCount();
                }else {
                    $memname = search("*","`mem-shr`", $typesear, "'%$input%'","ORDER BY sys_id $sort");
                    $memnames = $memname->fetchAll();
                    $rowcounts = $memname->rowCount();
                }
                if ( $rowcounts !== 0 ) {                
                    echo "<div class='data-members'>";   
                        echo "<table ='table-responsive text-center'>";
                                echo "<tr>";
                                    echo "<td>رقم المشترك</td>";
                                    echo "<td>الاسم</td>";
                                    echo "<td>الأسم التجاري</td>";
                                    echo "<td>رقم الهاتف</td>";
                                    echo "<td>تاريخ الاشتراك</td>";
                                    echo "<td>التحكم</td>";
                                echo "</tr>";
                                echo '<div class="rowcount">عدد النتائج : '. $rowcounts .'</div>';
                                foreach ( $memnames as $row ) {
                                    $user = $row["sys_id"];
                                    echo "<tr>";
                                        echo "<td>" . $row["sys_id"] . "</td>";
                                        if ( isset($_GET["sys"]) && $_GET["sys"]   == $row["sys_id"] ){
                                            echo "<td id='". $row["sys_id"] ."'><a  class='red' href='?do=Detelsemem&sys_id=" .  $row["sys_id"] . "'>" . $row["mem_name"] . "</a></td>";
                                        }else {
                                            echo "<td><a href='?do=Detelsemem&sys_id=" .  $row["sys_id"] . "'>" . $row["mem_name"] . "</a></td>";
                                        }
                                        echo "<td>" . $row["sub_name"] . "</td>";
                                        echo "<td>" . $row["nphon"] . "</td>";
                                        echo "<td>" . $row["date"] . "</td>";
                                        echo "<td><a href='?do=Deletedmem&sysid=". $row["sys_id"] ."' class='text-danger confirm'> حذف </a> <a href='?do=Edmem&sys_id=" . $row["sys_id"] . "' class='text-success'> تعديل </a></td>";
                                    echo "</tr>";
                                }
                            }else {
                                echo "<h1 class='text-center'>لا يوجد اي نتائج</h1>";
                        echo "</table>";
                    echo "</div>";
                }
                
            }
    } elseif ( $do == "Addsha" ){
        $select = $con->prepare("SELECT types FROM `types_sar`");
        $select->execute();
        $rows = $select->fetchAll();
        $addad = $con->prepare("SELECT * FROM `addad`");
        $addad->execute();
        $idadd = $addad->fetchAll();
        $groups = $con->prepare("SELECT * FROM `groups`");
        $groups->execute();
        $group = $groups->fetchAll();
        $grouprow = $groups->rowCount();
        if ( $grouprow > 0 ) {
        ?>
            <div class="add-mem">
                <div class="container">
                <h1 class="text-center">إضافة مشترك جديد</h1>
                    <div class="row">
                        <form action="?do=Insertmem" method="POST" class="form-group">
                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">اسم المشترك</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="text" autocomplete="off" name="name-sha" class="form-control" placeholder="ادخل اسم المشترك" required pattern=".{4,}" title="يجب الايكون اسم المشترك اقل من  4 احرف">                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">الأسم التجاري </label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="text" autocomplete="off" name="name-eco" class="form-control" placeholder=" ادخل الاسم التجاري للمشترك" required pattern=".{4,}" title="يجب الايكون الاسم التجاري اقل من  4 احرف">                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">العنوان</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="text" autocomplete="off" name="title" class="form-control" placeholder="ادخل عنوان المشترك" required pattern=".{4,}" title="يجب الايكون عنوان المشترك اقل من  4 احرف">                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">رقم الهاتف</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="number" min="0" autocomplete="off" name="phon" class="form-control" placeholder="ادخل رقم هاتف المشترك" required pattern=".{6,}" title="يجب الايكون رقم الهاتف اقل من  6 ارقام">                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">سعر الكيلوا</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="number" min="0" autocomplete="off" name="unitkl" class="form-control" placeholder="ادخل سعر الكيلوا للمشترك" required>                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">القراءة السابقه</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="number" min="0" autocomplete="off" name="relast" class="form-control" placeholder="ادخل القراة السابقه">                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">القراءة الحاليه</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="number" min="0" autocomplete="off" name="renow" class="form-control" placeholder="ادخل اخر قراءة" >                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">سعر الاشتراك</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="number" min="0" autocomplete="off" name="sharco" class="form-control" placeholder="ادخل سعر الاشتراك" required>                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">تكلفة الاشتراك</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="number"  min="0" autocomplete="off" name="price-sh" class="form-control" placeholder="ادخل تكلفة الاشتراك" required>                                
                            </div>
                            <!--  End Input Name Member -->
                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">الاشتراك</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="number" min="0" autocomplete="off" name="price-count" class="form-control" placeholder="ادخل قيمة الاشتراك الاسبوعي" required>                                
                            </div>
                            <!--  End Input Name Member -->
                            <!--  Start Input Name Descount -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">الخصم</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="number" min="0" autocomplete="off" name="descount" class="form-control" placeholder="ادخل قيمة الاشتراك الاسبوعي" required>                                
                            </div>
                            <!--  End Input Name Descount -->
                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">نوع الاشتراك</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <select class="form-control type-shr" name="typeshr" required>
                                    <option value='0'>...</option>
                                    <?php 
                                        foreach ( $rows as $row) {
                                            echo "<option value='". $row["types"] ."'>" . $row["types"] . "</option>" ;
                                        }
                                    ?>
                                </select>                                
                            </div>
                            <!--  End Input Name Member -->
                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">العداد المركزي</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <select class="form-control type-shr" name="addad" required>
                                <option value='0'>...</option>
                                    <?php 
                                        foreach ( $idadd as $adads) {
                                            echo "<option value='". $adads["ad_id"] ."'>" . $adads["name_ad"] . "</option>" ;
                                        }
                                    ?>
                                </select>                                
                            </div>
                            <!--  End Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">اسم المجموعة</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <select class="form-control type-shr" name="group" required>
                                <option value='0'>...</option>
                                    <?php 
                                        foreach ( $group as $gro) {
                                            echo "<option value='". $gro["group_id"] ."'>" . $gro["name_group"] . "</option>" ;
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
        }else {
            echo "<h1 class='text-center nice-mass margintop'>لايُمكنك إضافة مشتركين يجب إضافة مجموعة لتتمكن من إضافة مشتركين</h1>";
            echo "<h2 class='text-center nice-mass'>سيتم تحويلك بعد 3 ثواني</h2>";
            header("refresh:3;groups.php?do=Addgroup");
        
        }
    } elseif ( $do == "Insertmem" ) {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
            $namesha        = filter_var($_POST["name-sha"], FILTER_SANITIZE_STRING);
            $nameeco        = filter_var($_POST["name-eco"], FILTER_SANITIZE_STRING);
            $title          = filter_var($_POST["title"], FILTER_SANITIZE_STRING);
            $phon           = $_POST["phon"];
            $unitkl         = $_POST["unitkl"];
            $relast         = $_POST["relast"];
            $renow          = $_POST["renow"];
            $sharco         = $_POST["sharco"];
            $pricesh        = $_POST["price-sh"];
            $descount       = $_POST["descount"];
            $price_count    = $_POST["price-count"];
            $typemem        = filter_var($_POST["typeshr"], FILTER_SANITIZE_STRING);
            $addad          = filter_var($_POST["addad"], FILTER_SANITIZE_STRING);
            $group          = filter_var($_POST["group"], FILTER_SANITIZE_STRING);
            $formerror = array();
            if ( $relast > $renow ) {
                $formerror[] = "يجب الا تكون القراءة السابقه اكبر من القراءة الحاليه";
            }
            if ( strlen($namesha) < 4 && !empty($namesha) ) {
                $formerror[] = "يجب ان لايكون اسم المشترك اقل من 4 احرف";
            }
            if ( empty($namesha) ) {
                $formerror[] = "لايمكنك ترك حقل اسم المشترك فارغ";
            }
            if ( strlen($nameeco) < 4 ) {
                $formerror[] = "يجب الايكون حقل الاسم التجاري اقل من 4 احرف";
            }
            if ( empty($nameeco) ) {
                $formerror[] = "لايمكنك ترك حقل الأسم التجاري فارغ";
            }
            if ( strlen($title) < 4 ) {
                $formerror[] = "يجب الايكون حقل العنوان اقل من 4 احرف";
            }
            if ( empty($title) ) {
                $formerror[] = "لايمكنك ترك حقل العنوان فارغ";
            }
            if ( strlen($phon) < 4 ) {
                $formerror[] = "يجب الايكون حقل رقم الهاتف اقل من 9 ارقام";
            }
            if ( empty($phon) ) {
                $formerror[] = "لايمكنك ترك حقل رقم الهاتف فارغ";
            }
            if ( empty($unitkl) ) {
                $formerror[] = "لايمكنك ترك حقل رقم سعر الكيلوا فارغ";
            }
            if ( empty($sharco) ) {
                $formerror[] = "لايمكنك ترك حقل سعر الاشتراك فارغ";
            }
            if ( empty($pricesh) ) {
                $formerror[] = "لايمكنك ترك حقل تكلفة الاشتراك فارغ";
            }
            if ( $typemem == "0" ) {
                $formerror[] = "يجب تحديد نوع الاشتراك";
            }
            if ( $addad == 0 ) {
                $formerror[] = "يجب تحديد العداد المركزي";
            }
            if ( $group == 0 ) {
                $formerror[] = "يجب تحديد المجموعة";
            }
            if ( empty($formerror) ){
                $exes = $con->prepare("SELECT mem_name FROM `mem-shr` WHERE mem_name = ?");
                $exes->execute(array($namesha));
                $ron = $exes->rowCount();
                if ( $ron == 0 ) {
                    $stmt = $con->prepare("INSERT INTO `mem-shr` (`mem_name`, `sub_name`, `title_mem`, `type_mem`, `nphon`, `nam_cou`, `date`, `relast`, `renow`, `count_sh`, `buyth`,`price_sh`,`descount`,`id_adad`,`mem_group`)
                    VALUES (:zmem_shr, :zsub_name, :ztitle_mem, :ztype_mem, :znphon, :znam_cou, now(), :zrelast, :zrenow, :zcount_sh, :zbuyth, :zprice_sh,:zdescount,:zidadad,:zgroup)");
                    $stmt->execute(array(
                        "zmem_shr" => $namesha,
                        "zsub_name" => $nameeco,
                        "ztitle_mem" => $title,
                        "ztype_mem" => $typemem,
                        "znphon" => $phon,
                        "znam_cou" => $unitkl,
                        "zrelast" => $relast,
                        "zrenow" => $renow,
                        "zcount_sh" => $sharco,
                        "zbuyth" => $pricesh,
                        "zprice_sh" => $price_count,
                        "zdescount" => $descount,
                        "zidadad" => $addad,
                        "zgroup" => $group,
                    ));
                    transitionpages("back", 1);
                    echo "<h1 class='text-center nice-mass'>لقد تم اضافة مشترك جديد</h1>";                    
                }else {
                    echo "<h1 class='text-center nice-mass'>هذا الاسم موجود موسبقاََ</h1>";
                    transitionpages("back", 2);
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
    } elseif ( $do == "Edmem" ){
        $sys_id = $_GET["sys_id"];
        $select = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND sys_id = ?");
        $select->execute(array($usernow,$sys_id));
        $edcou = $select->rowCount();
        $rows = $select->fetch();

        $types = $con->prepare("SELECT types FROM `types_sar`");
        $types->execute();
        $typeshr = $types->fetchAll();

        $addad = $con->prepare("SELECT * FROM `addad`");
        $addad->execute();
        $idadd = $addad->fetchAll();
        
        $groups = $con->prepare("SELECT * FROM `groups`");
        $groups->execute();
        $group = $groups->fetchAll();
        $grouprow = $groups->rowCount();
        if ( $grouprow > 0 ) {
            if ( $edcou > 0 ){
        ?>
        <div class="add-mem">
            <div class="container">
            <h1 class="text-center">تعديل بيانات المشترك</h1>
                <form action="?do=Upmem" method="POST" class="form-group">
                    <div class="row">
                        <input type="hidden" name="sysid" value="<?php echo $rows["sys_id"] ?>">
                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">اسم المشترك</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" autocomplete="off" value="<?php echo $rows["mem_name"]; ?>" name="name-sha" class="form-control" placeholder="ادخل اسم المشترك" required pattern=".{4,}" title="يجب الايكون اسم المشترك اقل من  4 احرف">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">الأسم التجاري </label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" autocomplete="off" value="<?php echo $rows["sub_name"]; ?>" name="name-eco" class="form-control" placeholder=" ادخل الاسم التجاري للمشترك" required pattern=".{4,}" title="يجب الايكون الاسم التجاري اقل من  4 احرف">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">العنوان</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" autocomplete="off" value="<?php echo $rows["title_mem"]; ?>" name="title" class="form-control" placeholder="ادخل عنوان المشترك" required pattern=".{4,}" title="يجب الايكون عنوان المشترك اقل من  4 احرف">                                
                        </div>
                        <!--  End Input Name Member -->
                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">رقم الهاتف</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" min="0" autocomplete="off"  value="<?php echo $rows["nphon"]; ?>" name="phon" class="form-control" placeholder="ادخل رقم هاتف المشترك" required pattern=".{6,}" title="يجب الايكون رقم الهاتف اقل من  6 ارقام">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">سعر الكيلوا</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" min="0" autocomplete="off" value="<?php echo $rows["nam_cou"]; ?>" name="unitkl" class="form-control" placeholder="ادخل سعر الكيلوا للمشترك" required>                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">القراءة السابقه</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" min="0" autocomplete="off" value="<?php echo $rows["relast"]; ?>" name="relast" class="form-control" placeholder="ادخل القراة السابقه">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">القراءة الحاليه</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" min="0" autocomplete="off" value="<?php echo $rows["renow"]; ?>" name="renow" class="form-control" placeholder="ادخل اخر قراءة" >                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">سعر الاشتراك</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" min="0" autocomplete="off" value="<?php echo $rows["count_sh"]; ?>" name="sharco" class="form-control" placeholder="ادخل سعر الاشتراك" required>                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">تكلفة الاشتراك</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" min="0" autocomplete="off"  value="<?php echo $rows["buyth"]; ?>" name="price-sh" class="form-control" placeholder="ادخل تكلفة الاشتراك" required>                                
                        </div>
                        <!--  End Input Name Member -->
                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">الاشتراك</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" min="0" autocomplete="off"  value="<?php echo $rows["price_sh"]; ?>" name="price-count" class="form-control" placeholder="ادخل قيمة الاشتراك الاسبوعي" required>                                
                        </div>
                        <!--  End Input Name Member -->
                        <!--  Start Input Descount -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">الخصم</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" min="0" autocomplete="off"  value="<?php echo $rows["descount"]; ?>" name="descount" class="form-control" placeholder="ادخل قيمة الاشتراك الاسبوعي" required>                                
                        </div>
                        <!--  End Input Descount -->
                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">نوع الاشتراك</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <select class="form-control type-shr" name="typeshr" required>
                                <option value='0'>...</option>
                                <?php 
                                    foreach ( $typeshr as $typeshrs) {?>
                                        <option <?php if ( $typeshrs["types"] == $rows["type_mem"] ){ echo "selected"; } ?> value='<?php echo $typeshrs["types"] ;?>'><?php echo $typeshrs["types"];?></option>
                                    <?php  }
                                ?>
                            </select>                                
                        </div>
                        <!--  End Input Name Member -->
                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">العداد المركزي</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <select class="form-control type-shr" name="addad" required>
                            <option value='0'>...</option>
                                <?php 
                                    foreach ( $idadd as $adads) { ?>
                                        <option <?php if ( $adads["ad_id"] == $rows["id_adad"] ){ echo "selected"; } ?> value='<?php echo $adads["ad_id"] ?>'> <?php echo $adads["name_ad"] ?></option>
                                   <?php }
                                ?>
                            </select>                                
                        </div>
                        <!--  End Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">اسم المجموعة</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <select class="form-control type-shr" name="group" required>
                            <option value='0'>...</option>
                                <?php 
                                    foreach ( $group as $gro) { ?>
                                        <option <?php if ( $gro["group_id"] == $rows["mem_group"] ){ echo "selected"; } ?> value='<?php echo $gro["group_id"];?>'><?php echo $gro["name_group"]; ?></option>
                                    <?php }
                                ?>
                            </select>                                
                        </div>
                        <!--  End Input Name Member -->
                        <!--  End Input Name Member -->
                        <div class="col-md-12 rtl-right">
                            <input type="submit" class="submit btn btn-success" value="حفظ">                               
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php
        }else {
            header("location: ?");
        }}else {
            echo "<h1 class='text-center nice-mass'>لايُمكنك إضافة مشتركين يجب إضافة مجموعة لتتمكن من إضافة مشتركين</h1>";
        }
    } elseif ( $do == "Detelsemem" ) {
        $sys_id = $_GET["sys_id"];
        $select = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND sys_id = ?");
        $select->execute(array($usernow,$sys_id));
        $fetch = $select->fetch();

        $group_id = $fetch["mem_group"];
        $group = $con->prepare("SELECT * FROM `groups` WHERE groupuser = ? AND group_id = ?");
        $group->execute(array($usernow,$group_id));
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
            echo "<a href='mrmshar.php?". $groupids ."sys=" . $fetch["sys_id"] . "#". $fetch["sys_id"] . "' class='btn-back'><i class='fa fa-arrow-right fa-3x'></i></a>";
            echo "<a  href='?".$groupids."do=Entervalrenew&sysid=". $fetch["sys_id"] ."'><button>قطع فاتورة</button></a>";                        
            echo "<a  href='?do=Ends&sysid=". $fetch["sys_id"] ."'><button>عرض السجل</button></a>";            
            echo "<a  href='?do=Entervalend&sysid=". $fetch["sys_id"] ."&stat=1'><button>ادراج تسليم</button></a>";
            echo "<a  href='?do=Billsmem&sys_id=". $fetch["sys_id"] ."'><button>عرض الفواتير</button></a>";
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
                echo "<p> <span>الخصم</span> <span>:</span> " . $fetch["descount"] . "</p>";              
                echo "<p> <span>المجموعة</span> <span>:</span> " . $groups["name_group"] . "</p>";
                echo "<p> <span>العداد المركزي</span> <span>:</span> " . $name_adad["name_ad"] . "</p>";
                echo "<p> <span>رقم الهاتف </span> <span>:</span> " . $fetch["nphon"] . "</p>";
                echo "<p> <span> تاريخ الاشتراك </span> <span>:</span> " . $fetch["date"] . "</p>";
                echo "<p> <span>عدد الفواتير</span> <span>:</span> " . $countphotomem . "<a href='?do=Billsmem&sys_id=". $fetch["sys_id"] ."'><button>عرض</button></a></p>";
            echo "</div>";
        echo "</div>";
    }elseif ( $do == 'upendsnew' ){
        $new_cou = $_POST["new_cou"];
        $sysid = $_GET["sys_id"];
        $stat = $_POST["stat"];
        $insert = $con->prepare("INSERT INTO `ends` (`end_cou`, `end_date`, `ends_status`, `id_mem`) VALUES (:zendcou, now() , :zstat, :znameid)");
        $insert->execute(array(
            "zendcou" => $new_cou,
            "zstat" => $stat,
            "znameid" => $sysid,
        ));
       header("location: mrmshar.php?do=Detelsemem&sys_id=$sysid");
    } elseif ( $do == "Entervalrenew" ){
        $sysid = $_GET["sysid"];
        $select = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND sys_id = ?");
        $select->execute(array($usernow ,$sysid));
        $count = $select->rowCount();
        $row = $select->fetch();
        ?>
        <div class='form-enter'>
            <h3 class='text-center'> ادخال قراءة جديدة </h3>
            <h4>الأسم : <?php echo $row["mem_name"]; ?></h4>
            <form action='?<?php echo $groupids; ?>do=InsertBill&sysid=<?php echo $sysid; ?>' method='POST' calss='form-group'>
                <div class='from-in'>    
                    <input type='text' name='relast' value='<?php echo $row["renow"] ?>' class='form-control' placeholder='ادخل القراءة الحاليه' >
                    <label> القراءة السابقه </label>
                </div>
                <div class='from-in'>
                    <input type='text' name='renow' class='form-control focus' placeholder='ادخل القراءة الحاليه'>
                    <label> القراءة الحاليه </label>
                </div>
                <div class='from-in'>
                    <input type='submit' style="width: 80px; padding: 3px; margin-right: 50px" value='ادخال'>
                </div>
            </form>
            <div class='from-in enter-re'>
                    <a href='?do=Detelsemem&sys_id=<?php echo $row["sys_id"] ?>'><input type='submit' style="width: 80px; padding: 3px;margin-left: 50px" value='الغاء'></a>
            </div>
        </div>
        <?php
        }elseif ( $do == "Entervalend" ){
            $sysid = $_GET["sysid"];
            $stat = $_GET["stat"];
            $select = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND sys_id = ?");
            $select->execute(array($usernow ,$sysid));
            $count = $select->rowCount();
            if ($count > 0 ) {
            $row = $select->fetch();
            ?>
            <div class='form-enter'>
                <?php if (isset($stat) && $stat == 0) {?>
                <h3 class='text-center'> ادراج متاخرات </h3>
                <?php } else {?>
                    <h3 class='text-center'> ادراج تسليم </h3>
                <?php }?>
                <h4>الأسم : <?php echo $row["mem_name"]; ?></h4>
                <form action='?do=upendsnew&sys_id=<?php echo $sysid; ?>' method='POST' class='form-group'>
                    <div class='from-in'> 
                        <input type="hidden" value="<?php echo $stat; ?>" name="stat" />   
                        <input type='text' name='new_cou' class='form-control focus' placeholder='ادخل القيمة'>
                        <?php if (isset($stat) && $stat == 0) {?>
                            <label> المتاخرات </label>
                        <?php } else {?>
                            <label> التسليم </label>
                        <?php }?>
                    </div>
                    <div class='from-in'>
                        <input type='submit' style="width: 100px; padding: 5px" value='ادخال'>
                    </div>
                </form>
                <div class='from-in enter-re'>
                    <a href='?do=Detelsemem&sys_id=<?php echo $row["sys_id"] ?>'><input type='submit' style="width: 100px; padding: 5px" value='الغاء'></a>
                </div>
            </div>
            <?php
            }else {
                header("location: ?");
            }
            }elseif ( $do == "InsertBill" ) {
                $relast = $_POST["renow"];
                $renow = $_POST["relast"];
                $postsysid = $_GET["sysid"];
                
                $update = $con->prepare("UPDATE `mem-shr` SET `renow` = ?, `relast` = ? WHERE `sys_id` = ?");
                $update->execute(array($relast, $renow, $postsysid));

                $shr = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND sys_id = ?");
                $shr->execute(array($usernow,$postsysid));
                $selec  = $shr->fetch();

                $sysid = $selec["sys_id"];

                $allend = $con->prepare("SELECT SUM(sum_countgo) AS allends FROM `photo` INNER  JOIN `mem-shr` ON `mem-shr`.`sys_id` = `photo`.`sysid_ph` WHERE sysid_ph = ?");
                $allend->execute(array($sysid));
                $allends = $allend->fetchAll();
                
                // Query Table Option Bills

                $opphto = $con->prepare("SELECT * FROM `optionbill` WHERE option_user = ?");
                $opphto->execute(array($usernow));
                $opphtos  = $opphto->fetch();

                //End Table For Date TO Date 
                echo $dates["todate"];
                $fordate = $opphtos["datefor"];
                $todate = $opphtos["dateto"];
                $name = $selec["mem_name"];
                $type = $selec["type_mem"];
                $title = $selec["title_mem"];
                $nphon = $selec["nphon"];
                $relast = $selec["relast"];
                $renow = $selec["renow"];
                $price_sh = $selec["price_sh"];
                $descount = $selec["descount"];
                $title_footer = $opphtos["title_footer"];
                $name_manage = $opphtos["name_manager"];
                $number_manage = $opphtos["numbers_phon"];
                $namemanage = $opphtos["name_manager"];
                $pn_collector = $opphtos["phone_mohs"];
                
                $goinin = $renow - $relast;
                
                $giveing = $con->prepare("SELECT SUM(end_cou) AS allgives  FROM ends WHERE id_mem = ? AND ends_status = 1");
                $giveing->execute(array($sysid));
                $gived = $giveing->fetch();
                $giveme = $gived["allgives"];

                $stmt = $con->prepare("SELECT * FROM `photo`  WHERE sysid_ph = ?");
                $stmt->execute(array($sysid));
                $rows = $stmt->fetchAll();
                    $goingall = $renow - $relast;
                    $namcou = $selec["nam_cou"];
                    $sysidph = $selec["sysid_ph"];
                    $vv = $con->prepare("SELECT SUM(end_cou) AS allends  FROM ends WHERE id_mem = ? AND ends_status = 0");
                    $vv->execute(array($sysid));
                    $bbc = $vv->fetchAll();

                    foreach ( $allends as $photoend ) {


                    $afterfilter = $photoend["allends"] - $giveme;

                    $sum_countgo = $goingall * $namcou + $price_sh  - $descount;
                    
                    $price_going = $goingall * $namcou;

                    
                    $allcol = $goingall * $namcou + $afterfilter + $price_sh - $descount ; 
                    $phot = $con->prepare("INSERT INTO photo (`sysid_ph`,`date_ver`,`date_for`,`date_to`,`ph_name`,`type_join`,`title_mem`,`ph_phon`,latest,relatest,relanow,`count_go`,`shaer`,`ph_descount`,`count_price`,price_going,sum_countgo,`all_clom`,ph_footer,name_manage,number_manage,pn_collector)
                    VALUES (:zsysid, now(), :zfordate, :ztodate, :zname,:ztype,:ztitle,:zphon,:zlatest,:zlalast,:zrenow,:zcogo,:zshaer,:zph_descount,:znamcou,:zprice_going,:zsum_countgo,:zallclo,:ztitlefooter,:zname_manage,:znumber_manage,:zpn_collector) ");
                    $phot->execute(array(
                        "zsysid" => $sysid,
                        "zfordate" => $fordate,
                        "ztodate" => $todate,
                        "zname" => $name,
                        "ztype" => $type,
                        "ztitle" => $title,
                        "zphon" => $nphon,
                        "zlatest" => $afterfilter,
                        "zlalast" => $relast,
                        "zrenow" => $renow,
                        "zcogo" => $goingall,
                        "zshaer" => $price_sh,
                        "zph_descount" => $descount,
                        "znamcou" => $namcou,
                        "zprice_going" => $price_going,
                        "zsum_countgo" => $sum_countgo,
                        "zallclo" => $allcol,
                        "ztitlefooter" => $title_footer,
                        "zname_manage"  => $name_manage,
                        "znumber_manage" => $number_manage,
                        "zpn_collector" => $pn_collector
                        
                    ));                
        } 
        //echo "<h1 class='text-center nice-mass'>تم قطع الفواتير بنجاح</h1>";
         
        header("location: mrmshar.php?$groupids do=Detelsemem&sys_id=$sysid");
        
            }elseif ( $do == "Editengi" ) {
                $sysid = $_GET["sysid"];
                $name_id = $_GET["name_id"];
                echo $name_id;

                $engi = $con->prepare("SELECT * FROM `ends` INNER  JOIN `mem-shr` ON `mem-shr`.`sys_id` = `ends`.`id_mem` WHERE name_id = ?");
                $engi->execute(array($name_id));
                $valengi = $engi->fetch();

                ?>
                <div class='form-enter'>
                    <h3 class='text-center'>تعديل التسليم</h3>
                    <h4>الأسم : <?php echo $valengi["mem_name"]; ?></h4>
                    <form action='?do=updateengi' method='POST' class='form-group'>
                        <div class='from-in'> 
                            <input type="hidden" name="name_id" value="<?php echo $valengi["name_id"]; ?>">
                            <input type="hidden" name="sysid" value="<?php echo $sysid; ?>">
                            <input type='text' value="<?php echo $valengi["end_cou"]; ?>" name='new_cou' class='form-control' placeholder='ادخل القيمة'>
                            <label> التسليم </label>
                        </div>
                        <div class='from-in'>
                            <input type='submit' style="width: 100px; padding: 5px" value='حفظ'>
                        </div>
                    </form>
                    <div class='from-in enter-re'>
                        <a href='?do=Detelsemem&sys_id=<?php echo $valengi["sys_id"] ?>'><input type='submit' style="width: 100px; padding: 5px" value='الغاء'></a>
                    </div>
                </div>
                <?php
            }elseif ( $do == "updateengi" ) {
                if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
                    $name_id = $_POST["name_id"];
                    $end_cou = $_POST["new_cou"];
                    $sysid = $_POST["sysid"];
                    
                    $engi = $con->prepare("UPDATE `ends` SET `end_cou` = ? WHERE `ends`.`name_id` = ? ;");
                    $engi->execute(array($end_cou,$name_id));
                    $count = $engi->rowCount();
                    if ( $count > 0 ) {
                        echo "<h1>تم حفظ التغير</h1>";
                        header("location: mrmshar.php?do=Detelsemem&sys_id=$sysid");
                        
                    }else {
                        echo "<h1>لا يوجد اي تغير</h1>";
                        header("location: /* mrmshar */.php?do=Detelsemem&sys_id=$sysid");
                    }
                }
            } elseif ( $do == "Upmem" ) {
                    if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
                        $sysid          = $_POST["sysid"];
                        $namesha        = $_POST["name-sha"];
                        $nameeco        = $_POST["name-eco"];
                        $title          = $_POST["title"];
                        $phon           = $_POST["phon"];
                        $unitkl         = $_POST["unitkl"];
                        $relast         = $_POST["relast"];
                        $renow          = $_POST["renow"];
                        $sharco         = $_POST["sharco"];
                        $buyth          = $_POST["price-sh"];
                        $descount       = $_POST["descount"];
                        $pricecount     = $_POST["price-count"];
                        $typeshr        = $_POST["typeshr"];
                        $addad          = $_POST["addad"];
                        $group          = $_POST["group"];
                        $goingto = $renow - $relast;
                        $select = $con->prepare("UPDATE `mem-shr` SET `mem_name` = ?, `sub_name` = ?, `title_mem` = ?, `nphon` = ?, `nam_cou` = ?, `relast` = ?, `renow` = ?, `count_sh` = ?,`buyth` = ?, `price_sh` = ?,`descount` = ?, `type_mem` = ?, `id_adad` = ?, mem_group = ? WHERE `mem-shr`.`sys_id` = ?");
                        $select->execute(array($namesha, $nameeco, $title, $phon, $unitkl, $relast, $renow, $sharco ,$buyth, $pricecount, $descount, $typeshr, $addad, $group, $sysid));
                        $bind = $select->rowCount();
                        if ($bind > 0 ) {
                            echo "<h1 class='text-center nice-mass'>تم حفظ التغيير</h1>";
                            transitionpages("back",".5");
                        } else {
                            echo "<h1 class='text-center nice-mass'>لايوجد اي تغيير</h1>";
                            transitionpages("back",".5");
                        }
                        
                    }
    
        }elseif ( $do == "Ends" ) {
            $endsid = $_GET["sysid"];
            $stmt = $con->prepare("SELECT * FROM ends WHERE id_mem = ? And ends_status = 0 ORDER BY name_id DESC");
            $stmt->execute(array($endsid));
            $rows = $stmt->fetchAll();

            $giveing = $con->prepare("SELECT * FROM ends WHERE id_mem = ? And ends_status = 1 ORDER BY name_id DESC");
            $giveing->execute(array($endsid));
            $giveings = $giveing->fetchAll();
            
            $give = $con->prepare("SELECT SUM(end_cou) AS allgiveins  FROM ends WHERE id_mem = ? AND ends_status = 1");
            $give->execute(array($endsid));
            $togive = $give->fetch();

            $memshr = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND sys_id = ?");
            $memshr->execute(array($usernow,$endsid));
            $mem = $memshr->fetch();

            $joinend = $con->prepare("SELECT * FROM `photo` INNER  JOIN `mem-shr` ON `mem-shr`.`sys_id` = `photo`.`sysid_ph` WHERE sys_id = ?");
            $joinend->execute(array($endsid));
            $joinends = $joinend->fetchAll();

            $allend = $con->prepare("SELECT SUM(sum_countgo) AS allends FROM `photo` INNER  JOIN `mem-shr` ON `mem-shr`.`sys_id` = `photo`.`sysid_ph` WHERE sys_id = ?");
            $allend->execute(array($endsid));
            $allends = $allend->fetch();

            echo "<h1 class='text-center'>" . $mem["mem_name"] . "</h1>";
            ?>
            <div class="container">
                <a href='<?php echo $groupids . $_SERVER["HTTP_REFERER"];  ?>' class='btn-back'><i class='fa fa-arrow-right fa-3x'></i></a>
            </div>
            <div class="container">
            <div class="table-sug pull-right data-members">
                <div class="table-responsive detelse-form">
                    <table>
                        <tr>
                            <td>المتاخرات</td>
                            <?php if (!empty($allends["allends"])) { ?>
                                <td>التاريخ</td>
                            <?php }?>
                        </tr>
            <?php
            foreach ( $joinends as $row ) {
                echo "<tr>";
                    echo "<td>" . $row["sum_countgo"] . "</td>";
                    echo "<td>" . $row["date_ver"] . "</td>";
                echo "</tr>";
            }       
                if ( empty($allends["allends"]) ) {
                    echo "<td bgcolor='#dd0000' style='color: #fff' width='400px' col='2'> لا يوجد اي نتائج </td>";
                }else {
                    echo "<td bgcolor='#dd0000' style='color: #fff'> المجموع الكلي </td>";
                    echo "<td bgcolor='#dd0000' style='color: #fff'>" . $allends["allends"] . "</td>";
                }
                    echo "</table>";
                echo "</div>";
            echo "</div>";
            ?>
            <div class="table-sug pull-left data-members">
                <div class="table-responsive ">
                    <table class="detelse-form">
                        <tr>
                            <td>التسليم</td>
                            <?php if (!empty($togive["allgiveins"])) { ?>
                                <td>التاريخ</td>
                            <?php }?>
                        </tr>
            <?php
            foreach ( $giveings as $giveing ) {
                
                    echo "<tr>";
                        echo "<td><a title='تعديل' href='?do=Editengi&sysid=".$giveing["id_mem"]."&name_id=".$giveing["name_id"]."'>" . $giveing["end_cou"] . "</a></td>";
                        echo "<td>" . $giveing["end_date"] . "</td>";
                    echo "<tr>";
                
            }
                    if ( empty($togive["allgiveins"]) ) {
                        echo "<td bgcolor='#dd0000' style='color: #fff' width='400px' col='2'> لا يوجد اي نتائج </td>";
                    }else {
                        echo "<td bgcolor='#dd0000' style='color: #fff'> المجموع الكلي </td>";
                        echo "<td bgcolor='#dd0000' style='color: #fff'>" . $togive["allgiveins"] . "</td>";
                    }
                    echo "</table>";
                echo "</div>";
            echo "</div>";
                $goupend = $allends["allends"] - $togive["allgiveins"];
                echo "<div class='grop-ends'>";
                    echo "<p> المستحق : " . $goupend . "</p>";
                echo "</div>";
        }elseif ( $do == "Billsmem" ){
            $sys_id = $_GET["sys_id"];
            echo "<div class='btn-print'>";
                echo "<div class='btn-pri'>";
                    echo "<button onclick='window.print()'> <i class='fa fa-print'> طباعة </i> </button>";
                echo "</div>";
            echo "</div>";
            $select = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id WHERE sys_id = ? ORDER BY ph_id DESC");
            $select->execute(array($sys_id));
            $rows = $select->fetchAll();
            $count = $select->rowCount();
            $mem_name = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND sys_id = ?");
            $mem_name->execute(array($usernow,$sys_id));
            $ron = $mem_name->rowCount();
            $memname = $mem_name->fetch();
            if ( $ron > 0 ) {
            echo "<h1 class='text-center  no-print'>" . $memname["mem_name"] . "</h1>";
            
            if ( $count > 0 ){
            ?>
            <div class="container no-print">
                <a href='<?php echo $groupids . $_SERVER["HTTP_REFERER"];  ?>' class='btn-back'><i class='fa fa-arrow-right fa-3x'></i></a>
            </div>
            <?php
                ?> 
                <div class='pho-all'>

                <?php  foreach ( $rows as $row ) {  
                    $datever = str_replace("-", "/", $row["date_ver"]);
                    $datefor = str_replace("-", "/", $row["date_for"]);
                    $dateto = str_replace("-", "/", $row["date_to"]);
                    $endsid = $row["sysid_ph"];

                    $option = $con->prepare("SELECT * FROM `optionbill` WHERE  option_user = ?");
                    $option->execute(array($usernow));
                    $options = $option->fetch();

                    $newline = str_replace("+", "<br>", $row["ph_footer"]);
                    ?>
            
                    <div class='pho'>
                        <div class="pho-header">
                            <p class="text-center h4 offce color"><?php echo $options["name_unit"] ?></p>
                            <h2 class="text-center">فاتورة استهلاك كهرباء</h2>
                            <h4 class="text-center"><span>من تاريخ</span> <?php echo $datefor; ?> <span>الى تاريخ</span> <?php echo $dateto; ?> </h4>
                            <hr>                            
                            <div class="num">
                                <h5>رقم الفاتورة : <?php echo $row["ph_id"];?></h5>
                                <h5>تاريخ اصدارها : <?php echo $datever ;?></h5>
                            </div>
                            <div class="img-pho">
                                <img class="img-responsive" src='im.ttf'/>
                            </div>
                            <span class="phon">للتواصل : <?php echo $row["number_manage"] ?></span>
                            <span class="pull-left"></span>
                            
                        </div>
                        <div class='data-mem'>
                            <p>اسم المستهلك : <?php echo $row["mem_name"] ?> </p>
                            <p>نوع الاشتراك : <?php echo $row["type_join"] ?></p>
                        </div>
                        <div class='data-mem mr-non'>
                            <p>العنوان : <?php echo $row["title_mem"] ?></p>
                            <p>رقم الهاتف : <?php echo $row["nphon"] ?></p>
                        </div>
                        <div class='table-pho'>
                            <table>
                                <tr>
                                    <td>المتاخرات</td>
                                    <td>القراءة السابقة</td>
                                    <td>القراءة الحالية</td>
                                    <td>الاستهلاك</td>
                                    <td>سعر الوحدة</td>
                                    <td>قيمة الاستهلاك</td>
                                    <td>الاشتراك</td>
                                    <td>اجمالي</td>
                                </tr>
                                <tr>
                                    <td><?php echo $row["latest"]; ?></td>
                                    <td><?php echo $row["relatest"] ?></td>
                                    <td><?php echo $row["relanow"] ?></td>
                                    <td><?php echo $row["count_go"] ?></td>
                                    <td><?php echo $row["count_price"] ?></td>
                                    <td><?php echo $row["price_going"] ?></td>
                                    <td><?php echo $row["shaer"] ?></td>
                                    <td><?php echo $row["all_clom"] ?></td>
                                </tr>
                            </table>
                            <div class="footerphoto">
                                <span class="print-red">ملاحظة :- </span>
                                <p><?php echo $newline ?></p>
                            </div>
                            
                        </div>
                    </div>
                
        <?php }
            }else {
                ?>
                <div class="container">
                    <a href='<?php echo $groupids . $_SERVER["HTTP_REFERER"];  ?>' class='btn-back'><i class='fa fa-arrow-right fa-3x'></i></a>
                </div>
                <?php
                echo "<h1 class='text-center nice-mass'>لايوجد اي فواتير</h1>";
                
            }
        }else {
            header("location: ?");
        }
        echo "</div>
        </div>";
        }elseif ( $do == "Deletedmem" ){
            $sysid = $_GET["sysid"];
            $select = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND `sys_id` = ?");
            $select->execute(array($usernow ,$sysid));
            $rowcount = $select->rowCount();
            $urlback  = $_SERVER["HTTP_REFERER"];
            if ( $rowcount > 0 ) {
                $stmt = $con->prepare("DELETE FROM `mem-shr` WHERE `sys_id` = ?");
                $stmt->execute(array($sysid));
                header("location: $urlback");
            }else {
                echo $urlback;
                header("location: $urlback");
            }
            
        }

    include "footer.php";
}else {
    header("location:index.php");
    exit();
}
    
?>