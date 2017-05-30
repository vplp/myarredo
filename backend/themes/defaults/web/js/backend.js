// Checkbox event
$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
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

var sorted_table_cache = {};

// Sortable rows
$('.sorted_table').sortable({
    containerSelector: 'table',
    itemPath: '> tbody',
    itemSelector: 'tr',
    placeholder: '<td class="sortplace"/>',
    delay: 500,
    onDrop: function ($item, container, _super) {
        var sort_url = $item.closest('table').attr('data-sortableurl');
        var csrf = $item.closest('table').attr('data-csrf');
        var tableid = $item.closest('table').attr('id');
        console.log(sort_url);
        var rows_data = [];

        $item.closest('table').find('tbody tr').each(function (i, row) {
            var row = $(row).attr('data-key');
            if (row != undefined) {
                console.log(row);
                rows_data.push(row);
            }
        });

        //вставить проверку одинаковый ли массив, если нет, то отослать сохранение в БД
        sorted_table_cache[tableid] = rows_data;
        console.log(sorted_table_cache);

        $.post(sort_url, {rows_data: rows_data, _csrf: csrf});

        _super($item, container);
    }
});