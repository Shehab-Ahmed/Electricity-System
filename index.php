<?php
    session_start();
    $navbar = "";
    echo "<body style='background:#fff'";
    include "ini.ttf";
    if ( isset($_SESSION["userhome"]) ) {
       header("location: dabbkn.php");
    }elseif ( isset($_SESSION["usersub"]) ) {
        header("location: sursub/dabbkn.php");
    }
    if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
        $pass = sha1($_POST["pass"]);
        $user = $_POST["user"];
        $stmt = $con->prepare("SELECT * from login WHERE passsystem = ? AND username = ?");
        $stmt->execute(array($pass,$user));
        $row = $stmt->fetch();
        echo $row["groupes"];
        $count = $stmt->rowCount();
        if ( $row["groupes"] == 0 ) {
            if ( $count > 0 ) {
                $_SESSION["userhome"] = $user;
                $_SESSION["login"] = $row["login_id"];
                header("location: dabbkn.php");
            }
        }elseif ( $row["groupes"] == 1 ) {
            $_SESSION["usersub"] = $user;
            $_SESSION["login"] = $row["login_id"];
            header("location: sursub/dabbkn.php");
            echo "Sub user";
        }elseif ( $row["groupes"] == 3 ) {
            $_SESSION["subuser"] = $user;
            $_SESSION["login"] = $row["login_id"];
            header("location: subuser/dabbkn.php");
        }
    }

    ?>
    <div class="login">
        <div class="img-login">
            <img class="img-responsive" src="im.ttf">
        </div>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="form-group">
            <input type="text" autocomplete="off" name="user" class="form-control" placeholder="ادخل اسم المستخدم">
            <input type="password"  autocomplete="off" name="pass" class="form-control" placeholder="ادخل كلمة المرور">
            <input type="submit" class="form-control" value="دخول">
        </form>
    </div>
<?php 
    include "footer.php";
?>
    