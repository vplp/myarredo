/**
 * Created by Threads on 14-Aug-16.
 */
/** Delete button confirm message for gridview */
$('.ActionDeleteColumn').click(function () {
    return confirm($(this).attr('data-message'));
});

