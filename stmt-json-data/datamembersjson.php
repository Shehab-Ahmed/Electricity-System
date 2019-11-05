<?php
        include "../coonect.php";
        ob_start();

        session_start();

        if ( isset($_POST["Get_Groups"]) ) {

            $usernow = $_SESSION["login"];

            $stmt = $con->prepare("SELECT * FROM `groups` WHERE groupuser = ?");
            $stmt->execute(array($usernow));
            $rows = $stmt->fetchAll();
            header("Content-Type: application/JSON");

            echo json_encode($rows, JSON_PRETTY_PRINT);

        } else if ( isset($_POST["Get_Addad"]) ) {

            $usernow = $_SESSION["login"];

            $stmt = $con->prepare("SELECT * FROM `addad` WHERE whereuser = ?");
            $stmt->execute(array($usernow));
            $rows = $stmt->fetchAll();
            header("Content-Type: application/JSON");

            echo json_encode($rows, JSON_PRETTY_PRINT);


        } else if ( isset($_POST["Get_members_Gp"]) ) {

            $goupid = $_POST["Get_members_Gp"];

            $stmt = $con->prepare("SELECT * FROM `mem-shr` WHERE mem_group = ?");
            $stmt->execute(array($goupid));
            $rows = $stmt->fetchAll();
            header("Content-Type: application/JSON");

            echo json_encode($rows, JSON_PRETTY_PRINT);

        } else if ( isset($_POST["Get_members_Aded"]) ) {

            $goupid = $_POST["Get_members_Aded"];

            $stmt = $con->prepare("SELECT * FROM `mem-shr` WHERE id_adad = ? ORDER BY mem_name ASC");
            $stmt->execute(array($goupid));
            $rows = $stmt->fetchAll();
            header("Content-Type: application/JSON");

            echo json_encode($rows, JSON_PRETTY_PRINT);

        } else if ( isset($_POST["display_Data_member"]) ) {

        $userid = $_POST["display_Data_member"];
        $stmt = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
        $stmt->execute(array($userid));
        $rows = $stmt->fetchAll();

                
        // End Getting Latest
        header("Content-Type: application/JSON");

        echo json_encode($rows, JSON_PRETTY_PRINT);

        } else if ( isset($_POST["Member_Lastes"]) ) {

        $userid = $_POST["Member_Lastes"];
        $stmt = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
        $stmt->execute(array($userid));
        $rows = $stmt->fetchAll();

        // Start Getting Latest
        $userid = $_POST["Member_Lastes"];
                
        $give = $con->prepare("SELECT SUM(end_cou) AS allgiveins  FROM ends WHERE id_mem = ? AND ends_status = 1");
        $give->execute(array($userid));
        $togive = $give->fetch();

        $allend = $con->prepare("SELECT SUM(sum_countgo) AS allends FROM `photo` INNER  JOIN `mem-shr` ON `mem-shr`.`sys_id` = `photo`.`sysid_ph` WHERE sys_id = ?");
        $allend->execute(array($userid));
        $allends = $allend->fetch();

        $goupend = $allends["allends"] - $togive["allgiveins"];

        $total = array("latest" => $goupend);

        echo $goupend;
                
        } else if ( isset($_POST["Member_Lastes_to_push"]) ) {

        $userid = $_POST["Member_Lastes_to_push"];
        $stmt = $con->prepare("SELECT * FROM `mem-shr` WHERE sys_id = ?");
        $stmt->execute(array($userid));
        $rows = $stmt->fetchAll();

        // Start Getting Latest
        $userid = $_POST["Member_Lastes_to_push"];
                
        $give = $con->prepare("SELECT SUM(end_cou) AS allgiveins  FROM ends WHERE id_mem = ? AND ends_status = 1");
        $give->execute(array($userid));
        $togive = $give->fetch();

        $allend = $con->prepare("SELECT SUM(sum_countgo) AS allends FROM `photo` INNER  JOIN `mem-shr` ON `mem-shr`.`sys_id` = `photo`.`sysid_ph` WHERE sys_id = ?");
        $allend->execute(array($userid));
        $allends = $allend->fetch();

        $goupend = $allends["allends"] - $togive["allgiveins"];

        $total = array("latest" => $goupend);

        echo $goupend;
                
        // End Getting Latest

                
        // End Getting Latest
        // header("Content-Type: application/JSON");

        // echo json_encode($total, JSON_PRETTY_PRINT);

        } 

        // header("refresh:3;$url");
            
    