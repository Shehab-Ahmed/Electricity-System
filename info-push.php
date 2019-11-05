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


	$select = $con->prepare("SELECT * FROM `mem-shr` INNER  JOIN `groups` ON `mem-shr`.`mem_group` = `groups`.`group_id` WHERE  groupuser = ? ORDER BY mem_name $sort");
	$select->execute(array($usernow));
	$rows = $select->fetchAll();

    ?>
    <div class="add-mem">
        <div class="container">
            <div class="row">
                <form action="?do=Insertmem" method="POST" class="form-group">
                    <input type="hidden" value="1" name="stat">
                    <!-- Start Display Members -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">المشتركين</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <select class="form-control type-shr" name="display-members-to-push" required>
                            <option value=''>...</option>
                            <?php foreach ( $rows as $row ) {
                            	echo "<option value='". $row['sys_id'] ."'>". $row["mem_name"] ."</option>";
                            } ?>
                        </select>                                
                    </div>
                    <!-- End Display Members -->
                    <!--  Start Input Read Last -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">التسليم</label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <input type="text" id="relast" autocomplete="off" name="new_cou" class="form-control">                                
                    </div>
                    <!--  End Input Read Last -->
                    <!--  Start Input Read Last -->
                    <div class="text-right col-sm-2 control-label rtl-right stlab">
                        <label class="text-right">المتأخرات </label>                                
                    </div>
                    <div class="col-md-4 rtl-right">
                        <input type="text" disabled id="latest-to-push" autocomplete="off" class="form-control" value="<?php echo $row["renow"]; ?>">                                
                    </div>
                    <!--  End Input Read Last -->
                    <div class="col-md-12 rtl-right">
                        <input type="button" name="submit" class="focus-select submit btn btn-success" value="إضافة">                               
                    </div>
                </form>
            </div>                    
        </div>
    </div>
    <script>
    	//  Add Push Mony
        showDataMember = document.querySelector('select[name=display-members-to-push]');
        showDataMember.addEventListener('change',function() {
            var req = new XMLHttpRequest();
            req.onreadystatechange = function() {
            if ( req.readyState == 4 && req.status == 200 ) {
                // var theContent = document.querySelector('select[name=display-members]');

                if ( req.response != '' ) {

                    document.getElementById("latest-to-push").value = req.responseText;

                }

            }
        }
        
        req.open("POST", "http://localhost/horsepower/stmt-json-data/datamembersjson.php");
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.send('Member_Lastes_to_push=' + this.value);

        }, false);

        //  Add Push Mony
        showDataMember = document.querySelector('input[name=submit]');
        showDataMember.addEventListener('click',function() {
            var req = new XMLHttpRequest();
            req.onreadystatechange = function() {
            if ( req.readyState == 4 && req.status == 200 ) {
                // var theContent = document.querySelector('select[name=display-members]');

                if ( req.response != '' ) {

                    // document.getElementById("latest-to-push").value = req.responseText;
                    alert('تم دفع مبلغ وقدرة : ' + pushMony);
        				

                }

            }
        }
        var pushMony = document.querySelector('input[name=new_cou]').value,
			stat = document.querySelector('input[name=stat]').value,
			sysID = document.querySelector('select[name=display-members-to-push]').value;

        req.open("POST", "http://localhost/horsepower/mrmshar.php?do=upendsnew&sys_id=" + sysID );
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.send('new_cou='+ pushMony +'&stat=' + stat);

        }, false);
    </script>
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