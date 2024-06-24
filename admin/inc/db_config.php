<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'event_website';

$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
  die("Cannot coonect to database " . mysqli_connect_error());
}


//to filter the entered data
function filtration($data)
{
  foreach ($data as $key => $value) {
    $value = trim($value); // to remove spaces
    $value = stripslashes($value); //to remove backslashes
    $value = strip_tags($value); //to remove html tags
    $value = htmlspecialchars($value); // to convert special chars into html entity
  
    $data[$key] = $value;
  
  }
  return $data;
}

function selectAll($table){
  $conn = $GLOBALS['conn'];
  $res = mysqli_query($conn,"SELECT *  FROM $table");
  return $res;
}

function select($sql, $values, $datatypes)
{
  $conn = $GLOBALS['conn'];
  if ($stmt = mysqli_prepare($conn, $sql)) {//prepares sql statement for execution
    mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //... is splat operator allows arbitary number of parameters
    if (mysqli_stmt_execute(($stmt))) {
      $res = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);

      return $res;
    } else {
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - SELECT");
    }
  } else {
    die("Query cannot be prepared - SELECT");
  }
}

function update($sql, $values, $datatypes)
{
  $conn = $GLOBALS['conn'];
  if ($stmt = mysqli_prepare($conn, $sql)) {//prepares sql statement for execution
    mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //... is splat operator allows arbitary number of parameters
    if (mysqli_stmt_execute(($stmt))) {
      $res = mysqli_stmt_affected_rows($stmt);
      mysqli_stmt_close($stmt);

      return $res;
    } else {
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - UPDATE");
    }
  } else {
    die("Query cannot be prepared - UPDATE");
  }
}


function insert($sql, $values, $datatypes)
{
  $conn = $GLOBALS['conn'];
  if ($stmt = mysqli_prepare($conn, $sql)) {//prepares sql statement for execution
    mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //... is splat operator allows arbitary number of parameters
    if (mysqli_stmt_execute(($stmt))) {
      $res = mysqli_stmt_affected_rows($stmt);
      mysqli_stmt_close($stmt);

      return $res;
    } else {
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - INSERT");
    }
  } else {
    die("Query cannot be prepared - INSERT");
  }
}


function delete($sql, $values, $datatypes)
{
  $conn = $GLOBALS['conn'];
  if ($stmt = mysqli_prepare($conn, $sql)) {//prepares sql statement for execution
    mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //... is splat operator allows arbitary number of parameters
    if (mysqli_stmt_execute(($stmt))) {
      $res = mysqli_stmt_affected_rows($stmt);
      mysqli_stmt_close($stmt);

      return $res;
    } else {
      mysqli_stmt_close($stmt);
      die("Query cannot be executed - DELETE");
    }
  } else {
    die("Query cannot be prepared - DELETE");
  }
}

