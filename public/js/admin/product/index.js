if (window.location.href.includes('inactive')) {
    $('#inactive').removeClass('btn-outline-danger').addClass('btn-danger');
} else {
    $('#active').removeClass('btn-outline-primary').addClass('btn-primary');
}
$('#inactive').click(function () {
    $(this).removeClass('btn-outline-danger').addClass('btn-danger');
})
$('#active').click(function () {
    $(this).removeClass('btn-outline-primary').addClass('btn-primary');
})
$(document).ready(function () {
    // $('.col-sm-12').each(function () {
    //     if ($(this).find('table')) {
    //         $(this).addClass('scroll-x table-container');
    //     }
    // })
})