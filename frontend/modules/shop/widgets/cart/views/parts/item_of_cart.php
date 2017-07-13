<?php
/**
 * @author Alla Kuzmenko
 * @copyright (c) 2016, Thread
 */
?>
<tr >
    <td >
       <?= 'CartItem - ' . $item['id'] ?>
    </td>
    <td >
        <?= $item['count'] ?>
    </td>
    <td >
        <?= $item['price'] ?>
    </td>
    <td>
        <?= $item['discount_full'] ?>
    </td>
    <td>
        <?= $item['total_summ'] ?>
    </td>
    <td >
        <?= $item['extra_param'] ?>
    </td>
</tr>
