jQuery(document).ready(function() {
    jQuery(".toggle-bar li a").on("click", function(){
        let elementId = jQuery(this).parent().attr("id");
        setCookie('wp-settings-alexsim-panel', elementId);
    })
})


window.setCookie = function setCookie(key, value, expiry) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

window.getCookie = function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}