<?php
/************************************************************************************
 ********************************만든이 : 홍동우****************************************
 *******************************만든시기 : 2020/02/04**********************************
 ******************************내용: DB연결 로직***********************************************
 ************************************************************************************/

$dbHost = "vmp.company";
$dbUser = "root";
$dbPass = "Neungsoft1!";
$dbName = "vmp_cms";
$dbPort = "33066";

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
    $pdo = new PDO ("mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8", $dbUser, $dbPass);
    $pdo->query("set session character_set_connection=utf8mb4") or die("ERROR");
    $pdo->query("set session character_set_results=utf8mb4") or die("ERROR");
    $pdo->query("set session character_set_client=utf8mb4") or die("ERROR");
} catch (PDOException $e) {
    die("database 연결오류: " . $e->getMessage());
}


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//session_start();




//mysqli_query($connection, "set session character_set_connection=utf8") or die("ERROR");
//mysqli_query($connection, "set session character_set_results=utf8") or die("ERROR");
//mysqli_query($connection, "set session character_set_client=utf8") or die("ERROR");

// mysqli로 DB 연결하는 로직

?>
