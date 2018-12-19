$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('toggled');
        $(this).toggleClass('opened');
    });

    $.scrollUp({
        scrollText: '<span class="oi oi-caret-top"></span>'
    });
    
});
