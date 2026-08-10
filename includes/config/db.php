<?php

$serverName = "localhost\\SQLEXPRESS02";
$databaseName = "PAYROLL";

try {
    $conn = new PDO(
        "sqlsrv:Server=$serverName;Database=$databaseName;TrustServerCertificate=true",
        null,
        null
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to PAYROLL database";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>  