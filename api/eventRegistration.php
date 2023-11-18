<?php
session_start();
require_once "../config.php";
$data = Null;
$status = 'error';
$message = '';
$result = '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['eventId']) && isset($_POST['enterEmailid']) && isset($_POST['enterAmount']) && isset($_FILES['enterBillPhoto']) && $_POST['eventId']!="" && $_POST['enterEmailid']!="" && $_POST['enterAmount']!=""){
        $eventId = (int)$_POST['eventId'];
        $userEmailId = $_POST['enterEmailid'];
        $amount = $_POST['enterAmount'];
        $user_id = getSpecificValue(
            "SELECT 
                `id`
            FROM 
                `csi_userdata` 
            WHERE 
                `emailID`='$userEmailId'
            ","id");
        $billPhoto = fileTransfer('enterBillPhoto','../Eventmanagement/Event_Bill');
        $confirmed_by = $_SESSION["email"];
        if($billPhoto['error'] == NULL){
            $file_new_banner = $billPhoto['file_new_name'];
            execute(
                "INSERT INTO `csi_collection` (
                    `event_id`,
                    `user_id`,
                    `bill_photo`,
                    `amount`,
                    `confirmed`,
                    `confirmed_by`
                ) 
                VALUES (
                    '$eventId',
                    '$user_id',
                    '$file_new_banner',
                    '$amount',
                    '1',
                    '$confirmed_by'
                )"
            );
            $status = 'success';
        } else {
            $message =$image['error'];
        }
    }else{
        $message = 'Input fields are empty';
    }
}
$response = array(
    "status" => $status,
    "message" => $message,
    "data" => $data,
);
echo json_encode($response);