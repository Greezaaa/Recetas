//toggle "active" class on.click btn-menu to main-menu and  btn-menu
jQuery(function ($) {

    $('.btn-menu').click(function () {
        $('.main-menu').toggleClass('active');
        $('.btn-menu').toggleClass('active');
    });

    $(document).on("click", function (e) {
        if (
            $(e.target).closest(".main-menu").length == 0 &&
            $(".main-menu").hasClass("active") &&
            $(e.target).closest(".btn-menu").length == 0
        ) {
            $('.main-menu').toggleClass('active');
            $('.btn-menu').toggleClass('active');
        }
    });
});
//show hide hidden password
function showPass() {
    var tipo = document.getElementById("password");
    if (tipo.type == "password") {
        tipo.type = "text";
    } else {
        tipo.type = "password";
    }
}

//remove parent onClick
$(".close-btn").click(function () {
    $(this).parent().remove();
})

//autohide msg-alert
setTimeout(function () {
    $('#msg-alert').fadeOut('fast');
}, 5000);

//show user-nav content
$('.user-nav-wrapper').on('click', function () {
    $('.user-nav-wrapper').toggleClass('active');
})

