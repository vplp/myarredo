/**
 * Created by Threads on 14-Aug-16.
 */
/** Delete button confirm message for gridview */
$('.ActionDeleteColumn').click(function () {
    if (confirm($(this).attr('data-message'))) {
        return true;
    } else {
        return false;
    }
});
