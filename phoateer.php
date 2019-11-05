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
    if ( $do == "Manage" ) {
        if ( !isset($_GET["searmem"]) ) {
        echo "<div class='container'>";
            echo "<div class='all-btns'>";
                echo "<div class='search'>";
                    echo "<form action='?do=searchphoto' method='GET'>";
                        echo "<input type='search' name='searmem' placeholder='بحث في ...' class='form-control search' />"; ?>
                    <select class='btn btn-success' name='typesear'>
                        <option <?php if ( $typesear == "mem_name" ){echo "selected";} ?> value='mem_name'>اسم الفاتورة</option>
                        <option <?php if ( $typesear == "date_ver" ){echo "selected";} ?> value='date_ver'>تاريخ اصدارها</option>
                        <option <?php if ( $typesear == "ph_id" ){echo "selected";} ?> value='ph_id'>رقم الفاتورة</option>
                    </select> 
                </form>
                    <?php 
                echo "</div>";
            echo "</div>";
            echo "</div>";
            ?>
            <div class="container">
                <div class="header-photo">                    
                    <div class="row">
                        <div class="title-photo">
                            <div class="col-md-4">
                                <img class="" width="100" src="data/FILES/tar.aps">
                                <h2>مجمل التكلفة<h2>
                                <?php 
                                // Get Count monays
                                $usernow = $_SESSION["login"];
                                $select = $con->prepare("SELECT SUM(sum_countgo) AS monays FROM  `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ?");
                                $select->execute(array($usernow));
                                $equle = $select->fetch();
                                if ( !empty($equle["monays"]) ) {
                                    
                                    echo "<h3>" . $equle["monays"] ."</h3>"; 

                                }else {
                                    echo "<h3>لا شئ</h3>";
                                }
                                ?></h3>
                            </div>
                        </div>
                        <div class="title-photo">
                            <div class="col-md-4">
                                <img class="" width="100" src="data/FILES/lam.aps">
                                <h2>مجمل الاستهلاك<h2>
                                <h3><?php
                                        // Get Count Going
                                        $usernow = $_SESSION["login"];
                                        $select = $con->prepare("SELECT SUM(count_go) AS allsum FROM  `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ?");
                                        $select->execute(array($usernow));
                                        $goingCount = $select->fetch();
                                        $going = sumplausnum("renow - relast","allsum", "`mem-shr`"," ");
                                            if ( !empty($goingCount["allsum"]) ) {
                                                echo "<h3>" . $goingCount["allsum"] ."</h3>";
                                            }else {
                                                echo "<h3>لا شئ</h3>";
                                            }
                                ?></h3>
                            </div>
                        </div>
                        <div class="title-photo">
                            <div class="col-md-4">
                                <img class="" width="100" src="data/FILES/fotae.aps">
                                <h2>عدد الفواتير<h2>
                                <?php 
                                    // Get Count Bills
                                    $select = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ?");
                                    $select->execute(array($usernow));
                                    $billsCount = $select->rowCount();
                                ?>
                                <h3><?php if ( !empty($billsCount) ){

                                    echo $billsCount; } else{ echo "لا شئ"; } ?></h3>
                            
                            </div>
                        </div>                            
                    </div>
                    <div class="btns-phots">
                        <div class="col-md-4">
                            <a href="?do=getdates" class="btn btn-info btn-pho">عرض الفواتير</a> 
                        </div>
                        <div class="col-md-4">
                            <a href="?do=printes" class="btn btn-info btn-pho">مجمل الفواتير</a href="?do=printes">
                        </div>
                        <div class="col-md-4">
                            <a href='?do=tablebill&sort=ASC' class='btn btn-info btn-pho'>جدول الفواتير</a>
                        <?php  ?>
                        </div>
                    </div> 
                </div>
            </div>
        <?php
        }else {
            $input = $_GET["searmem"];
            $typesear = $_GET["typesear"];
            echo "<div class='btn-print'>";
                echo "<div class='btn-pri'>";
                    echo "<button onclick='window.print();return false;'> <i class='fa fa-print'> طباعة </i> </button>";
                echo "</div>";
            echo "</div>";
            if ( $typesear !== "mem_name" && $typesear !== "date_ver" && $typesear !== "ph_id"  ) {
                $typesear = $_GET["typesear"] = "mem_name";
            }else {
                $typesear = $_GET["typesear"];
            }
            echo "<div class='container'>";
            echo "<div class='all-btns no-print'>";
                if ( !isset($_GET["viewbills"]) ) {
                echo "<a href='?searmem=" . $input . "&typesear=" . $typesear . "&viewbills' class='btn btn-info btn-root'>عرض</a>";
                }
                if ( isset($_GET["viewbills"]) ) {
                    echo "<a href='?searmem=" . $input . "&typesear=" . $typesear . "' class='btn btn-info btn-root'>عرض</a>";
                }          
                echo "<div class='search'>";
                echo "<form action='?do=searchmem' method='GET'>";
                    echo "<input type='search' value='" . $input . "' name='searmem' placeholder='بحث في ...' class='form-control search' />";
                echo "<select class='btn btn-success' name='typesear'>";?>
                        <option <?php if ( $typesear == "mem_name" ){echo "selected";} ?> value='mem_name'>اسم الفاتورة</option>
                        <option <?php if ( $typesear == "date_ver" ){echo "selected";} ?> value='date_ver'>تاريخ اصدارها</option>
                        <option <?php if ( $typesear == "ph_id" ){echo "selected";} ?> value='ph_id'>رقم الفاتورة</option>
                    <?php echo "</select>"; 
                echo "</form>";
            echo "</div>";
                ?>
                <div class='pull-left sort'>
                    <span>ترتيب : </span>
                    <?php 
                    if ( isset($_GET["viewbills"]) ) {?>
                        <a href='?typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&viewbills&sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?>'>تنازلي</a> |  
                        <a href='?typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&viewbills&sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";}elseif (!isset($sort) && $sort !== "ASC"){ echo "color";  }?>'>تصاعدي</a>
                <?php 
                    }
                    if ( !isset($_GET["viewbills"]) ) {?>
                        <a href='?typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?>'>تنازلي</a> |  
                        <a href='?typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";}elseif (!isset($sort) && $sort !== "ASC"){ echo "color";  }?>'>تصاعدي</a>
                <?php 
                    }
            echo "</div>";
            echo "</div>";
            echo "</div>";
            
            $memname = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = $usernow AND $typesear like '%$input%' ORDER BY ph_id $sort");
            $memname->execute();
            $like = $memname->fetchAll();
            $rowcounts = $memname->rowCount();
            if ( $rowcounts !== 0 ) {
                if ( !isset($_GET["viewbills"]) ) {
                    echo "<div class='data-bills'>";   
                        echo "<table ='table-responsive text-center'>";
                            echo "<tr>";
                                echo "<td>الرقم التسلسلي</td>";
                                echo "<td>تاريخ اصدارها</td>";                            
                                echo "<td>اسم المستهلك</td>";
                                echo "<td>من تاريخ</td>";
                                echo "<td>الى تاريخ</td>";
                                echo "<td>المتاخرات</td>";
                                echo "<td>القراءة السابقة</td>";
                                echo "<td>القراءة الحالية</td>";
                                echo "<td>الاستهلاك</td>";
                                echo "<td>قيمة الاستهلاك</td>";
                                echo "<td>الاشتراك</td>";
                                echo "<td>اجمالي</td>";
                                echo "<td class='no-print'>التحكم</td>";
                            echo "</tr>";
                }
            ?> 
            <div class='pho-all'>
                <?php  foreach ( $like as $row ) {  
                    $datever = str_replace("-", "/", $row["date_ver"]);
                    $datefor = str_replace("-", "/", $row["date_for"]);
                    $dateto = str_replace("-", "/", $row["date_to"]);
                    $endsid = $row["sysid_ph"];
                    if ( !isset($_GET["viewbills"]) ) {
                        echo "<tr>";
                            echo "<td>" . $row["ph_id"] . "</td>";
                            echo "<td>" . $row["date_ver"] . "</td>";
                            echo "<td>" . $row["mem_name"] . "</td>";
                            echo "<td>" . $row["date_for"] . "</td>";
                            echo "<td>" . $row["date_to"] . "</td>";
                            echo "<td>" . $row["latest"] . "</td>";
                            echo "<td>" . $row["relatest"] . "</td>";
                            echo "<td>" . $row["relanow"] . "</td>";
                            echo "<td>" . $row["count_go"] . "</td>";
                            echo "<td>" . $row["count_price"] . "</td>";
                            echo "<td>" . $row["shaer"] . "</td>";
                            echo "<td>" . $row["all_clom"] . "</td>";
                            echo "<td class='no-print'><a href='?do=Deletephoto&ph_id=". $row["ph_id"] ."' class='text-danger confirm'> حذف </a><a href='?do=Edphoto&ph_id=" . $row["ph_id"] . "' class='text-success'> تعديل </a> <a href='?do=printonlay&ph_id=" . $row["ph_id"] . "' class='text-primary'> طباعة </a></td>";
                        echo "</tr>";
                } if ( isset($_GET["viewbills"]) ) {
                    $option = $con->prepare("SELECT * FROM `optionbill` WHERE option_user = ?");
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
                    <?php
                }
        }
        echo "</div>
        </div>";
                echo "</table>";
            echo "</div>";
        echo "</div>";
            }else {
                            echo "<h1 class='text-center'>لا يوجد اي نتائج</h1>";
                    echo "</table>";
                echo "</div>";
            }
        }
    } elseif ( $do == "printes" ) {
        $select = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ?");
        $select->execute(array($usernow));
        $rows = $select->fetchAll();
        $exsit = $select->rowCount();
        if ( $exsit > 0 ) {
            echo "<div class='btn-print'>";
                echo "<div class='btn-pri'>";
                    echo "<button onclick='window.print();return false;'> <i class='fa fa-print'> طباعة </i> </button>";
                echo "</div>";
            echo "</div>";
            echo "<h1 class='text-center no-print'>مجمل الفواتير</h1>";
            ?> 
            <div class='pho-all'>

                <?php  foreach ( $rows as $row ) {  
                    $datever = str_replace("-", "/", $row["date_ver"]);
                    $datefor = str_replace("-", "/", $row["date_for"]);
                    $dateto = str_replace("-", "/", $row["date_to"]);
                    $endsid = $row["sysid_ph"];

                    $option = $con->prepare("SELECT * FROM `optionbill` WHERE option_user = ?");
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
                            <span class="phon text-center" style="bottom:39px;width: 200px;display: block;">اسم المحصل / <?php echo $row["name_manage"]; ?></span>
                            <span class="phon">للتواصل : <?php echo $row["number_manage"]; ?> </span>
                            
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
                                    <!-- 
                                    <td>سعر الوحدة</td>
                                    -->                                    
                                    <td>قيمة الاستهلاك</td>
                                    <td>الاشتراك</td>
                                    <td>اجمالي</td>
                                </tr>
                                <tr>
                                    <td><?php echo $row["latest"]; ?></td>
                                    <td><?php echo $row["relatest"] ?></td>
                                    <td><?php echo $row["relanow"] ?></td>
                                    <td><?php echo $row["count_go"] ?></td>
                                    <!-- 
                                    <td><?php echo $row["count_price"] ?></td>
                                    -->
                                    <td><?php echo $row["price_going"] ?></td>
                                    <td><?php echo $row["shaer"] ?></td>
                                    <td><?php echo $row["all_clom"] ?></td>
                                </tr>
                            </table>
                            <div class="footerphoto">
                                <span class="print-red">ملاحظة :- </span>
                                <p><?php echo  str_replace("+", "<br>", $options["title_footer"]); ?></p>
                            </div>
                        </div>
                    </div> 
            <?php }
        } else {
            echo "<div class='nice-mass h2 text-center'>لا يوجد اي فواتير</div>";
        }
        echo "</div>
        </div>";
    } elseif ( $do == "getdates" ) {
        $stmt = $con->prepare("SELECT CURDATE() AS datetoday");
        $stmt->execute();
        $datetoday = $stmt->fetch();

        echo "<h1 class='text-center'> لمعاينة وطباعة فواتير بتاريخ اصدار معين</h1>"; ?>
        <div class="input-date">
            <form class="form-group" action="?do=viewlike" method="POST">
                <h3>ادخل تاريخ اصدار الفواتير</h3>
                <input type="date" name="verdate" value="<?php echo $datetoday["datetoday"]; ?>" class="form-control" required>
                <input type="submit" value="متابعة" class="btn btn-success" required>
            </form>
        </div>
        <?php
    }elseif ( $do == "viewlike" ) {
        $datever = str_replace("-", "/", $_POST["verdate"]);
        $searchs = $_POST["verdate"];
        $type = "date_ver";
        echo "<h1 class='text-center no-print'> اصدار فواتير لتاريخ " .$datever . "</h1>";
            ?>
            <div class='pho-all'>
            
            <?php  
            $stmt = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE groupuser = $usernow AND $type LIKE '$searchs' ORDER BY ph_id DESC");
            $stmt->execute(array($searchs));
            $like = $stmt->fetchAll();
            foreach ( $like as $row ) {  
                $datever = str_replace("-", "/", $row["date_ver"]);
                $datefor = str_replace("-", "/", $row["date_for"]);
                $dateto = str_replace("-", "/", $row["date_to"]);
                $endsid = $row["sysid_ph"];

                $option = $con->prepare("SELECT * FROM `optionbill`  WHERE option_user = ?");
                $option->execute(array($usernow));
                $options = $option->fetch();

                $newline = str_replace("+", "<br>", $row["ph_footer"]);
                ?>
               
                <div class='pho no-print'>
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
                                <!-- <td>سعر الوحدة</td> -->
                                <td>قيمة الاستهلاك</td>
                                <td>الاشتراك</td>
                                <td>اجمالي</td>
                            </tr>
                            <tr>
                                <td><?php echo $row["latest"]; ?></td>
                                <td><?php echo $row["relatest"] ?></td>
                                <td><?php echo $row["relanow"] ?></td>
                                <td><?php echo $row["count_go"] ?></td>
                                <!-- <td><?php echo $row["count_price"] ?></td> -->
                                <td><?php echo $row["price_going"] ?></td>
                                <td><?php echo $row["shaer"] ?></td>
                                <td><?php echo $row["all_clom"] ?></td>
                            </tr>
                        </table>
                        <div class="footerphoto">
                            <span class="print-red">ملاحظة :- </span>
                            <p><?php echo $newline; ?></p>
                        </div>
                    </div>
                </div>
                <!-- End Bill New To Print Only -->
                <?php 
                echo "<div class='btn-print'>";
                    echo "<div class='btn-pri'>";
                        echo "<button onclick='window.print();return false;'> <i class='fa fa-print'> طباعة </i> </button>";
                    echo "</div>";
                echo "</div>";    
                }foreach ( $like as $row ) { 
                    $newline = str_replace("+", "<br>", $row["ph_footer"]);
                ?>
                <!-- Start Bill New To Print Only -->
                
                <div class="bill-full print-only" style='margin-top: 30px'>
                           
                    <div class="bill-back"><img src="img.jpg"></div>
                    <div class="footer-bill">
                        <div class="img-footer">
                        <div class="border"></div>
                        <img src="img.jpg"  class="img-responsive">
                        </div>
                        <div class="text-center">
                            <p>فاتورة استهلاك كهرباء</p>            
                            <p> من تاريخ :  <?php echo $datefor; ?> الى تاريخ : <?php echo $dateto; ?></p>
                        </div>
                        <div class="data-bill">
                        <p>رقم الفاتورة : <?php echo $row["ph_id"];?></p>
                        <p>تاريخ اصدارها : <?php echo $datever; ?></p>
                        
                        </div>
                        <div class="data-left">
                        <p class="text-center name-com"><?php echo $options["name_unit"] ?></p>
                        <p class="text-center">لتوليد وتوصيل الكهرباء</p>
                        <p  class="text-center" style="margin:10px auto;">للتواصل : <?php echo $row["number_manage"] ?></p>
                        </div>
                        <div class="data-member">
                            <p class="name"> <i class="fa fa-user-o"></i> اسم المستهلاك : <?php echo $row["mem_name"] ?>  </p>            
                            <p class="name"> <i class="fa fa-tags"></i> العنوان  :    <?php echo $row["title_mem"] ?> </p>
                            <p class="name"> <i class="fa fa-building-o"></i> نوع الاشتراك  :   <?php echo $row["type_join"] ?></p>
                        
                            <p class="name"> <i class="fa fa-mobile"></i>  رقم الهاتف : <?php echo $row["nphon"] ?></p>
                        </div>
                        <div class="table-bill">
                        <table>
                            <tr>
                                <td>المتاخرات</td>
                                <td>القراءة السابقة</td>
                                <td>القراءة الحالية</td>
                                <td>الاستهلاك</td>
                                <!-- <td>سعر الوحدة</td> -->
                                <td style="width: 200px">قيمة الاستهلاك</td>
                                <td>الاشتراك</td>
                                <td>اجمالي</td>
                            </tr>
                            <tr>
                                <td><?php echo $row["latest"]; ?></td>
                                <td><?php echo $row["relatest"] ?></td>
                                <td><?php echo $row["relanow"] ?></td>
                                <td><?php echo $row["count_go"] ?></td>
                                <!-- <td><?php echo $row["count_price"] ?></td> -->
                                <td><?php echo $row["price_going"] ?></td>
                                <td><?php echo $row["shaer"] ?></td>
                                <td><?php echo $row["all_clom"] ?></td>
                            </tr>
                        </table>
                        </div>
                        <div class="title-bill">
                        <h3>> ملاحظة </h3>
                        <h4><?php echo $newline ?></h4>
                        <div class="data-mang">
                            <h2 class="h4"> اسم المحصل / <?php echo $row["name_manage"]; ?> </h2>
                            <h2 class="h4">لتواصل : <?php echo $row["pn_collector"]; ?>  </h2>
                            <h2 class="h4">المبلغ المسلم:.....</h2>
                            <!--770151103-->
                            <!--772437718-->
                        </div>
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        <div class="given no-print">
                        <h4 class="text-center"> من تاريخ :  <?php echo $row["date_for"]; ?> الى تاريخ : <?php echo $row["date_to"]; ?></h4>
                            <p class='name'> اسم المستهلاك : <?php echo $row["mem_name"] ?>  </p>
                            <p class="">رقم المستهلك :   <?php echo $row["sys_id"] ?>  </p>
                            <p class="">اجمالي :  <?php echo $row["all_clom"] ?></p>
                            <p>المبلغ المسلم :  .......</p>
                            
                        </div>
                    </div>
                </div>
                <?php 
                            $copls++;
                            if ( $copls == 3 ) {
                        
                            echo '<div style="margin-bottom: 1300px;"></div>';
                            $copls = 0;
                            }
                        ?>
<?php
}if ( empty($like) ) {
        echo "<h2 class='text-center'>لايوجد اي نتائج</h2>";
    }
    }elseif ( $do == "tablebill" ) {
        // Button Print
            echo "<div class='btn-print'>";
                echo "<div class='btn-pri'>";
                    echo "<button onclick='window.print();return false;'> <i class='fa fa-print'> طباعة </i> </button>";
                echo "</div>";
            echo "</div>";
            echo "<h1 class='print-onlay text-center'>كشف الفواتير</h1>";

        $select = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE groupuser = ? ORDER BY ph_id  $sort");
        $select->execute(array($usernow));
        $rows = $select->fetchAll();
        echo "<div class='container'>";
            echo "<div class='all-btns no-print'>";            
                echo "<div class='search'>";
                    echo "<form daction='?do=searchphoto' method='GET'>";
                        echo "<input type='search' name='searmem' placeholder='بحث في ...' class='form-control search' />"; ?>
                            <select class='btn btn-success' name='typesear'>
                                <option <?php if ( $typesear == "mem_name" ){echo "selected";} ?> value='mem_name'>اسم الفاتورة</option>
                                <option <?php if ( $typesear == "date_ver" ){echo "selected";} ?> value='date_ver'>تاريخ اصدارها</option>
                                <option <?php if ( $typesear == "ph_id" ){echo "selected";} ?> value='ph_id'>رقم الفاتورة</option>
                            </select>
                        </form>
                    </div>
                <?php ?>
                <div class='pull-left sort'>
                    <span class="no-print">ترتيب : </span>
                    <?php 
                    if ( isset($_GET["viewbills"]) ) {?>
                        <a class="no-print" href='?typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&viewbills&sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?>'>تنازلي</a> |  
                        <a class="no-print" href='?typesear=<?php echo $typesear; ?>&searmem=<?php echo $input; ?>&viewbills&sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";}elseif (!isset($sort) && $sort !== "ASC"){ echo "color";  }?>'>تصاعدي</a>
                <?php 
                    }
                    if ( !isset($_GET["viewbills"]) ) {?>
                        <a href='?do=tablebill&sort=DESC' class='<?php if (isset($sort) && $sort == "DESC"){echo "color";} ?> no-print'>تنازلي</a> |  
                        <a href='?do=tablebill&sort=ASC' class='<?php if (isset($sort) && $sort == "ASC"){echo "color";}elseif (!isset($sort) && $sort !== "ASC"){ echo "color";  }?> no-print'>تصاعدي</a>
                <?php 
                    } 
            echo "</div>";
            echo "</div>";
            echo "</div>";
        echo "<div class='data-bills'>";   
            echo "<table ='table-responsive text-center'>";
                    echo "<tr>";
                        echo "<td>الرقم التسلسلي</td>";
                        echo "<td>تاريخ اصدارها</td>";                            
                        echo "<td>اسم المستهلك</td>";
                        echo "<td>من تاريخ</td>";
                        echo "<td>الى تاريخ</td>";
                        echo "<td>المتاخرات</td>";
                        echo "<td>القراءة السابقة</td>";
                        echo "<td>القراءة الحالية</td>";
                        echo "<td>الاستهلاك</td>";
                        echo "<td>سعر الوحدة</td>";
                        echo "<td>قيمة الاستهلاك</td>";
                        echo "<td>الاشتراك</td>";
                        echo "<td>اجمالي</td>";
                        echo "<td class='no-print'>التحكم</td>";
                    echo "</tr>";
            ?> 
            <div class='pho-all print-onlay'>
                
                <?php  foreach ( $rows as $row ) {  
                    echo "<tr>";
                        echo "<td>" . $row["ph_id"] . "</td>";
                        echo "<td>" . $row["date_ver"] . "</td>";
                        echo "<td>" . $row["mem_name"] . "</td>";
                        echo "<td>" . $row["date_for"] . "</td>";
                        echo "<td>" . $row["date_to"] . "</td>";
                        echo "<td>" . $row["latest"] . "</td>";
                        echo "<td>" . $row["relatest"] . "</td>";
                        echo "<td>" . $row["relanow"] . "</td>";
                        echo "<td>" . $row["count_go"] . "</td>";
                        echo "<td>" . $row["count_price"] . "</td>";
                        echo "<td>" . $row["count_price"] * $row["count_go"] . "</td>";
                        echo "<td>" . $row["shaer"] . "</td>";
                        echo "<td>" . $row["all_clom"] . "</td>";
                        echo "<td class='no-print'><a href='?do=Deletephoto&ph_id=". $row["ph_id"] ."' class='text-danger confirm'> حذف </a><a href='?do=Edphoto&ph_id=" . $row["ph_id"] . "' class='text-success'> تعديل </a> <a href='?do=printonlay&ph_id=" . $row["ph_id"] . "' class='text-primary'> طباعة </a></td>";
                    echo "</tr>";
                
        }
                echo "</table>";
            echo "</div>";
        echo "</div>";        
    }elseif ( $do == "printonlay" ){
        $ph_id = $_GET["ph_id"];
        echo "<div class='btn-print'>";
            echo "<div class='btn-pri'>";
                echo "<button onclick='window.print()'> <i class='fa fa-print'> طباعة </i> </button>";
            echo "</div>";
        echo "</div>";
        $select = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE groupuser = ? AND ph_id = ?");
        $select->execute(array($usernow,$ph_id));
        $row = $select->fetch();
        $ron = $select->rowCount();
        $sysidph = $row["sysid_ph"];
        if ( $ron > 0 ) {
        ?>
        <div class='pho-all'>

        <?php
        $datever = str_replace("-", "/", $row["date_ver"]);
        $datefor = str_replace("-", "/", $row["date_for"]);
        $dateto = str_replace("-", "/", $row["date_to"]);
        $endsid = $row["sysid_ph"];

        $option = $con->prepare("SELECT * FROM `optionbill`  WHERE option_user = ?");
        $option->execute(array($usernow));
        $options = $option->fetch();

                    $newline = str_replace("+", "<br>", $row["ph_footer"]);
                    ?>
                     <!-- Start Bill New To Print Only -->
                    <div class="bill-full print-only ">
                        <div class="bill-back"><img src="img.jpg"></div>
                        <div class="footer-bill">
                            <div class="img-footer">
                            <div class="border"></div>
                            <img src="img.jpg"  class="img-responsive">
                            </div>
                            <div class="text-center">
                                <p>فاتورة استهلاك كهرباء</p>            
                                <p> من تاريخ :  <?php echo $datefor; ?> الى تاريخ : <?php echo $dateto; ?></p>
                            </div>
                            <div class="data-bill">
                            <p>رقم الفاتورة : <?php echo $row["ph_id"];?></p>
                            <p>تاريخ اصدارها : <?php echo $datever; ?></p>
                            
                            </div>
                            <div class="data-left">
                            <p class="text-center name-com"><?php echo $options["name_unit"] ?></p>
                            <p class="text-center">لتوليد وتوصيل الكهرباء</p>
                            <p  class="text-center" style="margin:10px auto;">للتواصل : <?php echo $row["number_manage"] ?></p>
                            </div>
                            <div class="data-member">
                                <p class="name"> <i class="fa fa-user-o"></i> اسم المستهلاك : <?php echo $row["mem_name"] ?>  </p>            
                                <p class="name"> <i class="fa fa-tags"></i> العنوان  :    <?php echo $row["title_mem"] ?> </p>
                                <p class="name"> <i class="fa fa-building-o"></i> نوع الاشتراك  :   <?php echo $row["type_join"] ?></p>
                                <p class="name"> <i class="fa fa-mobile"></i>  رقم الهاتف : <?php echo $row["nphon"] ?></p>
                            </div>
                            <div class="table-bill">
                            <table>
                                <tr>
                                    <td>المتاخرات</td>
                                    <td>القراءة السابقة</td>
                                    <td>القراءة الحالية</td>
                                    <td>الاستهلاك</td>
                                    <!-- <td>سعر الوحدة</td> -->
                                    <td style="width: 200px;">قيمة الاستهلاك</td>
                                    <td>الاشتراك</td>
                                    <td>اجمالي</td>
                                </tr>
                                <tr>
                                    <td><?php echo $row["latest"]; ?></td>
                                    <td><?php echo $row["relatest"] ?></td>
                                    <td><?php echo $row["relanow"] ?></td>
                                    <td><?php echo $row["count_go"] ?></td>
                                    <!-- <td><?php echo $row["count_price"] ?></td> -->
                                    <td><?php echo $row["price_going"] ?></td>
                                    <td><?php echo $row["shaer"] ?></td>
                                    <td><?php echo $row["all_clom"] ?></td>
                                </tr>
                            </table>
                            </div>
                            <div class="title-bill">
                            <h3>> ملاحظة </h3>
                            <h4><?php echo $newline ?></h4>
                            <div class="data-mang">
                                <h2 class="h4"> اسم المحصل / <?php echo $row["name_manage"]; ?> </h2>
                                <h2 class="h4">لتواصل : <?php echo $row["pn_collector"]; ?>  </h2>
                                <!-- 772800609 -->
                                <!-- 773401335 -->
                                <h2 class="h4">المبلغ المسلم:.....</h2>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                            </div>
                            <!-- <div class="given">
                            <h4 class="text-center"> من تاريخ :  <?php echo $row["date_for"]; ?> الى تاريخ : <?php echo $row["date_to"]; ?></h4>
                                <p class='name'> اسم المستهلاك : <?php echo $row["mem_name"] ?>  </p>
                                <p class="">رقم المستهلك :   <?php echo $row["sys_id"] ?>  </p>
                                <p class="">اجمالي :  <?php echo $row["all_clom"] ?></p>
                                <p>المبلغ المسلم :  .......</p>
                                
                            </div> -->
                        </div>
                    </div>
                     <!-- End Bill New To Print Only -->                    
                    <div class='pho no-print'>
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
            <?php
        }else {
            header("location: ?");
        } 

    }elseif ( $do == "Edphoto" ) {
        $ph_id = $_GET["ph_id"];
        $select = $con->prepare("SELECT * FROM `photo` JOIN `mem-shr` ON photo.sysid_ph = `mem-shr`.sys_id INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? AND ph_id = ?");
        $select->execute(array( $usernow,$ph_id));
        $rows = $select->fetch();
        $ron = $select->rowCount();
        $types = $con->prepare("SELECT types FROM `types_sar`");
        $types->execute();
        $typeshr = $types->fetchAll();
        if ( $ron > 0 ) {
        ?>
        <div class="add-mem">
            <div class="container">
            <h1 class="text-center">تعديل بيانات الفاتورة</h1>
                <form action="?do=Updatephoto" method="POST" class="form-group">
                    <div class="row">
                        <input type="hidden" name="ph_id" value="<?php echo $rows["ph_id"] ?>">
                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">اسم المشترك</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="text" class="form-control" readonly autocomplete="off" name="ph_id" value="<?php echo $rows["ph_name"] ?>">                                  
                            </div>
                            <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">العنوان</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="text" readonly autocomplete="off" value="<?php echo $rows["title_mem"]; ?>" name="title_mem" class="form-control" placeholder="ادخل عنوان المشترك" required pattern=".{4,}" title="يجب الايكون عنوان المشترك اقل من  4 احرف">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">سعر الكيلوا</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" readonly min="0" autocomplete="off" value="<?php echo $rows["count_price"]; ?>" name="count_price" class="form-control" placeholder="ادخل سعر الكيلوا للمشترك" required>                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">القراءة السابقه</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" readonly min="0" autocomplete="off" value="<?php echo $rows["relatest"]; ?>" name="relatest" class="form-control" placeholder="ادخل القراة السابقه">                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">القراءة الحاليه</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" readonly min="0" autocomplete="off" value="<?php echo $rows["relanow"]; ?>" name="relanow" class="form-control" placeholder="ادخل اخر قراءة" >                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">من تاريخ</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="date" autocomplete="on" value="<?php echo $rows["date_for"]; ?>" name="date_for" class="form-control" placeholder="ادخل سعر الاشتراك" required>                                
                        </div>
                        <!--  End Input Name Member -->

                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">الى تاريخ</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="date" min="0" autocomplete="on"  value="<?php echo $rows["date_to"]; ?>" name="date_to" class="form-control" placeholder="ادخل تكلفة الاشتراك" required>                                
                        </div>
                        <!--  End Input Name Member -->
                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">الاشتراك</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                            <input type="number" readonly min="0" autocomplete="off"  value="<?php echo $rows["price_sh"]; ?>" name="shaer" class="form-control" placeholder="ادخل قيمة الاشتراك الاسبوعي" required>                                
                        </div>
                        <!--  End Input Name Member -->
                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2 control-label rtl-right stlab">
                            <label class="text-right">نوع الاشتراك</label>                                
                        </div>
                        <div class="col-md-4 rtl-right">
                        <input type="text" readonly  value="<?php echo $rows["type_join"]; ?>" name="shaer" class="form-control" required>                              
                        </div>
                        <!--  End Input Name Member -->
                        <!--  Start Input Name Member -->
                        <div class="text-right col-sm-2  control-label rtl-right stlab">
                            <label class="text-right">المتاخرات</label>                                
                        </div>
                        <div class="col-md-4 rtl-right ">
                            <input type="number" readonly autocomplete="off"  value="<?php echo $rows["latest"]; ?>" name="latest" class="form-control" placeholder="ادخل قيمة الاشتراك الاسبوعي" required>                                
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
        }else {
            header("location: ?");
        }
        }elseif( $do == "Updatephoto" ){
            if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
                $ph_id              = $_POST["ph_id"];
                $sysid_ph           = $_POST["sysid_ph"];
                $title_mem          = $_POST["title_mem"];
                $count_price        = $_POST["count_price"];
                $relatest           = $_POST["relatest"];
                $relanow            = $_POST["relanow"];
                $count_go           = $_POST["relanow"] - $_POST["relatest"];
                $date_for           = $_POST["date_for"];
                $date_to            = $_POST["date_to"];
                $shaer              = $_POST["shaer"];
                $type_join          = $_POST["type_join"];
                $latest             = $_POST["latest"];
                $all_clom           = $_POST["all_clom"];
                $select = $con->prepare("UPDATE `photo` SET `sysid_ph` = ?, `title_mem` = ?,`count_price` = ?, `relatest` = ?, `relanow` = ?, count_go = ?, `date_for` = ?, `date_to` = ?,`shaer` = ?, `type_join` = ?, `latest` = ?, `all_clom` = ? WHERE `photo`.`ph_id` = ?");
                $select->execute(array($sysid_ph, $title_mem, $count_price, $relatest, $relanow, $count_go, $date_for, $date_to ,$shaer, $type_join, $latest, $all_clom, $ph_id));
                $bind = $select->rowCount();
                    echo "<h1 class='text-center nice-mass'>تم حفظ التغيير</h1>";
                    transitionpages("back",".5");
            }
        }elseif ( $do == "Deletephoto" ) {
        $ph_id = $_GET["ph_id"];
        if ( intval($ph_id) ) {
            $sysid = $_GET["sysid"];
            $stmt = $con->prepare("DELETE FROM `photo` WHERE `ph_id` = ?");
            $stmt->execute(array($ph_id));
            header("location: ?do=tablebill");
        }
    }
    
    include "footer.php";
}else {
    header("location:index.php");
    exit();
}
?>