<?php
require_once "../config.php";
$data = Null;
$status = 'error';
$message = '';
$result = '';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['title'])) {
  $title = $_POST['title'];
  $subtitle = $_POST['subtitle'];
  $from_date = date("Y-m-d", strtotime($_POST['fromdate']));
  $to_date = date("Y-m-d", strtotime($_POST['todate']));
  $from_time = date("H:i:sa", strtotime($_POST['fromtime']));
  $to_time = date("H:i:sa", strtotime($_POST['totime']));
  $e_descripition = $_POST['e_descripition'];
  $fee_m = $_POST['fee_m'];
  $fee = $_POST['fee'];
  $selfie = $_POST['selfie'];
  $image = fileTransfer('e_banner', '../Banner');
  $list_of_speaker = $_POST['list_of_speakers'];
  $list_of_collaborators = $_POST['list_of_collaborators'];
  $list_of_coordinator = $_POST['list_of_coordinator'];
  $list_of_venues = $_POST['list_of_venues'];
  if ($image['error'] == NULL) {
    $file_new_banner = $image['file_new_name'];
    execute("INSERT INTO `csi_event`(`title`,`subtitle`,`banner`,`e_from_date`,`e_to_date`,`e_from_time`,`e_to_time`,`e_description`,`fee_m`,`fee`,`live`,`selfie`) VALUES ('$title','$subtitle',' $file_new_banner',' $from_date','  $to_date','$from_time'  ,'$to_time' , '$e_descripition', '$fee_m','$fee','1' ,'$selfie'  )");
  } else {
    function_alert($image['error']);
  }
  $last_entry = mysqli_insert_id($conn);
  // coordinators insert
  if(count($list_of_coordinator) > 0){
    foreach ($list_of_coordinator as $key => $index) {
      if (isset($_POST['phone' . $index . 'number']) && isset($_POST['phone' . $index . 'name'])) {
        $phonenmber = $_POST['phone' . $index . 'number'];
        $name = $_POST['phone' . $index . 'name'];
        $type = $_POST['type' . $index];
        execute("INSERT INTO `csi_contact`( `c_name`, `c_phonenumber`, `event_id`,`c_type`) VALUES ('$name','$phonenmber','$last_entry','$type')");
      }
    }
  }
  // venue insert
  if(count($list_of_venues) > 0){
    foreach ($list_of_venues as $key => $index) {
      if (isset($_POST['venue' . $index])) {
        $venue = $_POST['venue' . $index];
        execute("INSERT INTO `csi_venue`(`event_id`, `location`) VALUES ('$last_entry','$venue')");
      }
    }
  }
  // speakers insert
  if(count($list_of_speaker) > 0){
    foreach ($list_of_speaker as $key => $index) {
      if (isset($_POST['s_name' . $index])) {
        $s_name = $_POST['s_name' . $index];
        $s_profession = $_POST['s_profession' . $index];
        $s_organisation = $_POST['s_organisation' . $index];
        $s_descripition = $_POST['s_descripition' . $index];
        $s_linkedIn = $_POST['s_linkedIn' . $index];
        // $s_facebook = $_POST['s_facebook' . $index];
        // $s_instagram = $_POST['s_instagram' . $index];
        $s_facebook = " ";
        $s_instagram = " ";
        $image = fileTransfer('s_photo' . $index, '../Speaker_Image');
        if ($image['error'] == NULL) {
          $file_new_speaker = $image['file_new_name'];
          $result = execute("INSERT INTO `csi_speaker`(`event_id`   , `name`  , `organisation`  , `profession`, `description`     , `photo`  , `linkedIn`  )VALUES('$last_entry','$s_name','$s_organisation','$s_profession','$s_descripition','$file_new_speaker','$s_linkedIn');");
          $message = $result;
        } else {
          function_alert($image['error']);
        }
      }
    }
  }
  // collaboration insert
  if(count($list_of_collaborators) > 0){
    foreach ($list_of_collaborators as $key => $index) {
      if (isset($_POST['collaboration' . $index])) {
        $collaboration = $_POST['collaboration' . $index];
        $stmt = execute("INSERT INTO `csi_collaboration`(`event_id`, `collab_body`) VALUES ('$last_entry','$collaboration')");
      }
    }
  }
  // Budget insert
  $stmt = execute("INSERT INTO `csi_budget`(`event_id`, `collection`, `expense`, `balance`) VALUES ('$last_entry','0','0','0')");
  redirect_after_msg("Your entry is made.", '../index.php');
  // $message = "Done";
  $error = false;
  $status = 200;
} else {
  $error = true;
}

$resposnse = array(
  "status" => $status,
  "message" => $message,
  "data" => $data,
);
echo json_encode($resposnse);
