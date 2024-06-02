<?php
// Copyright Reserved Wael Wael Abo Hamza (Course Ecommerce)

define("MB", 1048576);

function filterRequest($requestname)
{
    if (isset($_POST[$requestname])) {
        return htmlspecialchars(strip_tags($_POST[$requestname]));
    }
    return null;
}

function getAllData($table, $where = null, $values = null, $json = true)
{
    global $con;
    if ($where == null) {
        $stmt = $con->prepare("SELECT * FROM $table");
    } else {
        $stmt = $con->prepare("SELECT * FROM $table WHERE $where");
    }
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();

    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "Failure"));
        }
        return $count;
    } else {
        if ($count > 0) {
            return array("status" => "success" , "data" => $data);
        } else {
            return array("status" => "Failure");
        }

    }

}
function getData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $stmt = $con->prepare("SELECT * FROM $table WHERE $where");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    } else {
        return $count;
    }
}


function insertData($table, $data , $json )
{
    global $con;
    try {
        $fields = implode(',', array_keys($data));
        $values = array_map(function ($field) {
            return ":$field";
        }, array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES (" . implode(',', $values) . ")";
        $stmt = $con->prepare($sql);
        foreach ($data as $f => $v) {
            $stmt->bindValue(":$f", $v);
        }
        $stmt->execute();
        $count = $stmt->rowCount();
        if($json = true){
            if($count > 0){
                    echo json_encode(array("status" => "success"));
            }else{
                    echo json_encode(array("status" => "failure"));
            }
        }
       return  $count;
    } catch (PDOException $e) {
        echo json_encode(array("status" => "failure",
      //   "message" => $e->getMessage()
        
        ));
        return false;
    }
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    try {
        $setFields = array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($data));
        $sql = "UPDATE $table SET " . implode(', ', $setFields) . " WHERE $where";
        $stmt = $con->prepare($sql);
        $stmt->execute($data);
        $count = $stmt->rowCount();
        if ($json) {
            echo json_encode(array("status" => $count > 0 ? "success" : "failure"));
        }
        return $count;
    } catch (PDOException $e) {
        echo json_encode(array("status" => "error", "message" => $e->getMessage()));
        return 0;
    }
}

function deleteData($table,$where,$data ,$json = true)
{
    global $con;
    try {
        $stmt = $con->prepare("DELETE FROM $table WHERE $where");
        $stmt->execute($data);
        $count = $stmt->rowCount();
        if ($json) {
            echo json_encode(array("status" => $count > 0 ? "success" : "failure"));
        }
        return $count;
    } catch (PDOException $e) {
        echo json_encode(array("status" => "error", "message" => $e->getMessage()));
        return 0;
    }
}

function imageUpload($imageRequest)
{
    global $msgError;
    $imagename = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
    $imagetmp = $_FILES[$imageRequest]['tmp_name'];
    $imagesize = $_FILES[$imageRequest]['size'];
    $allowExt = array("jpg", "png", "gif", "mp3", "pdf");
    $strToArray = explode(".", $imagename);
    $ext = end($strToArray);
    $ext = strtolower($ext);

    if (!empty($imagename) && !in_array($ext, $allowExt)) {
        return "EXT";
    }
    if ($imagesize > 2 * MB) {
        return "size";
    }
    if (empty($msgError)) {
        move_uploaded_file($imagetmp, "../upload/" . $imagename);
        return $imagename;
    }
    return "fail";
}

function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" || $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
}

function printFailure($message = "unknown ")
{
    echo json_encode(array("status" => "failure"));
}
function printSuccess($message = "unknown ")
{
    echo json_encode(array("status" => "success"));
}
function result($count)
{
    if ($count > 0) {
        printSuccess();
    } else {
        printFailure();
    }
}