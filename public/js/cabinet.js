$(document).ready(function () {

    // SideNav Button Initialization
    $(".button-collapse").sideNav();
    // SideNav Scrollbar Initialization
    var sideNavScrollbar = document.querySelector('.custom-scrollbar');
    var ps = new PerfectScrollbar(sideNavScrollbar);



})




function sendData() {
    var email = document.getElementById('email_id').value;
    var password = document.getElementById('password_id').value;
    var new_password = document.getElementById('new_password_id').value;
    var new_password2 = document.getElementById('new_password2_id').value;
    var webmoney = document.getElementById('webmoney_id').value;

    $.ajax('/api', {
        type: 'post',
        data: {
            'email': email,
            'password': password,
            'new_password': new_password,
            'new_password2': new_password2,
            'webmoney': webmoney,
            'action': 'save_settings'
        },
        success: function (data, status, xhr) {
            $('#alert_id')
                .css('display', 'block')
                .removeClass('alert-danger')
                .removeClass('alert-success')
                .addClass(data.type);
            $('#alert_id>h4').html(data.title);
            $('#alert_id>p').html(data.message);
        },
        dataType: 'json'
    });
}