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

    ?>

    <div class="add-mem">
                <div class="container">
                    <div class="row">
                        <form action="?do=Insertmem" method="POST" class="form-group">
                            <!-- Start Input Choose Status -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">النوع</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <select class="form-control type-shr" name="choose-type" required>
                                    <option value='NULL'>...</option>
                                    <option value='Get_Groups'>المجموعات</option>
                                    <option value='Get_Addad'>النقاط</option>
                                </select>                                
                            </div>
                            <!-- End Input Choose Status -->
                            <!-- Start Input Choose Data -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">م \ ع</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <select class="form-control type-shr" name="display-content" required>
                                    <option value=''>...</option>
                                </select>                                
                            </div>
                            <!-- End Input Choose Data -->
                            <!-- Start Display Members -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">المشتركين</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <select class="form-control type-shr" name="display-members" required>
                                    <option value=''>...</option>
                                </select>                                
                            </div>
                            <!-- End Display Members -->
                            <!--  Start Input Read Last -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">القراءة السابقة</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="text" disabled id="relast" name="relast" autocomplete="off" class="form-control" value="<?php echo $row["renow"]; ?>">                                
                            </div>
                            <!--  End Input Read Last -->
                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">القراءة الحالية</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="text" id="renow" name="renow" autocomplete="off" class="form-control" value="<?php echo $row["renow"]; ?>">                                
                            </div>
                            <!--  End Input Name Member -->
                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">الاستهلاك</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="text" disabled id="descount" autocomplete="off" class="form-control">                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">سعر الوحدة</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="text" id="nam_cou" disabled autocomplete="off" class="form-control" required value="<?php echo $row["nam_cou"] ?>">                                
                            </div>
                            <!--  End Input Name Member -->

                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">الاشتراك</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input disabled type="text" id="sub_scrip" autocomplete="off" class="form-control" required value="<?php echo $row["price_sh"] ?>">                                
                            </div>
                            <!--  End Input Name Member -->
                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">المتاخرات</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input disabled id="latests" type="text" min="0" autocomplete="off" class="form-control" value="<?php echo $goupend; ?>">                                
                            </div>
                            <!--  End Input Name Member -->
                            <!--  Start Input Name Member -->
                            <div class="text-right col-sm-2 control-label rtl-right stlab">
                                <label class="text-right">الأجمالي</label>                                
                            </div>
                            <div class="col-md-4 rtl-right">
                                <input type="text" disabled id="total" autocomplete="off" class="form-control">
                            </div>
                            <!--  End Input Name Member -->
                            <div class="col-md-12 rtl-right">
                                <input type="button" name="submit-bill" class="focus-select submit btn btn-success" value="إضافة">
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
    <?php
    if ( isset($_POST["Userid"]) ) {
        if ( isset($_GET["groupid"]) ){
            $groupids = "groupid=" .  $_GET["groupid"] . "&";
        }else {
            $groupids= "";
        }
        $do = isset($_GET["do"]) ? $_GET["do"] : 'Manage';
        $userid = $_POST["Userid"];
        $stmt = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
        $stmt->execute(array($userid));
        $rows = $stmt->fetchAll();

        // Start Getting Latest
        $userid = $_GET["userid"];
                
        $give = $con->prepare("SELECT SUM(end_cou) AS allgiveins  FROM ends WHERE id_mem = ? AND ends_status = 1");
        $give->execute(array($userid));
        $togive = $give->fetch();

        $allend = $con->prepare("SELECT SUM(sum_countgo) AS allends FROM `photo` INNER  JOIN `mem-shr` ON `mem-shr`.`sys_id` = `photo`.`sysid_ph` WHERE sys_id = ?");
        $allend->execute(array($userid));
        $allends = $allend->fetch();

        $goupend = $allends["allends"] - $togive["allgiveins"];
                
        // End Getting Latest
    }
    include "footer.php";


}else {
    header("location:index.php");
    exit();
}
    
?>