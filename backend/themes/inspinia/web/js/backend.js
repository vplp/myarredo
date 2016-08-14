// Checkbox event
$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
});

// Save and Exit POST value
$('.action_save_and_exit').click(function(){
    $('input[name=\"save_and_exit\"]').val(1);
});

// Ajax checkbox
$('.ajax-switcher').on('ifChanged', function () {
    jQuery.ajax({
        'url': $(this).data('url'),
        'cache': false,
        'data': {
            id : $(this).data('id'),
        },
        success: function (data) {},
        error: function (err) {
            console.log(err);
        }
    });
});
