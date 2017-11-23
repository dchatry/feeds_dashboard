<?php
/**
 * Aggregates imported data.
 *
 * Available variables:
 *  $variables['data']: contains data for each entities
 *  processed by the import.
 *
 */
?>

<?php
  $enable_rollback = TRUE;
  foreach ($variables['data'] as $imid => $data) {
    $entity = unserialize($data->entity);
    if ($entity->revision === FALSE) {
      print "<div class='fd-alert'>" . t("At least one entity has its revision setting disabled, some functionalities such as revision comparison might not work and reverting has been disabled as it may result in a loss of data. Make sure to enable \"Create a new revision\" on the content type settings page.") . "</div>";
      $enable_rollback = FALSE;
      break;
    }
  }

  if($enable_rollback === TRUE) {
    print l('&#8617; Revert data to previous state (delete if no previous state)', 'import/' . arg(1) . '/history/operation/' . $data->did . '/revert', array('attributes' => array('class' => 'fd-rollback-link'), 'html' => TRUE));
  }
?>
<table>
  <thead>
    <tr>
      <th>Entity</th>
      <th>GUID</th>
      <th>Current</th>
      <th>Operation</th>
      <th>Source data</th>
      <th>Snapshot data</th>
      <th>Current data</th>
      <th>Compare snapshot and current</th>
    </tr>
  </thead>
  <tbody>
    <?php $limit = 0; ?>
    <?php foreach ($variables['data'] as $imid => $data): ?>
      <?php $entity = unserialize($data->entity); $entity_info = node_load($entity->nid); ?>
      <tr>
        <td class="fd-title">
          <?php
            print l($entity->title, $entity->feeds_item->entity_type . '/' . $entity->feeds_item->entity_id);
          ?>
        </td>
        <td>
          <?php
            print $entity->feeds_item->guid;
          ?>
        </td>
        <td>
          <?php if($entity_info->vid == $entity->vid && $data->state != 'deleted'): ?>
            <?php print t("Current"); ?>
          <?php endif; ?>
        </td>
        <td>
          <span class='fd-<?php print $data->state; ?>'><?php print ucfirst(t($data->state)); ?></span>
        </td>
        <td><?php print l('Source data', 'import/' . arg(1) . '/history/operation/' . $data->did . '/' . $data->imid); ?></td>
        <?php if($data->state != 'deleted'): ?>
          <td><?php print l('Snapshot data', $entity->feeds_item->entity_type . '/' . $entity->feeds_item->entity_id . '/revisions/' . $entity->vid . '/view'); ?></td>
        <?php else: ?>
          <td><?php print t('Deleted content'); ?></td>
        <?php endif; ?>
        <?php if($data->state != 'deleted'): ?>
          <td><?php print l('Current data', $entity->feeds_item->entity_type . '/' . $entity->feeds_item->entity_id); ?></td>
        <?php else: ?>
          <td><?php print t('Deleted content'); ?></td>
        <?php endif; ?>
        <?php if(isset($entity->old_vid) && $data->state != 'deleted'): ?>
          <td><?php print l('Compare', $entity->feeds_item->entity_type . '/' . $entity->feeds_item->entity_id . '/revisions/view/' . $entity->old_vid . '/' . $entity->vid); ?></td>
        <?php else: ?>
          <td><?php print t('No revision to compare'); ?></td>
        <?php endif; ?>
      </tr>
      <?php
        $limit++;
        // Limit displayed rows on history page.
        if($limit >= 10 && !arg(4)) {
          print "<tr><td class='fd-see-more-data' colspan=8>" . l('See all data', 'import/' . arg(1) . '/history/operation/' . $data->did) . "</td></tr>";
          break;
        }
      ?>
    <?php endforeach; ?>
  </tbody>
</table>