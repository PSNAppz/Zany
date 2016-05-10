$(function(){
    $('#sidebar a').click(function(){
        $('#sidebar .active').removeClass('active'); // remove the class from the currently selected
        $(this).addClass('active'); // add the class to the newly clicked link
    });
});
