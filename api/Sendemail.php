<?php
session_start();
require_once "functionMail.php";
require_once "../config.php";
$data = Null;
$status = 'error';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == "POST" && ($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "shahandanchor.com")) {
    if (isset($_POST['to_address']) && isset($_POST['reply_to_address']) && isset($_POST['bcc_address']) && isset($_POST['subject']) && isset($_POST['body']) && isset($_POST['alt_body'])) {
        $to_address = $_POST['to_address'];
        $reply_to_address = $_POST['reply_to_address'];
        $bcc_address = $_POST['bcc_address'];
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $alt_body = $_POST['alt_body'];
        $message = sendEmail($to_address, $reply_to_address, $bcc_address, $subject, $body, $alt_body);
        $status = 'success';
    } else {
        $message = 'Error gbvcbnvbnbvn';
    }
}
$response = array(
    "status" => $status,
    "message" => $message,
    "data" => $data,
);
echo json_encode($response);
