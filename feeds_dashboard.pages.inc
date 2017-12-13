<?php

/**
 * Displays feed history.
 *
 * @param FeedsImporter $feed
 *   Feed configuration.
 */
function feeds_dashboard_show_history(FeedsImporter $feed_importer) {
  $operations = feeds_dashboard_get_operations_for_feed($feed_importer->id);

  if(!empty($operations)) {
    return theme('feeds_dashboard_history_page', array('operations' => $operations));
  }

  return t("No operations found for this feed.");
}

/**
 * Displays feed operation.
 *
 * @param FeedsImporter $feed
 *   Feed configuration.
 * @param int $did
 *   Operation id.
 */
function feeds_dashboard_show_operation(FeedsImporter $feed_importer, $did) {
  $operation = feeds_dashboard_get_operation($did);

  if(!empty($operation)) {
    return theme('feeds_dashboard_history_page', array('operations' => $operation));
  }

  return t("No content found for this operation.");
}

/**
 * Displays feed operation.
 *
 * @param FeedsImporter $feed
 *   Feed configuration.
 * @param int $did
 *   Operation id.
 * @param int $imid
 *   Import id.
 */
function feeds_dashboard_show_operation_content(FeedsImporter $feed_importer, $did, $imid) {
  $data = feeds_dashboard_get_imported_data($imid);

  if(!empty($data) && !empty($data['content'])) {
    $content = unserialize($data['content']);
    $header = $rows = array();

    foreach ($content as $key => $value) {
      $header[] = $key;
      $rows[0][] = $value;
    }
    return theme('table', array('header' => $header, 'rows' => $rows));
  }

  return t("No content found for this import.");
}

/**
 * Displays imported content.
 *
 * @param int import id.
 */
function feeds_dashboard_show_details($did) {
  $data = feeds_dashboard_get_data_for_operation($did);

  if(!empty($data)) {
    return theme('feeds_dashboard_details', array('data' => $data));
  }

  return t("No content was created/changed/deleted by this import.");
}