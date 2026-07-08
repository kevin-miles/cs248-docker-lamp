<pre>
<?php
$DBuser = 'root';
$DBpass = $_ENV['MYSQL_ROOT_PASSWORD'];
$pdo = null;

try{
    $database = 'mysql:host=database:3306';
    $pdo = new PDO($database, $DBuser, $DBpass);
    echo "Success: A proper connection to MySQL was made! The docker database is great." . PHP_EOL;    
} catch(\Throwable $e) {
    echo "Error: Unable to connect to MySQL. Error:\n" . $e->GetMessage() . PHP_EOL;
}

$pdo = null;
?>
</pre>
