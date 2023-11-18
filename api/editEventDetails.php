<?php
require_once "../config.php";
$data = Null;
$status = 'error';
$message = '';
$result = '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  // Inputes
  $event_id = $_POST['event_id'];
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
  $list_of_speaker = $_POST['list_of_speakers'];
  $list_of_collaborators = $_POST['list_of_collaborators'];
  $list_of_coordinator = $_POST['list_of_coordinator'];
  $list_of_venues = $_POST['list_of_venues'];
  // $image = fileTransfer('e_banner','../Banner');
  // $result = $image;
  $message = $to_time;
  $result = execute(
    "UPDATE `csi_event`
            SET 
            `title`='$title',
            `subtitle`='$subtitle',
            `e_from_date`='$from_date',
            `e_to_date`='$to_date',
            `e_from_time`='$from_time',
            `e_to_time`='$to_time',
            `e_description`='$e_descripition',
            `fee_m`='$fee_m',
            `fee`='$fee',
            `selfie`='$selfie'
            WHERE `id`='$event_id'"
  );
  $message = $result;
  if (isset($_FILES["e_banner"])) {
    $prevBanner = getSpecificValue("SELECT `banner` FROM `csi_event` WHERE `id` = '$event_id';", 'banner');
    $image = fileTransfer('e_banner', '../Banner');
    if ($image['error'] == NULL) {
      $file_new_banner = $image['file_new_name'];
      execute("UPDATE `csi_event` SET `banner`='$file_new_banner' WHERE `id`='$event_id'");

      deleteFile('../Banner', $prevBanner);
    }
  }

  // coordinators insert
  $index = 1;
  execute("DELETE FROM `csi_contact` WHERE `event_id`='$event_id'");
  foreach ($list_of_coordinator as $key => $index) {
    $phonenmber = $_POST['phone' . $index . 'number'];
    $name = $_POST['phone' . $index . 'name'];
    $type = $_POST['type' . $index];
    execute("INSERT INTO `csi_contact`( `c_name`, `c_phonenumber`, `event_id`,`c_type`) VALUES ('$name','$phonenmber','$event_id','$type')");
    $index++;
  }


  // venue insert
  $index = 1;
  execute("DELETE FROM `csi_venue` WHERE `event_id`='$event_id'");
  foreach ($list_of_venues as $key => $index) {
    $venue = $_POST['venue' . $index];
    execute("INSERT INTO `csi_venue`(`event_id`, `location`) VALUES ('$event_id','$venue')");
    $index++;
  }



  // speakers insert
  $index = 1;
  $photoName = getAllValues("SELECT `photo` FROM `csi_speaker` WHERE `event_id`='$event_id'");
  // $result = $photoName[0];
  // if ($photoName[0] != NULL) {
  $phNames = [];
  //     foreach ($photoName as $photo) {
  //         array_push($phNames, $photo["photo"]);
  //         // deleteFile('../Speaker_Image', $photo["photo"]);
  //     }
  // }
  execute("DELETE FROM `csi_speaker` WHERE `event_id`='$event_id'");
  foreach ($list_of_speaker as $key => $index) {
    $s_name = $_POST['s_name' . $index];
    $s_profession = $_POST['s_profession' . $index];
    $s_organisation = $_POST['s_organisation' . $index];
    $s_descripition = $_POST['s_descripition' . $index];
    $s_linkedIn = $_POST['s_linkedIn' . $index];
    if ($_FILES['s_photo' . $index]['name'] != "") {
      $image = fileTransfer('s_photo' . $index, '../Speaker_Image');
      // $result = $image;
      if ($image['error'] == NULL) {
        $file_new_speaker = $image['file_new_name'];
        execute("INSERT INTO `csi_speaker`(`event_id`   , `name`  , `organisation`  , `profession`, `description`     , `photo`  , `linkedIn`)
                                        VALUES('$event_id','$s_name','$s_organisation','$s_profession','$s_descripition','$file_new_speaker','$s_linkedIn');");
        if ($photoName[0] != NULL && count($photoName) > $index) {
          deleteFile('../Speaker_Image', $photoName[$index]["photo"]);
        }
      } else {
        $currPhoto = $photoName[$index - 1]['photo'];
        array_push($phNames, $currPhoto);
        function_alert($image['error']);
        execute("INSERT INTO `csi_speaker`(`event_id`   , `name`  , `organisation`  , `profession`, `description`     , `photo`  , `linkedIn`)
                                        VALUES('$event_id','$s_name','$s_organisation','$s_profession','$s_descripition','$currPhoto','$s_linkedIn');");
      }
    } else {
      $currPhoto = $photoName[$index - 1]['photo'];
      array_push($phNames, $currPhoto);
      function_alert($image['error']);
      execute("INSERT INTO `csi_speaker`(`event_id`   , `name`  , `organisation`  , `profession`, `description`     , `photo`  , `linkedIn`)VALUES('$event_id','$s_name','$s_organisation','$s_profession','$s_descripition','$currPhoto','$s_linkedIn');");
    }
  }

  foreach ($photoName as $photo) {
    $flag = 0;
    foreach ($phNames as $pName) {
      if ($pName == $photo['photo'])
        $flag = 1;
    }
    if ($flag == 0)
      deleteFile('../Speaker_Image', $photo["photo"]);
  }



  // collaboration insert
  execute("DELETE FROM `csi_collaboration` WHERE `event_id`='$event_id'");
  $index = 1;
  foreach ($list_of_collaborators as $key => $index) {
    $collaboration = $_POST['collaboration' . $index];
    $stmt = execute("INSERT INTO `csi_collaboration`(`event_id`, `collab_body`) VALUES ('$event_id','$collaboration')");
    $index++;
  }




  // for ($i=0; $i < ; $i++) { 

  // }

  $data = $result;
  $data = $photoName;
  $status = 'success';
} else {
  $error = true;
}
$resposnse = array(
  "status" => $status,
  "message" => $message,
  "data" => $data,
);
echo json_encode($resposnse);
