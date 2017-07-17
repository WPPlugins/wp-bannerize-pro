<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<table id="wp-bannerize-summary"
       border="0"
       width="100%"
       cellpadding="0"
       cellspacing="0">

  <tbody>

  <?php foreach ( $result as $label => $value ) : ?>
    <tr>
      <th style="text-align: left;white-space: nowrap"><?php echo $label ?></th>
      <td width="100%" style="text-align: right"><?php echo $value ?></td>
    </tr>
  <?php endforeach; ?>

  </tbody>

</table>