<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../images/csi-logo.png">
    <link rel="stylesheet" href="../plugins/bootstrap-4.6.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/membership.css?v=<?php echo time(); ?>">
    <title>All Registration</title>
    <?php
    require_once "../config.php";
    session_start();
    $access = 0;
    if (isset($_SESSION["role_id"])) {
        $role_id = $_SESSION["role_id"];
        $access = getSpecificValue("SELECT * FROM `csi_role` WHERE `csi_role`.`id`=$role_id", 'budget');
    }
    if ($access == 0) {
        header("location:../index.php");
    }
    $event_id = $_GET['event_id'];
    $sum = 0;
    $query = getAllValues("SELECT `csi_collection`.`id`,`csi_userdata`.`emailID`, `bill_photo`, `amount`, `confirmed_by` FROM `csi_collection`,`csi_userdata` WHERE `confirmed`='1' AND `csi_userdata`.`id`=`user_id` AND `event_id` = $event_id");
    ?>
</head>

<body>
    <header>
        <h2 style="text-align: center;">All Registration</h2>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark default-color sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333" aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="managementevent.php?event_id=<?php echo $event_id; ?>"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#addRegistration"><i class="fas fa-user-plus"></i> Add Registration</a>
                </li>
            </ul>
        </div>
    </nav>
    <table class="table">
        <thead class="black white-text">
            <tr>
                <th scope="col">User</th>
                <th>Confirmed By</th>
                <th>Bill Photo</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($query) > 0) {
                foreach ($query as $row) {
            ?>
                    <tr>
                        <td><?php echo $row['emailID']; ?></td>
                        <td><?php echo $row['confirmed_by']; ?></td>
                        <td>
                            <?php if (isset($row['bill_photo'])) { ?>
                                <a target="_blank" href="<?php echo "Event_Bill/" . $row['bill_photo']; ?>">
                                    <img src="<?php echo "Event_Bill/" . trim($row['bill_photo']); ?>" alt="Iamge not found, contact web dev" style="width:80px">
                                </a>
                            <?php } else { ?>
                                No Image
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            $sum += $row['amount'];
                            echo $row['amount'];
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total : </td>
                    <td><?php echo $sum; ?></td>
                </tr>
            <?php
            } else {
            ?>
                <tr class='text-center'>
                    <td>No Record Found </td>
                </tr>
            <?php
            }
            ?>
            </div>
        </tbody>
    </table>
    <div class="spacer" style="height:100px;"></div>
    <div class="footer">
        <div class="spacer" style="height:2px;"></div>
        <a href="index.php"><i class="fas fa-home"></i></a>
        <div class="spacer" style="height:2px;"></div>
        <h5>Copyright &copy; CSI-SAKEC 2020-21 All Rights Reserved</h5>
        <div class="spacer" style="height:2px;"></div>
    </div>
    <div class="modal fade" id="addRegistration" tabindex="-1" aria-labelledby="addRegistrationLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form class="needs-validation " id="addRegistrationData" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRegistrationLabel"><i class="fas fa-user-plus"></i> Add Registration</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row mb-3">
                            <div class="col-3">
                                <i class="fas fa-user-tag"></i> Students Email Id :
                            </div>
                            <div class="col pl-0">
                                <div class="input-group ">
                                    <input type="text" class="form-control " id="enterEmailid" name="enterEmailid" required>
                                </div>
                                <div class="invalid-feedback">
                                    Please make sure that the user has sign-up on the CSI-SAKEC website.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3"><i class="fas fa-money-bill"></i> Amount: </div>
                            <div class="col pl-0">
                                <div class="input-group">
                                    <input type="text" class="form-control " id="enterAmount" name="enterAmount" required>
                                </div>
                                <div class="invalid-feedback">
                                    Amount for the registration.
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 ">
                                <i class="fas fa-file-invoice"></i> Bill Photo :
                            </div>
                            <div class="col pl-0">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="enterBillPhoto" name="enterBillPhoto" aria-describedby="inputGroupFileAddon01" required>
                                    <label class="custom-file-label" for="enterBillPhoto">Choose file</label>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
                        <button type="submit" class="btn btn-primary" name="saveRole"><i class="fas fa-save"></i> Register User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- DO NOT DELETE THIS  -->
    <script src="../plugins/fontawesome-free-5.15.3-web/js/all.min.js"></script>
    <script src="../plugins/jquery.min.js"></script>
    <script src="../plugins/bootstrap-4.6.0-dist/js/bootstrap.min.js"></script>
    <!-- DO NOT DELETE THIS  -->
    <script>
        $('#enterBillPhoto').on('change',function(){
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })
        $(document).on('submit', '#addRegistrationData', function(e) {
            e.preventDefault();
            var form = $(this);
            $(this).addClass("was-validated");
            var formdata = new FormData(this);
            formdata.append('eventId', '<?php echo $event_id; ?>');
            $.ajax({
                type: 'POST',
                url: '<?php echo $protocol . $domainName . "/api/eventRegistration.php"; ?>',
                contentType: 'multipart/form-data',
                cache: false,
                processData: false,
                contentType: false,
                data: formdata,
                dataType: 'JSON',
                success: function(response) {
                    if(response.status == 'success'){
                        $('#enterBillPhoto').next('.custom-file-label').html("Choose file");
                        form.trigger("reset");
                        form.removeClass("was-validated");
                        $("#addRegistration").modal("show");
                        console.log(response);
                    }else if(response.status == 'error'){
                        console.log(response);
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });
    </script>
</body>

</html>