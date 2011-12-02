<?php
    require 'chat.php';

    $chat = new Chat();

    if ($_GET["a"] == "i") {
        $chat->insertMsg(array("name"=>$_GET["n"],"msg"=>$_GET["m"]));	
    }

    $offset = null;
    if ($_GET["o"]) {
        $offset = $_GET["o"];
    }
    $log = $chat->getLog($offset);
    print $log;
?>
