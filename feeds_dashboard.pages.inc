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