<?php

function theme_customsortmodule_display_items_table_form($form) {
  //This function is the instantiator of the sorter. Make sure the 0th paramater is the id of your table, and the 3rd paramater is the class of your weight variable
  drupal_add_tabledrag('thetable', 'order', 'sibling', 'theweight');

  //Define your table headers
  $header = array(
    t('Name'),
    t('Weight'),
  );
  $rows = array();

  //Loop through each item to display in the sortable table
  foreach (element_children($form) as $key) {
    if (isset($form[$key]['name'])) {

      //Make this variable the weight class defined in the drupal_add_tabledrag function.
      $form[$key]['weight']['#attributes']['class'] = 'theweight';

      $row = array();
      //Define columns
      $row = array(
        drupal_render($form[$key]['name']),
        drupal_render($form[$key]['weight']),
        //Add to the $rows varaiable, which will be used to generate the sortable rows
        $rows[] = array(
          'data' => $row,
          'class' => 'draggable'
        );
    }
  }

  //Finally, output the sortable table. Make sure the id variable is the same as the table id in drupal_add_tabledrag
  $output = theme('table', $header, $rows, array('id' => 'thetable'), "My Sorted Items");
  $output .= drupal_render($form);
  return $output;

}
- See more at: https://www.unleashed-technologies.com/blog/2010/12/15/drupal-drag-and-drop-sorting#sthash.nqESCwvj.dpuf