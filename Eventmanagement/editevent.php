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
  <title> Edit Event</title>
  <?php
  require_once "../config.php";
  session_start();
  $access = 0;
  if (isset($_SESSION["role_id"])) {
    $role_id = $_SESSION["role_id"];
    $access = getSpecificValue("SELECT * FROM `csi_role` WHERE `csi_role`.`id`=$role_id", 'add_event');
  }
  $eventId = $_GET['event_id'];
  $eventDetails = getValue("SELECT * FROM csi_event WHERE id='$eventId'");
  $eventSpeakerDetails = execute("SELECT * FROM csi_speaker WHERE event_id='$eventId'");
  $numberOfSpeakers = mysqli_num_rows($eventSpeakerDetails);
  $arrayEventCollaboration = getAllValues("SELECT `collab_body` FROM `csi_collaboration` WHERE event_id='$eventId'");
  $eventCollaboration = implode(', ', array_column($arrayEventCollaboration, 'collab_body'));
  if ($access == 0) {
    header("location:../index.php");
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
    <form method="POST" action="" enctype="multipart/form-data" id="editForm">
      <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
      <div class="spacer" style="height:20px;"></div>
      <div class="row">
        <div class="col-sm-5">
          <div class="labels">
            <label for="rnumber">Event Title :</label>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="texts">
            <input type="text" id="title" name="title" placeholder="Title" value="<?php echo $eventDetails['title'] ?>" required>
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
            <input type="text" id="subtitle" name="subtitle" placeholder="Subtitle" value="<?php echo $eventDetails['subtitle'] ?>" required>
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
          <input type="file" id="img" name="e_banner">
          <div class="spacer" style="height:20px;"></div>
          <img src="../Banner/<?php echo $eventDetails['banner'] ?>" alt="Img" height="200">
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
            <input type="date" id="fromdate" name="fromdate" value="<?php echo $eventDetails['e_from_date'] ?>" required>
            <div class="spacer" style="height:10px;"></div>
            <label for="todate">To:</label>
            <br>
            <input type="date" id="todate" name="todate" value="<?php echo $eventDetails['e_to_date'] ?>" required>
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
            <input type="time" id="fromtime" name="fromtime" value="<?php echo $eventDetails['e_from_time'] ?>" required>
            <div class="spacer" style="height:10px;"></div>
            <label for="totime">To: </label>
            <br>
            <input type="time" id="totime" name="totime" value="<?php echo $eventDetails['e_to_time'] ?>" required>
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
            <textarea data-toggle="tooltip" data-placement="bottom" title="Enter the Event Descripition" type="text-area" placeholder="Event Description" class="form-control" rows="4" columns="3" name="e_descripition" required><?php echo $eventDetails['e_description'] ?></textarea>
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
            <input type="text" name="fee_m" placeholder="Fees for Member" value="<?php echo $eventDetails['fee_m'] ?>" required>
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
            <input type="text" name="fee" placeholder="Fees for Non-members" value="<?php echo $eventDetails['fee'] ?>" required>
          </div>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>
      <div class="form-group-collab">
        <?php
        $index = 0;
        foreach ($arrayEventCollaboration as $collabBody) {
          $index++;
        ?>
          <div class="deletecollaborator">
            <div class="collab-input">
              <div id="row">
                <div class="col-sm-5">
                  <div class="labels">
                    <label for="collaboration<?php echo $index ?>">Collaboration :</label>
                  </div>
                </div>
                <div class="col-sm-7">
                  <div class="input-group phone-input">
                    <div class="texts">
                      <input type="text" id="collaboration" name="collaboration<?php echo $index ?>" placeholder="Collaboration" required="" value="<?php echo $collabBody['collab_body'] ?>">
                    </div>
                    <span class="input-group-btn">
                      <button class="btn btn-danger btn-remove-collaborator" type="button" value='<?php echo $index ?>'>
                        <span class="glyphicon glyphicon-remove">
                        </span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>
              <div id="collaboration<?php echo $index ?>"></div>
            </div>
          </div>
        <?php } ?>
      </div>
      <button type="button" class="btn btn-success btn-sm btn-add-collaborator" value='<?php echo $index ?>'><span class="glyphicon glyphicon-plus"></span> Add Collaboration With </button>
      <div class="spacer" style="height:20px;"></div>
      <div class="form-group">
        <?php
        // Event coordinators details
        $index = 0;
        $query_contact = execute("SELECT `c_type`, `c_name`,`c_phonenumber` FROM `csi_contact` WHERE `event_id`='$eventId'");
        while ($row2 = mysqli_fetch_assoc($query_contact)) {
          $index++;
        ?>
          <div class="deletephone">
            <div class="col-sm-5">
              <div class="labels"><label for="type">Coordinator Type :</label></div>
            </div>
            <div class="col-sm-7">
              <div class="texts">
                <select id="type" name="type<?php echo $index ?>" required="required" class="custom-select mb-3">
                  <?php
                  if ($row2['c_type'] == 0) {
                  ?>
                    <option value="0" selected="">Student</option>
                    <option value="1">Staff</option>
                  <?php
                  } else {
                  ?>
                    <option value="0">Student</option>
                    <option value="1" selected>Staff</option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="labels"><label class=" control-label">Contact Name :</label></div>
            </div>
            <div class="col-sm-7">
              <div class="text"><input type="text" name="phone<?php echo $index ?>name" class="form-control" value="<?php echo $row2['c_name'] ?>"></div>
            </div>
            <div class="col-sm-5">
              <div class="labels"><label class=" control-label">Phone Number :</label></div>
            </div>
            <div class="col-sm-7">
              <div class="input-group phone-input">
                <div class="text"><input type="number" name="phone<?php echo $index ?>number" class="form-control" placeholder="999 999 9999" value="<?php echo $row2['c_phonenumber'] ?>"></div><span class="input-group-btn"><button class="btn btn-danger btn-remove-phone" type="button" value='<?php echo $index ?>'><span class="glyphicon glyphicon-remove"></span></button></span>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
      <button type="button" class="btn btn-success btn-sm btn-add-phone">
        <span class="glyphicon glyphicon-plus"></span> Add coordinator
      </button>
      <div class="spacer" style="height:20px;"></div>
      <div class="form-group-venue">
        <?php
        // Event coordinators details
        $index = 0;
        $query_veneu = execute("SELECT `location` FROM `csi_venue` WHERE `event_id`='$eventId'");
        while ($row2 = mysqli_fetch_assoc($query_veneu)) {
          $index++;
        ?>
          <div class="deletevenue">
            <div class="venue-input">
              <div id="row">
                <div class="col-sm-5">
                  <div class="labels"><label for="venue<?php echo $index ?>">Venue :</label></div>
                </div>
                <div class="col-sm-7">
                  <div class="input-group phone-input">
                    <div class="texts"><input type="text" id="venue" name="venue<?php echo $index ?>" placeholder="Venue" required="" value="<?php echo $row2['location'] ?>"></div><span class="input-group-btn"><button class="btn btn-danger btn-remove-venue" type="button" value='<?php echo $index ?>'><span class="glyphicon glyphicon-remove"></span></button></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
      <button type="button" class="btn btn-success btn-sm btn-add-venue"><span class="glyphicon glyphicon-plus"></span> Add Venue</button>
      <div class="spacer" style="height:20px;"></div>
      <div class="form-group-speaker">
        <?php
        // Event coordinators details
        $index = 0;
        $query_speaker = execute("SELECT * FROM `csi_speaker` WHERE `event_id`='$eventId'");
        while ($row2 = mysqli_fetch_assoc($query_speaker)) {
          $index++;
        ?>
          <div class="deletespeaker">
            <div class="speaker-input"><span class="input-group-btn"><button class="btn btn-danger btn-remove-speaker" type="button" value='<?php echo $index ?>'><span class="glyphicon glyphicon-remove"></span></button></span>
              <div class="row">
                <div class="col-sm-5">
                  <div class="labels"><label for="s_name<?php echo $index ?>"> Speaker Name : </label></div>
                </div>
                <div class="col-sm-7">
                  <div class="texts"><input type="text" name="s_name<?php echo $index ?>" placeholder="Speaker Name" required="" value="<?php echo $row2['name'] ?>"></div>
                </div>
              </div>
              <div class="spacer" style="height:20px;"></div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="labels"><label for="s_organisation<?php echo $index ?>"> Speaker Organisation: </label></div>
                </div>
                <div class="col-sm-7">
                  <div class="texts"><input type="text" name="s_organisation<?php echo $index ?>" placeholder="Speaker Organisation" required="" value="<?php echo $row2['organisation'] ?>"></div>
                </div>
              </div>
              <div class="spacer" style="height:20px;"></div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="labels"><label for="s_profession<?php echo $index ?>"> Speaker Profession: </label></div>
                </div>
                <div class="col-sm-7">
                  <div class="texts"> <input type="text" name="s_profession<?php echo $index ?>" placeholder="Speaker Profession" required="" value="<?php echo $row2['profession'] ?>"></div>
                </div>
              </div>
              <div class="spacer" style="height:20px;"></div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="labels"><label for="s_photo<?php echo $index ?>"> Speaker Image :</label></div>
                </div>
                <div class="col-sm-7"> <input type="file" id="img" name="s_photo<?php echo $index ?>">
                  <div class="spacer" style="height:20px;"></div>
                  <img src="../Speaker_Image/<?php echo $row2['photo'] ?>" alt="Img" height="200">
                </div>
              </div>
              <div class="spacer" style="height:20px;"></div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="labels"><label> Speakers Description :</label></div>
                </div>
                <div class="col-sm-7">
                  <div class="texts"><textarea data-toggle="tooltip" data-placement="bottom" title="Enter the Speaker Descripition" type="text-area" placeholder="Speakers Description" class="form-control" rows="4" columns="3" name="s_descripition<?php echo $index ?>" required=""><?php echo $row2['description'] ?></textarea></div>
                </div>
              </div>
              <div class="spacer" style="height:20px;"></div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="labels"><label for="s_linkedIn<?php echo $index ?>"> Speaker LinkedIn: </label></div>
                </div>
                <div class="col-sm-7">
                  <div class="texts"><input type="text" name="s_linkedIn<?php echo $index ?>" placeholder="LinkedIn" value="<?php echo $row2['linkedIn'] ?>"></div>
                </div>
              </div>
              <div class="spacer" style="height:20px;"></div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
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
            <?php if ($eventDetails['selfie'] == 1) { ?>
              <input type="radio" name="selfie" value="1" required="required" checked>
              <label for="rnumber">yes</label> <br>
              <input type="radio" name="selfie" value="0">
            <?php } else { ?>
              <input type="radio" name="selfie" value="1" required="required">
              <label for="rnumber">yes</label> <br>
              <input type="radio" name="selfie" value="0" checked>
            <?php } ?>
            <label for="rnumber">no</label>
          </div>
        </div>
      </div>
      <div class="spacer" style="height:20px;"></div>
      <button type="submit" class="btn btn-primary" name="submitEdit">Sumbit</button>
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
    $("#editForm").on("submit", function(e) {
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
        url: '<?php echo $protocol . $domainName; ?>/api/editEventDetails.php',
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
        $(this).closest('.form-group').find('.type-text').text($(this).text());
        $(this).closest('.form-group').find('.type-input').val($(this).data('type-value'));
      });

      $(document.body).on('click', '.btn-remove-phone', function() {
        list_of_coordinator = list_of_coordinator.filter(x => x != $(this).val());
        $(this).closest('.deletephone').remove();
      });
      $('.btn-add-phone').click(function() {
        var index = $('.form-group').length + 1;
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
          '<button class="btn btn-danger btn-remove-phone" type="button" value=' + index + '><span class="glyphicon glyphicon-remove"></span></button>' +
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
          '<button class="btn btn-danger btn-remove-venue" type="button" value=' + index + '><span class="glyphicon glyphicon-remove"></span></button>' +
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
          '<span class="input-group-btn"><button class="btn btn-danger btn-remove-collaborator" type="button" value=' + index + '><span class="glyphicon glyphicon-remove"></span></button></span>' +
          '</div>' +
          '</div>' +
          '</div>' +
          '<div id = "collaboration' + index + '"></div>' +
          '</div>'
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
          '<button class="btn btn-danger btn-remove-speaker" type="button" value= ' + index + '><span class="glyphicon glyphicon-remove"></span></button>' +
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