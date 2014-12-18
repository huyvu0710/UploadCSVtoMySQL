<meta charset="utf-8"/>

<?php
$dsn = "mysql:host=localhost;dbname=rubikin_db";
$user = "root";
$password = "";

$sql = 'LOAD DATA INFILE  "\\\WebIT\\\Xampp\\\htdocs\\\MyWeb\\\06_Nilead\\\CSV\\\product8000.csv"
                                INTO TABLE product
                                FIELDS TERMINATED BY  ","
                                ENCLOSED BY  ""
                                LINES TERMINATED BY  "\n"
                                IGNORE 1 LINES
                                (id, name, slug, short_description, description, @available_on, @created_at, @updated_at, @deleted_at, variant_selection_method)';
$sql .= "SET
created_at = STR_TO_DATE(@created_at,'% m /%d /%Y % H:%i'),
updated_at = STR_TO_DATE(@updated_at, ' % m /%d /%Y % H:%i'),
deleted_at = STR_TO_DATE(@deleted_at, ' % m /%d /%Y % H:%i'),
available_on = STR_TO_DATE(@available_on, ' % m /%d /%Y % H:%i')";
try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query("SET NAMES 'utf8'");

    try {
        if (isset($_POST['submit'])) {
            $dbh->query($sql);
        }

        if(isset($_POST['showsql'])){
            echo '<pre>';
            print_r($sql);
            echo '</pre>';
        }

    } catch (PDOException $e) {
        $dbh->rollBack();
    }
    $dbh = null;
} catch (PDOException $e) {
    echo "Failed to connect:" . $e->getMessage();
}
?>

<!--HTML-->
<form action="index.php" method="POST">
    <input type="submit" name="submit" value="Submit">
    <input type="submit" name="showsql" value="Sql">
</form>
<!--End HTML-->
