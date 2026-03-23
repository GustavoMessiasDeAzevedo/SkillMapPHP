<?php
$host = 'localhost';
$dbname = 'SkillMap';
$user ='root';
$pass = '';

try{

    $dns = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dns, $user, $pass);
    

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

}catch(PDOException $e){
    echo "Erro na conexão: " ;  $e->getMessage();
    exit;
}