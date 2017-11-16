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
  foreach ($variables['data'] as $imid => $data) {
    $entity = unserialize($data->entity);
    if ($entity->revision === FALSE) {
      print "<div class='fd-alert'>" . t("At least one entity has its revision setting disabled, some functionalities such as revision comparison and rollback might not work and may result in a loss of data. Make sure to enable \"Create a new revision\" on the content type settings page.") . "</div>";
      break;
    }
  }
?>
<table>
  <thead>
    <tr>
      <th>Entity</th>
      <th>Operation</th>
      <th>Source data</th>
      <th>Snapshot data</th>
      <th>Current data</th>
      <th>Compare snapshot and current</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($variables['data'] as $imid => $data): ?>
      <?php $entity = unserialize($data->entity); ?>
      <tr>
        <td class="fd-title">
          <?php
            print l($entity->title, $entity->feeds_item->entity_type . '/' . $entity->feeds_item->entity_id);
          ?>
        </td>
        <td>
          <?php
            if($entity->feeds_item->is_new === TRUE) {
              print "<span class='fd-created'>" . t("Created") . "</span>";
            } else {
              print "<span class='fd-updated'>" . t("Updated") . "</span>";
            }
          ?>
        </td>
        <td><?php print l('Source data', 'import/' . arg(1) . '/history/operation/' . $data->did . '/' . $data->imid); ?></td>
        <td><?php print l('Snapshot data', $entity->feeds_item->entity_type . '/' . $entity->feeds_item->entity_id . '/revisions/' . $entity->vid . '/view'); ?></td>
        <td><?php print l('Current data', $entity->feeds_item->entity_type . '/' . $entity->feeds_item->entity_id); ?></td>
        <td><?php print l('Compare', $entity->feeds_item->entity_type . '/' . $entity->feeds_item->entity_id . '/revisions/view/' . $entity->old_vid . '/' . $entity->vid); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>