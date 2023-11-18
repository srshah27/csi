
async function sendingEmail(to_address, subject, body, url) {
    var formData = new FormData();
    var msg;
    formData.append('to_address', to_address);
    formData.append('reply_to_address', 'csi@sakec.ac.in');
    formData.append('bcc_address', 'csi.sakec2022@gmail.com');
    formData.append('body', body);
    formData.append('subject', subject);
    formData.append('alt_body', 'Some error occured');
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        async: false,
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'JSON',
        success: function (response) {
            console.log(response);
            msg = response.message;
            return msg;
        },
        error: function (response) {
            console.log(response);
            msg = response.message;
            return msg;
        }
    });
    return msg;
}


function successClassAdder() {
    if ($(".toast-body").hasClass('alert-danger')) {
        $(".toast-body").removeClass('alert-danger');
    }
    if (!$(".toast-body").hasClass('alert-success')) {
        $(".toast-body").addClass('alert-success');
    }
}
function dangerClassAdder() {
    if ($(".toast-body").hasClass('alert-success')) {
        $(".toast-body").removeClass('alert-success');
    }
    if (!$(".toast-body").hasClass('alert-danger')) {
        $(".toast-body").addClass('alert-danger');
    }
}
function disableContactUsButton(email) {
    $("button[name='contactUsButton']").prop('disabled', true);
    $(".toast-body").text("Acknowledgement Email to EmailId(" + email + ").");
    successClassAdder();
    $("#myToast").toast('show');
    setTimeout(function () {
        $("button[name='contactUsButton']").prop('disabled', false);
    }, 10000);
}
function error(msg) {
    $(".toast-body").text(msg);
    dangerClassAdder();
    $("#myToast").toast('show');
}
function successMessage(msg) {
    $(".toast-body").text(msg);
    successClassAdder();
    $("#myToast").toast('show');
}
function disableGoogleButton(email) {
    $(".g_id_signin").hide(750);
    $(".toast-body").text("Acknowledgement Email sent to EmailId(" + email + ").");
    $("#myToast").toast('show');
    setTimeout(function () {
        $(".g_id_signin").show(750);
    }, 10000);
}
function removeRow(id, email) {
    $('#sendEmailModal' + id).modal('toggle');
    $("#row" + id).hide(1000, function () {
        $("#row" + id).remove();
    });
    $(".toast-body").text("The Email has been sent to EmailId(" + email + ").");
    $("#myToast").toast('show');
}