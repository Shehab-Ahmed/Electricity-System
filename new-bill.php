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

    $do = isset($_GET["do"]) ? $_GET["do"] : 'Manage';
    $sort = $_GET["sort"];
    $usernow = $_SESSION["login"];
    // Query Is GET Group Exisist
    
    if ( isset($_GET["groupid"]) ){
        $groupids = "groupid=" .  $_GET["groupid"] . "&";
    }else {
        $groupids= "";
    }
    ?>
<div id="display"></div>
    <button onclick="showCustomer()">asd</button>
    <?php

    ?>
    <script>
function showCustomer() {
  var xhttp;
  var str = 123;
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("display").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "http://localhost/horsepower/info-bill.php?userid=176", true);
  xhttp.send();
}

</script>

    

    <?php
}else {
    header("location:index.php");
    exit();
}
    
?>