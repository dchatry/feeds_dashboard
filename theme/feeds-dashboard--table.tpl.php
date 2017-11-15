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

<table>
  <thead>
    <tr>
      <th>Entity</th>
      <th>Operation</th>
      <th>Source data</th>
      <th>Snapshot data</th>
      <th>Current data</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($variables['data'] as $imid => $data): ?>
      <?php $entity = unserialize($data->entity); ?>
      <tr>
        <td>
          <?php 
            print l($entity->title, $entity->feeds_item->entity_type . '/' . $entity->feeds_item->entity_id);
          ?>
        </td>
        <td>
          <?php 
            if($entity->feeds_item->is_new === TRUE) {
              print t("Created");
            } else {
              print t("Updated");
            }
          ?>  
        </td>
        <td>Source data</td>
        <td>Snapshot data</td>
        <td>Current data</td>
      </tr>
    <?php endforeach; ?>  
  </tbody>
</table>