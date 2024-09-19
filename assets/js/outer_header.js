$(document).ready(function(){
    // Hide the flash message after 30 seconds (30000 milliseconds)
    setTimeout(function(){
        $("#flash-message").fadeOut("slow");
    }, 30000);

    // Password toggle visibility
    $("#showPasswordToggle").on("click", function () {
            var passwordInput = $("#passwordInput");
            var type = passwordInput.attr("type");
            passwordInput.attr("type", type === "password" ? "text" : "password");
        });
    // Password toggle visibility
    $("#showPasswordToggle").on("click", function () {
        var passwordInput = $("#password");
        var type = passwordInput.attr("type");
        passwordInput.attr("type", type === "password" ? "text" : "password");
        var icon = $(this);
        if (type === "password") {
            icon.removeClass("mdi-eye").addClass("mdi-eye-off");
        } else {
            icon.removeClass("mdi-eye-off").addClass("mdi-eye");
        }
    });
});