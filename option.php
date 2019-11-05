<?php

ob_start();

	session_start();

	$title = "Categories";

    $usernow = $_SESSION["login"];

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
    if ( $do == "Manage" ) {
        // Query Table Option Bills
        $optionbills = $con->prepare("SELECT * FROM optionbill WHERE option_user = ?");
        $optionbills->execute(array($usernow));
        $optionbill = $optionbills->fetch();

        // Query Table Option Shear
        $shear = $con->prepare("SELECT * FROM types_sar ORDER BY id_type DESC");
        $shear->execute();
        $count = $shear->rowCount();        
        $shears = $shear->fetchAll();

        // Query Table Users Login
        $users = $con->prepare("SELECT * FROM login ORDER BY login_id DESC");
        $users->execute();
        $countuser = $users->rowCount();        
        $showusers = $users->fetchAll();
        ?>
        <div class="container">
            <h1 class="text-center">الأعدادت</h1>
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">الفواتير</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse <?php if ( isset( $_GET["collbas"]) && $_GET["collbas"] == "1" ) { echo "in"; } ?>">
                        <div class="panel-body">
                            <h3> تاريخ الفواتير </h3>
                            <form action="?do=optionbill" method='POST' enctype="multipart/form-data" calss='form-group'>
                                <div class='from-in'>    
                                    <input type='date' name='datefor' value='<?php echo $optionbill["datefor"] ?>' class=' form-control'>
                                    <label> من تاريخ </label>
                                </div>
                                <div class='from-in'>
                                    <input type='date' name='dateto' value='<?php echo $optionbill["dateto"] ?>' class='form-control'>
                                    <label> الى تاريخ </label>
                                </div>
                                <h3> بيانات المحصل </h3>
                                <div class='from-in'>    
                                    <input type='text' name='datamang' value='<?php echo $optionbill["name_manager"] ?>' class=' form-control' placeholder='ادخل اسم المحصل'>
                                    <label> اسم المحصل </label>
                                </div>
                                <div class='from-in'>    
                                    <input type='text' name='phone_mohs' value='<?php echo $optionbill["phone_mohs"] ?>' class=' form-control' placeholder='ادخل رقم الهاتف'>
                                    <label> رقم الهاتف </label>
                                </div>
                                <div class='from-in'>
                                    <textarea name='tittlebill' class='form-control' placeholder='ادخل ملاحضة الفاتورة' ><?php echo $optionbill["title_footer"] ?></textarea>
                                    <label> ملاحظة الفواتير </label>
                                </div>
                                <h3> بيانات المحطة </h3>
                                <div class='from-in'>    
                                    <div class="cusetem-file text-center">
                                        <span> اختيار شعار رمزي </span>
                                        <input type="file" name="avatar" placeholder="أسم المستخدم"/>
                                    </div>
                                    <label> اختيار الشعار </label>                
                                </div>
                                <div class='from-in'>    
                                    <input type='text' name='nameshop' value='<?php echo $optionbill["name_unit"] ?>' class='name-mht form-control' placeholder=''>
                                    <label class="name-mht-lab"> اسم المحطة </label>
                                </div>
                                <div class='from-in'>    
                                    <input type='text' name='numphon' value='<?php echo $optionbill["numbers_phon"] ?>' class=' form-control' placeholder='ادخل رقم الهاتف'>
                                    <label> رقم الهاتف </label>
                                </div>
                                <br>
                                <div class='from-in'>
                                    <input type='submit' style="width: 80px;margin-top: 130px" class="btn btn-primary" value='حفظ'>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">الحسابات</a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse <?php if ( isset( $_GET["collbas"]) && $_GET["collbas"] == "2" ) { echo "in"; } ?>">
                    <div class="panel-body">
                        <a href="?Adduser=Adduser&collbas=2" class="btn btn-primary">إضافة حساب</a>
                        <a href="?showuser=showuser&collbas=2" class="btn btn-primary">عرض الحسابات</a>
                        <?php 
                        if ( isset($_GET["Adduser"]) && isset($_GET["Adduser"]) == "Adduser" ){?>
                            <div class="add-mem">
                                <div class="container">
                                    <form action="?do=Insertuser" method="POST" class="form-group">
                                        <div class="row">
                                            <!--  Start Input Name Member -->
                                            <div class="rtl-right">
                                                <input type="text" autocomplete="off" name="username" class="form-control" placeholder="اسم المستخدم" required>
                                                <input type="text" autocomplete="off" name="pass" class="form-control" placeholder="كلمة المرور" required>
                                            </div>
                                            <br>
                                            <div class="col-md-4 rtl-right">
                                            <select class="form-control type-shr" name="group" required>
                                                <option value='0'>رئيسي</option>
                                                <option value='1'>فرعي</option>
                                            </select>
                                            </div>
                                            <!--  End Input Name Member -->
                                            <div class="col-md-12 rtl-right">
                                                <input type="submit" style="width: 100px; margin-right: 90px" class="submit btn btn-primary" value="إضافة">                               
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                       <?php }
                       if ( isset($_GET["Edituser"]) && !isset($_GET["Adduser"]) == "Adduser" ){
                            $loginid = $_GET["loginid"];
                            $users = $con->prepare("SELECT * FROM login WHERE login_id = ?");
                            $users->execute(array($loginid));
                            $Editusers = $users->fetch();
                           ?>
                        <div class="add-mem">
                            <div class="container">
                                <form action="?do=updateuser" method="POST" class="form-group">
                                    <div class="row">
                                        <!--  Start Input Name Member -->
                                        <div class="rtl-right">
                                            <input type="hidden" value="<?php echo $Editusers["login_id"]; ?>" name="login_id"> 
                                            <input type="hidden" value="<?php echo $Editusers["passsystem"]; ?>" name="oldpass"> 
                                            <input type="text" value="<?php echo $Editusers["username"]; ?>" autocomplete="off" name="username" class="form-control" placeholder="اسم المستخدم" required>
                                            <input type="text" autocomplete="off" name="newpass" class="form-control" placeholder="كلمة المرور">
                                        </div>
                                        <br>
                                        <div class="col-md-4 rtl-right">
                                        <select class="form-control type-shr" name="group" required>
                                            <option value='0' <?php if ( $Editusers["groupes"] == 0 ) { echo "selected"; } ?>>رئيسي</option>
                                            <option value='1' <?php if ( $Editusers["groupes"] == 1 ) { echo "selected"; } ?>>فرعي</option>
                                        </select>
                                        </div>
                                        <!--  End Input Name Member -->
                                        <div class="col-md-12 rtl-right">
                                            <input type="submit" style="width: 100px; margin-right: 90px" class="submit btn btn-primary" value="إضافة">                               
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                   <?php } elseif ( isset($_GET["showuser"]) && !isset($_GET["Adduser"]) ) { ?>
                        <?php 
                        if ($countuser > 0) {
                        ?>
                                <div class="table-user">   
                                    <table ='table-responsive text-center'>
                                    <tr>
                                        <td>الاسم</td>
                                        <td>التاريخ</td>
                                        <td>نوع الحساب</td>
                                        <td>التحكم</td>
                                    </tr>
                                <?php
                                foreach ( $showusers as $showuser ) {
                                        echo "<tr>";
                                            echo "<td>" . $showuser["username"] . "</td>";
                                            echo "<td>" . $showuser["dateuser"] . "</td>";
                                            echo "<td>";
                                                if ( $showuser["groupes"] == "0" ) {
                                                    echo "رئيسي";
                                                }else {
                                                    echo "فرعي";
                                                }
                                            echo "</td>";
                                            echo "<td><a href='?do=Deleteuser&login_id=". $showuser["login_id"] ."' class='text-danger confirm'> حذف </a> <a href='?Edituser=Edituser&loginid=" . $showuser["login_id"] . "&collbas=2' class='text-success'> تعديل </a></td>";
                                        echo "</tr>";
                                }
                                    ?>
                                </table>
                            </div>                                
                        <?php } ?>
                    <?php } ?>
                        
                </div>
                </div>
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">الاشتراكات</a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse <?php if ( isset( $_GET["collbas"]) && $_GET["collbas"] == "3" ) { echo "in"; } ?>">
                    <div class="panel-body">
                        <div class="table-user">
                            <?php 
                                if ($count > 0) {
                            ?>
                            <table ='table-responsive text-center'>
                                <tr>
                                    <td>النوع</td>
                                    <td>التاريخ</td>
                                    <td>التحكم</td>
                                </tr>
                                <?php } ?>
                                <a href="?Add=Add&collbas=3" class="btn btn-primary">إضافة اشتراك</a>
                                <?php
                                foreach ( $shears as $shear ) {
                                    echo "<tr>";
                                        echo "<td>" . $shear["types"] . "</td>";
                                        echo "<td>" . $shear["datetype"] . "</td>";
                                        echo "<td><a href='?do=Delete&id_type=". $shear["id_type"] ."' class='text-danger confirm'> حذف </a> <a href='?Edit&id_type=" . $shear["id_type"] . "&collbas=3' class='text-success'> تعديل </a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                            <?php
                            $id_type = $_GET["id_type"];
                            $stmt = $con->prepare("SELECT * FROM types_sar WHERE id_type = ?");
                            $stmt->execute(array($id_type));
                            $row = $stmt->fetch();
                            if ( isset($_GET["Edit"]) && !isset($_GET["Add"]) ){
                            ?>
                            <div class="add-mem">
                                <div class="container">
                                    <form action="?do=update" method="POST" class="form-group">
                                        <div class="row">
                                        <input type="hidden" name="id_type" value="<?php echo $row["id_type"]; ?>" />
                                            <!--  Start Input Name Member -->
                                            <div class="rtl-right">
                                                <input style="width: 150px; margin-right: 100px" type="text" value="<?php echo $row["types"]; ?>" autocomplete="off" name="types" class="form-control" placeholder="نوع الاشتراك" required>                                
                                            </div>
                                            <!--  End Input Name Member -->
                                            <div class="col-md-12 rtl-right">
                                                <input type="submit" style="width: 100px; margin-right: 90px" class="submit btn btn-primary" value="حفظ">                               
                                            </div>
                                        </div>
                                    </form>
                            <?php } if ( isset($_GET["Add"]) && !isset($_GET["Edit"]) ){ ?>
                                        <div class="add-mem">
                                            <div class="container">
                                                <form action="?do=Insert" method="POST" class="form-group">
                                                    <div class="row">
                                                        <!--  Start Input Name Member -->
                                                        <div class="rtl-right">
                                                            <input style="width: 150px; margin-right: 100px" type="text" value="<?php echo $row["types"]; ?>" autocomplete="off" name="types" class="form-control" placeholder="إضافة اشتراك" required>                                
                                                        </div>
                                                        <!--  End Input Name Member -->
                                                        <div class="col-md-12 rtl-right">
                                                            <input type="submit" style="width: 100px; margin-right: 90px" class="submit btn btn-primary" value="إضافة">                               
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div> 
        </div>
        <?php
        
    }elseif ( $do == "Insertuser" ) {
        $username = $_POST["username"];
        $pass = $_POST["pass"];
        $shapass = sha1($pass);
        $group = $_POST["group"];
        echo $username;
        $insert = $con->prepare("INSERT INTO `login` (`username`, `passsystem`, `dateuser`,`groupes`) VALUES (:zusername, :zpasssystem, now(), :zgroupes)");
        $insert->execute(array(
            "zusername" => $username,
            "zpasssystem" => $shapass,
            "zgroupes" => $group
        ));
        header("location: ?Add=Add&collbas=2");
    } elseif ( $do == "Insert" ) {
        $types = $_POST["types"];
        $insert = $con->prepare("INSERT INTO `types_sar` (`types`, `datetype`) VALUES (:ztypes, now())");
        $insert->execute(array(
            "ztypes" => $types
        ));
        header("location: ?Add=Add&collbas=3");
        
    }elseif ( $do == "optionbill" ) {
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
            $datefor = $_POST["datefor"];
            $dateto = $_POST["dateto"];
            $name_manager = $_POST["datamang"];
            $numbers_phon = $_POST["numphon"];
            $phone_mohs = $_POST["phone_mohs"];
            $title_footer = $_POST["tittlebill"];
            $name_unit = $_POST["nameshop"];

            // Script Avatar 
            $avatarname       = $_FILES["avatar"]["name"];
            $avatarname       = $_FILES["avatar"]["name"];
            $avatartype       = $_FILES["avatar"]["type"];
            $avatartmpname    = $_FILES["avatar"]["tmp_name"];
            $arrayextension   = array("png","jpg","jpeg","gif");
             
            $rand = rand(0, 1000000000);
            // explode Avatar Extension
            $avatarextension = explode(".", $avatarname);
            $endavatarextension = strtolower(array_pop($avatarextension));

            if ( ! empty($avatarname) && ! in_array($endavatarextension, $arrayextension) ){
                $errorform = " يجب اختيار صورة لامكن السماح بهذا الامتداد";
            }
            $avatar = $rand ."_". $avatarname;
            //echo "<img src='uploade/avatar//" . $avatar . "'>"; 
            move_uploaded_file($avatartmpname, "uploade\avatar\\" . $avatar);
            
            $engi = $con->prepare("UPDATE `optionbill` SET datefor = ?, dateto = ?, `avatar` = ?, numbers_phon = ?, name_manager = ?, title_footer = ?, name_unit = ? , phone_mohs = ? WHERE option_user = ?");
            $engi->execute(array($datefor, $dateto, $avatar, $numbers_phon, $name_manager, $title_footer, $name_unit, $phone_mohs, $usernow));
            $count = $engi->rowCount();
            if ( !empty($avatarname) ) {
                echo "<script>alert('" . $errorform . "');</script>";
            }
            header("location: ?collbas=1");
        }
    } elseif ( $do == "update" ) {
        $id_type    = $_POST["id_type"];
        $types   = $_POST["types"];
        echo $id_type;
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
            $stmt = $con->prepare("UPDATE `types_sar` SET `types` = ? WHERE `id_type` = ?");
            $stmt->execute(array($types, $id_type));
            $count = $stmt->rowCount();
                echo "<h1 class='text-center nice-mass'>تم حفظ الغيير</h1>";
                header("location: ?collbas=3");
        }
    }elseif ( $do == "updateuser" ) {
        $login_id    = $_POST["login_id"];
        $username    = $_POST["username"];
        $group       = $_POST["group"];
        $oldpass     = $_POST["oldpass"];
        $newpass     = $_POST["newpass"];
        if ( empty($newpass) ) {
            $pass = $oldpass;
        }else {
            $pass = sha1($newpass);
        }
        if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
            $stmt = $con->prepare("UPDATE `login` SET `username` = ?,`passsystem` = ?,`groupes` = ? WHERE `login_id` = ?");
            $stmt->execute(array($username, $pass, $group, $login_id));
            $count = $stmt->rowCount();
                header("location: ?collbas=2&showuser=showuser");
        }
    }elseif ( $do == "Deleteuser" ) {
        $login_id = $_GET["login_id"];
        $stmt = $con->prepare("DELETE FROM `login` WHERE `login_id` = ?");
        $stmt->execute(array($login_id));
        header("location: ?collbas=2&showuser=showuser");
    } elseif ( $do == "Delete" ) {
        $id_type = $_GET["id_type"];
        $stmt = $con->prepare("DELETE FROM `types_sar` WHERE `id_type` = ?");
        $stmt->execute(array($id_type));
        header("location: ?collbas=3");
    }
    include "footer.php";
}else {
    header("location:index.php");
    exit();
}
    
?>