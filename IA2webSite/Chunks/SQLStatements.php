
<?php
//this file is included after the variables are defined

//ensure that there are no undefined variables for the include to work
if($value==null){
    $value = "";
}
if($columnName==null){
    $columnName = "";
}
if($tablename==null){
    $tablename = "";
}
$SELECT = "SELECT $columnName FROM $tablename";
$SELECTDISTINCT = "SELECT DISTINCT $columnName FROM $tablename";
$INSERT = "INSERT INTO $tablename ($columnName) VALUES ('$value')";
$CHECKIFEXISTS = "SELECT $columnName FROM $tablename WHERE $columnName = '$value'";
?>
