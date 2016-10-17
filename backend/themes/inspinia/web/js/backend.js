// Checkbox event
$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
});

$(document)
    // Ajax checkbox Many-to-many
    .on('ifChanged', '.ajax-many-to-many', function () {
        jQuery.ajax({
            'url': $(this).data('url'),
            'cache': false,
            'data': {
                id: $(this).data('id'),
                namespace: $(this).data('namespace'),
                primaryKeyFirstTable: $(this).data('primaryKeyFirstTable'),
                valueFirstTable: $(this).data('valueFirstTable'),
                primaryKeySecondTable: $(this).data('primaryKeySecondTable'),
                valueSecondTable: $(this).data('valueSecondTable'),
                additionalFields: $(this).data('additionalFields'),
                checked: $(this).prop('checked')

            },
            success: function (data) {
            },
            error: function (err) {
                console.log(err);
            }
        })
    });

// Save and Exit POST value
$('.action_save_and_exit').click(function () {
    $('input[name=\"save_and_exit\"]').val(1);
});

// Ajax checkbox
$('.ajax-switcher').on('ifChanged', function () {
    jQuery.ajax({
        'url': $(this).data('url'),
        'cache': false,
        'data': {
            id: $(this).data('id'),
        },
        success: function (data) {
        },
        error: function (err) {
            console.log(err);
        }
    });
});

// Ajax status switcher
$('.ajax-status-switcher').on('click', function () {

    var obj = this;

    jQuery.ajax({
        'url': $(obj).data('url'),
        'cache': false,
        'data': {
            id: $(obj).data('id'),
        },
        success: function (data) {
            var switches = $(obj).parent().find('.ajax-status-switcher');
            //console.log($(obj).parent(), switches);
            switches.each(function () {
                var style = $(this).css('display');
                //console.log(style);
                $(this).css('display', style == 'inline' ? 'none' : 'inline');
            });
        },
        error: function (err) {
            console.log(err);
        }
    });
});
