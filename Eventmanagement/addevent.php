<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="../images/csi-logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->
  <link href="https://fonts.googleapis.com/css?family=Oswald|Raleway&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
  <link rel="stylesheet" href="../css/membership.css?v=<?php echo time(); ?>">
  <title> Add Event</title>
  <?php
  require_once "../config.php";
  session_start();
  $access = 0;
  if (isset($_SESSION["role_id"])) {
    $role_id = $_SESSION["role_id"];
    $access = getSpecificValue("SELECT * FROM `csi_role` WHERE `csi_role`.`id`=$role_id", 'add_event');
  }
  if ($access == 0) {
    header("location:../index.php");
  }
  if (false) {
    // if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['title'])) {
    if ($access == 1) {
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
      if ($image['error'] == NULL) {
        $file_new_banner = $image['file_new_name'];
        execute("INSERT INTO `csi_event`(`title` , `subtitle`,    `banner`       ,`e_from_date`,`e_to_date` , `e_from_time`,`e_to_time`, `e_description`  , `fee_m` , `fee`,`live`,`selfie`)
                                            VALUES ('$title','$subtitle',' $file_new_banner',' $from_date','  $to_date','$from_time'  ,'$to_time' , '$e_descripition', '$fee_m','$fee','1' ,'$selfie'  )");
      } else {
        function_alert($image['error']);
      }

      $last_entry = mysqli_insert_id($conn);

      // coordinators insert
      $index = 1;
      while (isset($_POST['phone' . $index . 'number']) && isset($_POST['phone' . $index . 'name'])) {
        $phonenmber = $_POST['phone' . $index . 'number'];
        $name = $_POST['phone' . $index . 'name'];
        $type = $_POST['type' . $index];
        execute("INSERT INTO `csi_contact`( `c_name`, `c_phonenumber`, `event_id`,`c_type`) VALUES ('$name','$phonenmber','$last_entry','$type')");
        $index++;
      }


      // venue insert
      $index = 1;
      while (isset($_POST['venue' . $index])) {
        $venue = $_POST['venue' . $index];
        execute("INSERT INTO `csi_venue`(`event_id`, `location`) VALUES ('$last_entry','$venue')");
        $index++;
      }



      // speakers insert
      $index = 1;

      while (isset($_POST['s_name' . $index])) {
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
          execute("INSERT INTO `csi_speaker`(`event_id`   , `name`  , `organisation`  , `profession`, `description`     , `photo`  , `linkedIn`  , `facebook`  , `instagram`  )
                                                    VALUES('$last_entry','$s_name','$s_organisation','$s_profession','$s_descripition','$file_new_speaker','$s_linkedIn','$s_facebook','$s_instagram');");
        } else {
          function_alert($image['error']);
        }
        $index++;
      }


      // collaboration insert
      $index = 1;
      while (isset($_POST['collaboration' . $index])) {
        $collaboration = $_POST['collaboration' . $index];
        $stmt = execute("INSERT INTO `csi_collaboration`(`event_id`, `collab_body`) VALUES ('$last_entry','$collaboration')");
        $index++;
      }

      // Budget insert
      $stmt = execute("INSERT INTO `csi_budget`(`event_id`, `collection`, `expense`, `balance`) VALUES ('$last_entry','0','0','0')");
      redirect_after_msg("Your entry is made.", '../index.php');
    }
  }
  ?>
</head>

<body>
  <header>
    <h6>
      MAHAVIR EDUCATION TRUST'S<br>
      SHAH AND ANCHOR KUTCHHI ENGINEERING COLLEGE<br>
      COMPUTER SOCIETY OF INDIA
    </h6>
    <h4>CSI-SAKEC</h4>
  </header>
  <nav class="navbar navbar-expand-lg navbar-dark default-color sticky-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="eventmanagement.php"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../index.php"><i class="fas fa-home"></i> Home</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <h4>Add a new Event</h4>
    <p>Fill all the fields carefully</p>
    <hr>
    <!-- <form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data"> -->
    <form method="POST" action="" enctype="multipart/form-data" id="addForm">
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label for="rnumber">Event Title :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="texts">
            <input type="text" id="title" name="title" placeholder="Title" required>
          </div>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label for="rnumber">Event Subtitle :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="texts">
            <input type="text" id="subtitle" name="subtitle" placeholder="Subtitle" required>
          </div>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label for="banner-img">Banner Image :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <input type="file" id="img" name="e_banner" required>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label> Date :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="texts">
            <label for="fromdate">From: </label>
            <br>
            <input type="date" id="fromdate" name="fromdate" required>
            <div class="spacer" style="height:10px;"></div>
            <label for="todate">To:</label>
            <br>
            <input type="date" id="todate" name="todate" required>
          </div>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label> Time :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="texts">
            <label for="fromtime">From: </label>
            <br>
            <input type="time" id="fromtime" name="fromtime" required>
            <div class="spacer" style="height:10px;"></div>
            <label for="totime">To: </label>
            <br>
            <input type="time" id="totime" name="totime" required>
          </div>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label for="rnumber"> Event Description :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="texts">
            <textarea data-toggle="tooltip" data-placement="bottom" title="Enter the Event Descripition" type="text-area" placeholder="Event Description" class="form-control" rows="4" columns="3" name="e_descripition" required></textarea>
          </div>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label for="rnumber">Fees for Members :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="texts">
            <label for="appt">&#8377;</label>
            <input type="text" name="fee_m" placeholder="Fees for Member" required>
          </div>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label for="rnumber">Fees for Non-members :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="texts">
            <label for="appt">&#8377;</label>
            <input type="text" name="fee" placeholder="Fees for Non-members" required>
          </div>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>

      <div class="form-group-collab"></div>
      <button type="button" class="btn btn-success btn-sm btn-add-collaborator"><span class="glyphicon glyphicon-plus"></span> Add Collaboration With </button>
      <div class="spacer" style="height:20px;"></div>

      <div class="form-group"></div>
      <button type="button" class="btn btn-success btn-sm btn-add-phone"><span class="glyphicon glyphicon-plus"></span> Add coordinator</button>
      <div class="spacer" style="height:20px;"></div>

      <div class="form-group-venue"></div>
      <button type="button" class="btn btn-success btn-sm btn-add-venue"><span class="glyphicon glyphicon-plus"></span> Add Venue</button>
      <div class="spacer" style="height:20px;"></div>

      <div class="form-group-speaker"></div>
      <button type="button" class="btn btn-success btn-sm btn-add-speaker"><span class="glyphicon glyphicon-plus"></span> Add Speaker</button>
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label for="rnumber">Mandidate Selfie in Feedback :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="texts">
            <input type="radio" name="selfie" value="1" required="required">
            <label for="rnumber">yes</label> <br>
            <input type="radio" name="selfie" value="0">
            <label for="rnumber">no</label>
          </div>
        </div>
      </div>
  </div>
  <div class="spacer" style="height:20px;"></div>
  <button type="submit" class="btn btn-primary">Sumbit</button>
  <div class="spacer" style="height:40px;"></div>
  </form>
  <div class="spacer" style="height:40px;"></div>
  <div class="footer">
    <div class="spacer" style="height:2px;"></div>
    <a href="index.php"><i class="fas fa-home"></i></a>
    <div class="spacer" style="height:0px;"></div>
    <h5>Copyright &copy; CSI-SAKEC 2020-21 All Rights Reserved</h5>
    <div class="spacer" style="height:1px;"></div>
  </div>
  <script>
    var list_of_speakers = [];
    var list_of_collaborators = [];
    var list_of_coordinator = [];
    var list_of_venues = [];
    for (let i = 1; i <= $('.speaker-input').length; i++) {
      list_of_speakers.push(i);
    }
    for (let i = 1; i <= $('.collab-input').length; i++) {
      list_of_collaborators.push(i);
    }
    for (let i = 1; i <= $('.deletephone').length; i++) {
      list_of_coordinator.push(i);
    }
    for (let i = 1; i <= $('.venue-input').length; i++) {
      list_of_venues.push(i);
    }
    $("#addForm").on("submit", function(e) {
      e.preventDefault()
      var formData = new FormData(this);
      console.log(list_of_venues);
      list_of_speakers.forEach(speaker => {
        formData.append('list_of_speakers[]', speaker);

      });
      list_of_collaborators.forEach(collaborator => {
        formData.append('list_of_collaborators[]', collaborator);

      });
      console.log(list_of_coordinator);
      list_of_coordinator.forEach(coordinator => {
        formData.append('list_of_coordinator[]', coordinator);

      });
      list_of_venues.forEach(venue => {
        formData.append('list_of_venues[]', venue);

      });
      console.log(formData.getAll('list_of_venues'));
      // console.log(formData);
      $.ajax({
        url: '<?php echo $protocol . $domainName; ?>/api/addEventDetails.php',
        type: 'POST',
        data: formData,
        dataType: 'JSON',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
          // var error = response.error;
          console.log(response);
          // if (!error) {
          //     console.log(error);
          //     $("#" + id).hide(1000);
          // } else {
          //     console.log(error);
          // }
        },
        error: function(response) {
          console.log(response);
          // console.log(xhr, resp, text);
        }
      });
      alert("Submitted")
    })


    // Event Coordinator Section
    $(function() {
      $(document.body).on('click', '.changeType', function() {
        $(this).closest('.phone-input').find('.type-text').text($(this).text());
        $(this).closest('.phone-input').find('.type-input').val($(this).data('type-value'));
      });

      $(document.body).on('click', '.btn-remove-phone', function() {
        list_of_coordinator = list_of_coordinator.filter(x => x != $(this).val());
        $(this).closest('.deletephone').remove();
      });
      $('.btn-add-phone').click(function() {

        var index = $('.phone-input').length + 1;
        list_of_coordinator.push(index);
        $('.form-group').append('' +
          '<div class="deletephone">' +
          ' <div class="col-sm-5">' +
          '<div class="labels">' +
          '<label for="type">Coordinator Type :</label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="texts">' +
          '<select id="type" name="type' + index + '" required="required" class="custom-select mb-3">' +
          '<option value="0"selected>Student</option>' +
          '<option value="1">Staff</option>' +
          '</select>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label class=" control-label">Contact Name :</label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="text">' +
          '<input type="text" name="phone' + index + 'name" class="form-control">' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label class=" control-label">Phone Number :</label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="input-group phone-input">' +
          '<div class="text">' +
          '<input type="number" name="phone' + index + 'number" class="form-control" placeholder="999 999 9999" />' +
          '</div>' +
          '<span class="input-group-btn">' +
          '<button class="btn btn-danger btn-remove-phone" type="button"><span class="glyphicon glyphicon-remove"></span></button>' +
          '</span>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
      });
    });

    // Event Venue Section
    $(function() {
      $(document.body).on('click', '.changeType', function() {
        $(this).closest('.venue-input').find('.type-text').text($(this).text());
        $(this).closest('.venue-input').find('.type-input').val($(this).data('type-value'));
      });

      $(document.body).on('click', '.btn-remove-venue', function() {
        list_of_venues = list_of_venues.filter(x => x != $(this).val());
        $(this).closest('.deletevenue').remove();
      });
      $('.btn-add-venue').click(function() {

        var index = $('.venue-input').length + 1;
        list_of_venues.push(index);
        $('.form-group-venue').append('' +
          '<div class="deletevenue">' +
          '<div class="venue-input">' +
          '<div id = row>' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label for="venue' + index + '">Venue :</label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="input-group phone-input">' +
          '<div class="texts">' +
          '<input type="text" id="venue" name="venue' + index + '" placeholder="Venue" required>' +
          '</div>' +
          '<span class="input-group-btn">' +
          '<button class="btn btn-danger btn-remove-venue" type="button"><span class="glyphicon glyphicon-remove"></span></button>' +
          '</span>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
      });
    });

    // Event Collaboration with Section
    $(function() {
      $(document.body).on('click', '.changeType', function() {
        $(this).closest('.collab-input').find('.type-text').text($(this).text());
        $(this).closest('.collab-input').find('.type-input').val($(this).data('type-value'));
      });

      $(document.body).on('click', '.btn-remove-collaborator', function() {
        list_of_collaborators = list_of_collaborators.filter(x => x != $(this).val());
        $(this).closest('.deletecollaborator').remove();
      });
      $('.btn-add-collaborator').click(function() {

        var index = $('.collab-input').length + 1;
        list_of_collaborators.push(index);
        $('.form-group-collab').append('' +
          '<div class="deletecollaborator">' +
          '<div class="collab-input">' +
          '<div id = row>' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label for="collaboration' + index + '">Collaboration :</label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="input-group phone-input">' +
          '<div class="texts">' +
          '<input type="text" id="collaboration" name="collaboration' + index + '" placeholder="Collaboration" required>' +
          '</div>' +
          '<span class="input-group-btn"><button class="btn btn-danger btn-remove-collaborator" type="button"><span class="glyphicon glyphicon-remove"></span></button></span>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '<div id = "collaboration' + index + '"></div></div>'
        );
      });
    });

    //  Event Speaker Section
    $(function() {
      $(document.body).on('click', '.changeType', function() {
        $(this).closest('.speaker-input').find('.type-text').text($(this).text());
        $(this).closest('.speaker-input').find('.type-input').val($(this).data('type-value'));
      });

      $(document.body).on('click', '.btn-remove-speaker', function() {
        list_of_speakers = list_of_speakers.filter(x => x != $(this).val());
        $(this).closest('.deletespeaker').remove();
      });
      $('.btn-add-speaker').click(function() {

        var index = $('.speaker-input').length + 1;
        list_of_speakers.push(index);

        $('.form-group-speaker').append('' +
          '<div class="deletespeaker">' +
          '<div class="speaker-input">' +
          '<span class="input-group-btn">' +
          '<button class="btn btn-danger btn-remove-speaker" type="button"><span class="glyphicon glyphicon-remove"></span></button>' +
          '</span>' +
          '<div class="row">' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label for="s_name' + index + '"> Speaker Name : </label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="texts">' +
          '<input type="text" name="s_name' + index + '" placeholder="Speaker Name" required>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '<div class="spacer" style="height:20px;"></div>' +
          '<div class="row">' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label for="s_organisation' + index + '"> Speaker Organisation: </label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="texts">' +
          '<input type="text" name="s_organisation' + index + '" placeholder="Speaker Organisation" required>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '<div class="spacer" style="height:20px;"></div>' +
          '<div class="row">' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label for="s_profession' + index + '"> Speaker Profession: </label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="texts">' +
          ' <input type="text" name="s_profession' + index + '" placeholder="Speaker Profession" required>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '<div class="spacer" style="height:20px;"></div>' +
          '<div class="row">' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label for="s_photo' + index + '"> Speaker Image :</label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          ' <input type="file" id="img" name="s_photo' + index + '" required>' +
          ' </div>' +
          '</div>' +
          '<div class="spacer" style="height:20px;"></div>' +
          '<div class="row">' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label> Speakers Description :</label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="texts">' +
          '<textarea data-toggle="tooltip" data-placement="bottom" title="Enter the Speaker Descripition" type="text-area" placeholder="Speakers Description" class="form-control" rows="4" columns="3" name="s_descripition' + index + '" required></textarea>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '<div class="spacer" style="height:20px;"></div>' +
          '<div class="row">' +
          '<div class="col-sm-5">' +
          '<div class="labels">' +
          '<label for="s_linkedIn' + index + '"> Speaker LinkedIn: </label>' +
          '</div>' +
          '</div>' +
          '<div class="col-sm-7">' +
          '<div class="texts">' +
          '<input type="text" name="s_linkedIn' + index + '" placeholder="LinkedIn">' +
          '</div>' +
          '</div>' +
          '</div>' +
          '<div class="spacer" style="height:20px;"></div>' +
          '</div>' +
          '</div>'
        );
      });
    });
  </script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</body>

</html>