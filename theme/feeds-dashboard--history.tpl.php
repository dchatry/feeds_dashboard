<?php
/**
 * Displays main feed history page.
 *
 * Available variables:
 *  $variables['operations']: contains data for each operation
 *  processed by this feed.
 *
 */
?>
<div class="feeds-dashboard">
  <fieldset>
    <legend><span class="fieldset-legend"><?php print t("History"); ?></span></legend>
    <div class="fieldset-wrapper"><?php print t('@count proccessed operation(s)', array('@count' => count($variables['operations']))); ?></div>
  </fieldset>
  <?php foreach ($variables['operations'] as $did => $operation): ?>
    <fieldset>
      <legend><span class="fieldset-legend"><?php print t("On ") . $operation->date; ?></span></legend>
      <div class="fd-operation fd-operation-$did fieldset-wrapper">
        <div class="fd-operation-file">
          <label><?php print t("From file:"); ?></label>
          <?php print l(drupal_basename($operation->file), file_create_url($operation->file)); ?>      
        </div>
        <div class="fd-operation-summary">
          <label><?php print t("Summary:"); ?></label>
          <?php print $operation->operation_description; ?>      
        </div>
        <div class="fd-operation-details">
          <?php print feeds_dashboard_show_details($operation->did); ?>      
        </div>
      </div>
    </fieldset>
  <?php endforeach; ?>
</div>