<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connect.php';



$email = filterRequest("email") ?? '';
$city = filterRequest(("city"))?? '';
$street = filterRequest("street") ?? '';
$addressPhone = filterRequest(("phone"))?? '';
$addressDesc = filterRequest(("description"))?? '';

$data = array(
    "address_useremail" => $email ,
    "address_city" => $city ,
    "address_street" => $street ,
    "address_contactNumber" =>  $addressPhone ,
    "address_desc" => $addressDesc ,
);

insertData2("address" , $data ,$json = false);


$stmt = $con->prepare("SELECT MAX(address_id) from address WHERE address_useremail = ? ");
$stmt->execute(array($email));
$maxID = $stmt->fetchColumn();

echo json_encode(array("address_id" => $maxID));





function insertData2($table, $data , $json )
{
    global $con;
 
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
        if($json){
            if($count > 0){
                    echo json_encode(array("status" => "success"));
            }else{
                    echo json_encode(array("status" => "failure"));
            }
        }
   
}
