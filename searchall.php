<?php
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
    if ( $do == "Manage" ){
        $select = $con->prepare("SELECT * FROM `mem-shr` ORDER BY sys_id $sort");
        $select->execute(array($sort));
        $rows = $select->fetchAll();
        echo "<div class='container'>";
            echo "<div class='all-btns'>";
                echo "<a href='?do=Addsha' class='btn btn-primary btn-root'>أضافة مشترك</a>";            
                echo "<div class='search'>";
                echo "<form action='?do=searchmem' method='POST'>";
                    echo "<input type='search' name='searmem' placeholder='بحث في المشتركين' class='form-control search' />";
                    echo "<input type='submit' value='بحث' class='btn btn-success'>";
                echo "</form>";        
            echo "</div>";
                ?>
                <div class='pull-left sort'>
                    <span>ترتيب : </span>                    
                    <a href='?sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?>'>تنازلي</a> |  
                    <a href='?sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";} ?>'>تصاعدي</a>               
                <?php 
            echo "</div>";
            echo "</div>";
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
                    foreach ( $rows as $row ) {
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
                echo "</table>";
            echo "</div>";
    } elseif ( $do == "Addsha" ){
        $select = $con->prepare("SELECT type_shr FROM `option` WHERE stat = 1");
        $select->execute();
        $rows = $select->fetchAll();
        $addad = $con->prepare("SELECT * FROM `addad`");
        $addad->execute();
        $idadd = $addad->fetchAll();
        $groups = $con->prepare("SELECT * FROM `groups`");
        $groups->execute();
        $group = $groups->fetchAll();
        ?>
            <div class="add-mem">
                <div class="container">
                <h1 class="text-center">اضافة مشترك جديد</h1>
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
                                    <input type="text" autocomplete="off" name="name-eco" class="form-control" placeholder=" ادخل الاسم التجاري للمشترك" required  pattern=".{4,}" title="يجب الايكون اسم المشترك اقل من  4 احرف">                                
                                </div>
                                <!--  End Input Name Member -->

                                <!--  Start Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right">العنوان</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <input type="text" autocomplete="off" name="title" class="form-control" placeholder="ادخل عنوان المشترك" required  pattern=".{4,}" title="يجب الايكون اسم المشترك اقل من  4 احرف">                                
                                </div>
                                <!--  End Input Name Member -->

                                <!--  Start Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right">رقم الهاتف</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <input type="text" autocomplete="off" name="phon" class="form-control" placeholder="ادخل رقم هاتف المشترك" required pattern=".{9,}" title="يجب الايكون اسم المشترك اقل من  9 ارقام">                                
                                </div>
                                <!--  End Input Name Member -->

                                <!--  Start Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right">سعر الكيلوا</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <input type="text" autocomplete="off" name="unitkl" class="form-control" placeholder="ادخل سعر الكيلوا للمشترك" required>                                
                                </div>
                                <!--  End Input Name Member -->

                                <!--  Start Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right">القراءة السابقه</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <input type="text" autocomplete="off" name="relast" class="form-control" placeholder="ادخل القراة السابقه">                                
                                </div>
                                <!--  End Input Name Member -->

                                <!--  Start Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right">الفراءة الحاليه</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <input type="text" autocomplete="off" name="renow" class="form-control" placeholder="ادخل اخر قراءة" >                                
                                </div>
                                <!--  End Input Name Member -->

                                <!--  Start Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right">سعر الاشتراك</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <input type="text" autocomplete="off" name="sharco" class="form-control" placeholder="ادخل سعر الاشتراك" required>                                
                                </div>
                                <!--  End Input Name Member -->

                                <!--  Start Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right">تكلفة الاشتراك</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <input type="text" autocomplete="off" name="price-sh" class="form-control" placeholder="ادخل تكلفة الاشتراك" required>                                
                                </div>
                                <!--  End Input Name Member -->

                                <!--  Start Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right">نوع الاشتراك</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <select class="form-control type-shr" name="typeshr">
                                        <?php 
                                            foreach ( $rows as $row) {
                                                echo "<option value='". $row["type_shr"] ."'>" . $row["type_shr"] . "</option>" ;
                                            }
                                        ?>
                                    </select>                                
                                </div>
                                <!--  End Input Name Member -->
                                <!--  Start Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right">اسم العداد</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <select class="form-control type-shr" name="addad">
                                        <?php 
                                            foreach ( $idadd as $adads) {
                                                echo "<option value='". $adads["ad_id"] ."'>" . $adads["name_ad"] . "</option>" ;
                                            }
                                        ?>
                                    </select>                                
                                </div>
                                <!--  End Input Name Member -->
                                <div class="text-right col-sm-2 control-label rtl-right stlab">
                                    <label class="text-right margin-top">اسم المجموعة</label>                                
                                </div>
                                <div class="col-md-4 rtl-right">
                                    <select class="form-control type-shr margin-top" name="group">
                                        <?php 
                                            foreach ( $group as $gro) {
                                                echo "<option value='". $gro["group_id"] ."'>" . $gro["name_group"] . "</option>" ;
                                            }
                                        ?>
                                    </select>                                
                                </div>
                                <!--  End Input Name Member -->
                                <div class="col-md-12 rtl-right">
                                    <input type="submit" class="submit btn btn-success" value="أضافة">                               
                                </div>
                        </form>
                    </div>                    
                </div>
            </div>
        <?php

    } elseif ( $do == "Insertmem" ) {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
            $namesha    = $_POST["name-sha"];
            $nameeco    = $_POST["name-eco"];
            $title      = $_POST["title"];
            $phon       = $_POST["phon"];
            $unitkl     = $_POST["unitkl"];
            $relast     = $_POST["relast"];
            $renow      = $_POST["renow"];
            $sharco     = $_POST["sharco"];
            $pricesh    = $_POST["price-sh"];
            $typemem    = $_POST["typeshr"];
            $addad    = $_POST["addad"];
            $group    = $_POST["group"];
            echo $addad;
            $formerror = array();
            if ( $relast > $renow ) {
                $formerror[] = "يجب الا تكون القراءة السابقه اكبر من القراءة الحالية";
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
            if ( empty($formerror) ){
                $exes = $con->prepare("SELECT mem_name FROM `mem-shr` WHERE mem_name = ?");
                $exes->execute(array($namesha));
                $ron = $exes->rowCount();
                if ( $ron == 0 ) {
                    echo "<div class='nice-mass'><h1 class='text-center'>لقد تم اضافة مشترك جديد</h1></div>";
                    $stmt = $con->prepare("INSERT INTO `mem-shr` (`mem_name`, `sub_name`, `title_mem`, `type_mem`, `nphon`, `nam_cou`, `date`, `relast`, `renow`, `count_sh`, `buyth`,`id_adad`,`mem_group`)
                    VALUES (:zmem_shr, :zsub_name, :ztitle_mem, :ztype_mem, :znphon, :znam_cou, now(), :zrelast, :zrenow, :zcount_sh, :zbuyth,:zidadad,:zgroup)");
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
                        "zidadad" => $addad,
                        "zgroup" => $group,
                    ));
                    transitionpages("back", 1);
                    echo $typemem;
                    
                }else {
                    echo "<div class='nice-mass'><h1 class='text-center'>هذا الاسم موجود موسبقاََ</h1></div>";
                    transitionpages("back", 2);
                }
            }else {
                transitionpages("back", 3);
                foreach( $formerror as $errors ){
                    echo "<div class='nice-mass'><h1 class='text-center'>" . $errors . "</h1>";
                }
            }

        } else {
            transitionpages("back", 1);
        }
    } if ( $do == "Edmem" ){
        $sys_id = $_GET["sys_id"];
        $select = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
        $select->execute(array($sys_id));
        $rows = $select->fetch();
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
                            <input type="text" value="<?php echo $rows["mem_name"]; ?>" autocomplete="off" name="name-sha" class="form-control" placeholder="ادخل اسم المشترك" required pattern=".{4,}" title="يجب الايكون اسم المشترك اقل من  4 احرف">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">الأسم التجاري </label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" value="<?php echo $rows["sub_name"]; ?>" autocomplete="off" name="name-eco" class="form-control" placeholder=" ادخل الاسم التجاري للمشترك" required  pattern=".{4,}" title="يجب الايكون اسم المشترك اقل من  4 احرف">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">العنوان</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" value="<?php echo $rows["title_mem"]; ?>" autocomplete="off" name="title" class="form-control" placeholder="ادخل عنوان المشترك" required  pattern=".{4,}" title="يجب الايكون اسم المشترك اقل من  4 احرف">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">رقم الهاتف</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" value="<?php echo $rows["nphon"]; ?>" autocomplete="off" name="phon" class="form-control" placeholder="ادخل رقم هاتف المشترك" required pattern=".{9,}" title="يجب الايكون اسم المشترك اقل من  9 ارقام">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">سعر الكيلوا</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" value="<?php echo $rows["nam_cou"]; ?>" autocomplete="off" name="unitkl" class="form-control" placeholder="ادخل سعر الكيلوا للمشترك" required>                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">القراءة السابقه</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" value="<?php echo $rows["relast"]; ?>" autocomplete="off" name="relast" class="form-control" placeholder="ادخل القراة السابقه">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">الفراءة الحاليه</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" value="<?php echo $rows["renow"]; ?>" autocomplete="off" name="renow" class="form-control" placeholder="ادخل اخر قراءة" >                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">سعر الاشتراك</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" value="<?php echo $rows["count_sh"]; ?>" autocomplete="off" name="sharco" class="form-control" placeholder="ادخل سعر الاشتراك" required>                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">تكلفة الاشتراك</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" value="<?php echo $rows["buyth"]; ?>" autocomplete="off" name="price-sh" class="form-control" placeholder="ادخل تكلفة الاشتراك" required>                                
                        </div>
                        <!--  End Input Name Member -->
                        <div class="col-md-12 rtl-right">
                            <input type="submit" class="submit btn btn-success" value="حفظ">                               
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    <?php
    } elseif ( $do == "Detelsemem" ) {
        $sys_id = $_GET["sys_id"];
        $select = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
        $select->execute(array($sys_id));
        $fetch = $select->fetch();
        echo "<div class='container'>";
            echo  "<h1 class='text-center'>" . $fetch["mem_name"] . "</h1>";
            
            echo "<a href='mrmshar.php?sys=" . $fetch["sys_id"] . "#". $fetch["sys_id"] ."' class='btn-back'><i class='fa fa-arrow-right fa-3x'></i></a>";
            echo "<a  href='?do=Entervalrenew&sysid=". $fetch["sys_id"] ."'><button>ادخال قراءة جديدة</button></a>";                        
            echo "<a  href='?do=Ends&sysid=". $fetch["sys_id"] ."'><button>عرض السجل</button></a>";            
            echo "<a  href='?do=Entervalend&sysid=". $fetch["sys_id"] ."&stat=1'><button>ادراج تسليم</button></a>";
            echo "<a  href='?do=Entervalend&sysid=". $fetch["sys_id"] ."&stat=0'><button>ادراج متاخرات</button></a>";
            echo "<div class='detels'>";
                echo "<p> <span>رقم المشترك </span> <span>:</span> " . $fetch["sys_id"] . "</p>";
                echo "<p> <span>اسم المشترك </span> <span>:</span> " . $fetch["mem_name"] . "</p>";
                echo "<p> <span> الاسم التجاري </span> <span>:</span> " . $fetch["sub_name"] . "</p>";
                echo "<p> <span>العنوان </span> <span>:</span> " . $fetch["title_mem"] . "</p>";
                echo "<p> <span>رقم الهاتف </span> <span>:</span> " . $fetch["nphon"] . "</p>";
                echo "<p> <span>سعر الكيلو </span> <span>:</span> " . $fetch["nam_cou"] . "</p>";
                echo "<p> <span> تاريخ الاشتراك </span> <span>:</span> " . $fetch["date"] . "</p>";
                echo "<p> <span> القراءة الاخيرة  </span> <span>:</span> " . $fetch["relast"] . "</p>";
                echo "<p> <span> القراءة الحالية  </span> <span>:</span> " . $fetch["renow"] . "</p>";
                $mans = $fetch["renow"] - $fetch["relast"];
                $allm = $mans * $fetch["nam_cou"];
                echo "<p> <span> الاستهلاك  </span> <span>:</span> " . $mans . "</p>";
            echo "</div>";
        echo "</div>";
    } elseif ( $do == 'updateent' ){
        $relast = $_POST["renow"];
        $renow = $_POST["relast"];
        $sysid = $_GET["sys_id"];
        echo $sysid;
        $update = $con->prepare("UPDATE `mem-shr` SET `renow` = ?, `relast` = ? WHERE `sys_id` = ?");
        $update->execute(array($relast, $renow, $sysid));
        header("location: mrmshar.php?do=Detelsemem&sys_id=$sysid");
    }elseif ( $do == 'upendsnew' ){
        $new_cou = $_POST["new_cou"];
        $sysid = $_GET["sys_id"];
        $stat = $_POST["stat"];
        
        

        $end = $con->prepare("SELECT SUM(end_cou) AS allgiveins  FROM ends WHERE id_mem = ? AND ends_status = ?");
            $end->execute(array($sysid,$stat));
            $ends = $end->fetch();
            $filterend = $ends["allgiveins"] + $new_cou;

            $stmt = $con->prepare("UPDATE `plusends` SET `count_plus` = ? WHERE `plusends`.`id_ends` = ?;");
            $stmt->execute(array($filterend,$sysid));
            
        $update = $con->prepare("INSERT INTO `ends` (`end_cou`, `end_date`, `ends_status`, `id_mem`) VALUES (:zendcou, now() , :zstat, :znameid)");
        $update->execute(array(
            "zendcou" => $new_cou,
            "zstat" => $stat,
            "znameid" => $sysid,
        ));
       header("location: mrmshar.php?do=Detelsemem&sys_id=$sysid");
    } elseif ( $do == "Entervalrenew" ){
        $sysid = $_GET["sysid"];
        $select = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
        $select->execute(array($sysid));
        $row = $select->fetch();
        ?>
        <div class='form-enter'>
            <h3 class='text-center'> ادخال قراءة جديدة </h3>
            <h4>الأسم : <?php echo $row["mem_name"]; ?></h4>
            <form action='?do=updateent&sys_id=<?php echo $sysid; ?>' method='POST' calss='form-group'>
                <div class='from-in'>    
                    <input type='text' name='relast' value='<?php echo $row["renow"] ?>' class='form-control' placeholder='ادخل القراءة الحالية'>
                    <label> اقراءة الاخيرة </label>
                </div>
                <div class='from-in'>
                    <input type='text' name='renow' class='form-control' placeholder='ادخل القراءة الحالية'>
                    <label> اقراءة الحالية </label>
                </div>
                <div class='from-in pull-right'>
                    <input type='submit' style="width: 80px; padding: 3px; margin-right: 50px" value='ادخال'>
                </div>
            </form>
            <div class='from-in pull-left'>
                    <a href='?do=Detelsemem&sys_id=<?php echo $row["sys_id"] ?>'><input type='submit' style="width: 80px; padding: 3px;margin-left: 50px" value='الغاء'></a>
            </div>
        </div>
        <?php
        }elseif ( $do == "Entervalend" ){
            $sysid = $_GET["sysid"];
            $stat = $_GET["stat"];
            $select = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
            $select->execute(array($sysid));
            $row = $select->fetch();
            ?>
            <div class='form-enter'>
                <?php if (isset($stat) && $stat == 0) {?>
                <h3 class='text-center'> ادراج متاخرات </h3>
                <?php } else {?>
                    <h3 class='text-center'> ادراج تسليم </h3>
                <?php }?>
                <h4>الأسم : <?php echo $row["mem_name"]; ?></h4>
                <form action='?do=upendsnew&sys_id=<?php echo $sysid; ?>' method='POST' calss='form-group'>
                    <div class='from-in'> 
                        <input type="hidden" value="<?php echo $stat; ?>" name="stat" />   
                        <input type='text' name='new_cou' class='form-control' placeholder='ادخل القيمة'>
                        <?php if (isset($stat) && $stat == 0) {?>
                            <label> المتاخرات </label>
                        <?php } else {?>
                            <label> التسليم </label>
                        <?php }?>
                    </div>
                    <div class='from-in pull-right'>
                        <input type='submit' style="width: 100px; padding: 5px" value='ادخال'>
                    </div>
                </form>
                <div class='from-in pull-left'>
                    <a href='?do=Detelsemem&sys_id=<?php echo $row["sys_id"] ?>'><input type='submit' style="width: 80px; padding: 3px;margin-left: 50px" value='الغاء'></a>
                </div>
            </div>
            <?php
            }elseif ( $do == "Enterval" ){
                $sysid = $_GET["sysid"];
                $select = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
                $select->execute(array($sysid));
                $row = $select->fetch();
                ?>
                <div class='form-enter'>
                    <h3 class='text-center'> ادخل قيمة المتاخرات </h3>
                    <h4>الأسم : <?php echo $row["mem_name"]; ?></h4>
                    <form action='?do=upendsnew&sys_id=<?php echo $sysid; ?>' method='POST' calss='form-group'>
                        <div class='from-in'>    
                            <input type='text' name='new_cou' class='form-control' placeholder='المتاخرات ادراج'>
                            <label> المتاخرات </label>
                        </div>
                        <div class='from-in pull-right'>
                            <input type='submit' style="width: 100px; padding: 5px" value='ادخال'>
                        </div>
                    </form>
                    <div class='from-in pull-left'>
                        <a href='?do=Detelsemem&sys_id=<?php echo $row["sys_id"] ?>'><input type='submit' style="width: 80px; padding: 3px;margin-left: 50px" value='الغاء'></a>
                    </div>
                </div>
                <?php
                } elseif ( $do == "Upmem" ) {
            if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
                $sysid    = $_POST["sysid"];
                $namesha    = $_POST["name-sha"];
                $nameeco    = $_POST["name-eco"];
                $title      = $_POST["title"];
                $phon       = $_POST["phon"];
                $unitkl     = $_POST["unitkl"];
                $relast     = $_POST["relast"];
                $renow      = $_POST["renow"];
                $sharco     = $_POST["sharco"];
                $pricesh   = $_POST["price-sh"];
                $select = $con->prepare("UPDATE `mem-shr` SET `mem_name` = ?, `sub_name` = ?, `title_mem` = ?, `nphon` = ?, `nam_cou` = ?, `relast` = ?, `renow` = ?, `count_sh` = ?, `price_sh` = ?, `buyth` = '23423', `grou` = '1' WHERE `mem-shr`.`sys_id` = ?");
                $select->execute(array($namesha, $nameeco, $title, $phon, $unitkl, $relast, $renow, $sharco ,$pricesh, $sysid));
                $bind = $select->rowCount();
                if ($bind > 0 ) {
                    echo "<h2 style='margin-top: 250px' class='text-center'>تم حفظ التغيير</h2>";
                    transitionpages("back","2");
                } else {
                    echo "<h2 style='margin-top: 250px' class='text-center'>لايوجد اي تغيير</h2>";
                    transitionpages("back","2");
                }
                
            }
    
        }elseif ( $do == "test" ) {
                                
        } elseif ( $do == "Ends" ) {
            $endsid = $_GET["sysid"];
            $stmt = $con->prepare("SELECT * FROM ends WHERE id_mem = ? And ends_status = 0 ORDER BY name_id DESC");
            $stmt->execute(array($endsid));
            $rows = $stmt->fetchAll();

            $giveing = $con->prepare("SELECT * FROM ends WHERE id_mem = ? And ends_status = 1 ORDER BY name_id DESC");
            $giveing->execute(array($endsid));
            $giveings = $giveing->fetchAll();
            
            $allend = $con->prepare("SELECT SUM(end_cou) AS allends  FROM ends WHERE id_mem = ? AND ends_status = 0");
            $allend->execute(array($endsid));
            $ends = $allend->fetch();

            $give = $con->prepare("SELECT SUM(end_cou) AS allgiveins  FROM ends WHERE id_mem = ? AND ends_status = 1");
            $give->execute(array($endsid));
            $togive = $give->fetch();

            $memshr = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
            $memshr->execute(array($endsid));
            $mem = $memshr->fetch();
            echo "<h1 class='text-center'>" . $mem["mem_name"] . "</h1>";
            ?>
            <div class="container">
            <div class="table-sug pull-right data-members">
                <div class="table-responsive">
                    <table class="">
                        <tr>
                            <td>المتاخرات</td>
                            <?php if (!empty($ends["allends"])) { ?>
                                <td>التاريخ</td>
                            <?php }?>
                        </tr>
            <?php
            foreach ( $rows as $row ) {
                echo "<tr>";
                    echo "<td>" . $row["end_cou"] . "</td>";
                    echo "<td>" . $row["end_date"] . "</td>";
                echo "<tr>";

            }       
                if ( empty($ends["allends"]) ) {
                    echo "<td bgcolor='#dd0000' style='color: #fff' width='400px' col='2'> لا يوجد اي نتائج </td>";
                }else {
                    echo "<td bgcolor='#dd0000' style='color: #fff'> المجموع الكلي </td>";
                    echo "<td bgcolor='#dd0000' style='color: #fff'>" . $ends["allends"] . "</td>";
                }
                    echo "</table>";
                echo "</div>";
            echo "</div>";
            ?>
            <div class="table-sug pull-left">
                <div class="table-responsive">
                    <table class="">
                        <tr>
                            <td>التسليم</td>
                            <?php if (!empty($togive["allgiveins"])) { ?>
                                <td>التاريخ</td>
                            <?php }?>
                        </tr>
            <?php
            foreach ( $giveings as $giveing ) {
                
                    echo "<tr>";
                        echo "<td>" . $giveing["end_cou"] . "</td>";
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
            if ( $ends["allends"] >= $togive["allgiveins"]) {
                $goupend = $ends["allends"] - $togive["allgiveins"];
                echo "<div class='grop-ends'>";
                    echo "<p> المبلغ المتبقي   : " . $goupend . "</p>";
                echo "</div>";
            }else {
                $goupend = $togive["allgiveins"] - $ends["allends"];
                echo "<div class='grop-ends'>";
                    echo "<p> المبلغ الزائد : " . $goupend . "</p>";
                echo "</div>";
            }    
        }elseif ( $do == "searchmem" ) {
            $input = $_POST["searmem"];
            echo "<div class='container'>";
            echo "<div class='all-btns'>";
                echo "<a href='?do=Addsha' class='btn btn-primary btn-root'>أضافة مشترك</a>";            
                echo "<div class='search'>";
                echo "<form action='?do=searchmem' method='POST'>";
                    echo "<input type='search' name='searmem' placeholder='بحث في المشتركين' class='form-control search' />";
                    echo "<input type='submit' value='بحث' class='btn btn-success'>";
                echo "</form>";        
            echo "</div>";
                ?>
                <div class='pull-left sort'>
                    <span>ترتيب : </span>                    
                    <a href='?sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";}elseif (!isset($_GET["ASC"])){ echo "color";  } ?>'>تنازلي</a> |  
                    <a href='?sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";} ?>'>تصاعدي</a>               
                <?php 
            echo "</div>";
            echo "</div>";
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
                    foreach ( search("*","`mem-shr`", "mem_name", "'%$input%'") as $row ) {
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
                echo "</table>";
            echo "</div>";

        } elseif ( $do == "Deletedmem" ){
            $sysid = $_GET["sysid"];
            $stmt = $con->prepare("DELETE FROM `mem-shr` WHERE `sys_id` = ?");
            $stmt->execute(array($sysid));
        }

    include "footer.php";

?>