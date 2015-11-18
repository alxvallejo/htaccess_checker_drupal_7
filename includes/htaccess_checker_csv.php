<?php

/**
 * Callback for htaccess checker form CSV.
 *
 * @param $form
 * @param $form_state
 */
function htaccess_checker_callback(&$form, $form_state) {
  if ($errors = form_get_errors()) {
    return $form;
  }
  // setup redirects list
  $redirects = array();
  $redirect_count = 0;
  // setup ajax commands array
  $commands = array();
  // save file to temp dir
  $file = file_save_upload('htaccess_csv_upload', array('file_validate_extensions' => array('csv')), "temporary://", $replace = FILE_EXISTS_REPLACE);
  if ($file) {
    $row = 0;
    // deal with mac line endings (from http://php.net/manual/en/function.fgetcsv.php#87196)
    ini_set('auto_detect_line_endings',TRUE);
    if (($handle = fopen($file->uri, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 500, ",")) !== FALSE) {
        $redirects[$row]['src'] = $data[0];
        $redirects[$row]['tgt'] = $data[1];
        $row++;
        $redirect_count++;
      }
      fclose($handle);
    }
    ini_set('auto_detect_line_endings',FALSE);
    $successful_redirects = 0;
    $no_redirects = array();
    $wrong_redirects = array();
    foreach ($redirects as $i => $redirect) {
      $src = $redirect['src'];
      $tgt = $redirect['tgt'];
      $headers = array(
        'Host: ' . $src
      );
      $curl = curl_init();
      curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
      curl_setopt($curl,CURLOPT_URL,$tgt);
      //curl_setopt($curl,CURLOPT_HEADER,true);
      curl_setopt($curl,CURLINFO_HEADER_OUT,true);
      curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
      $result = curl_exec($curl);
      $curl_header_sent = curl_getinfo($curl,CURLINFO_HEADER_OUT);
      $curl_effective_url = curl_getinfo($curl,CURLINFO_EFFECTIVE_URL);

      // The effective url will have a trailing slash.
      // Make sure the target also gets the slash for a valid comparison

      if (substr($tgt, -1) !== '/') {
        $tgt = $tgt . '/';
      }

      if (substr($curl_effective_url, -1) !== '/') {
        $curl_effective_url = $curl_effective_url . '/';
      }

      // String comparison
      if ($tgt == $curl_effective_url) {
        $successful_redirects++;
      }
      elseif ($src == $curl_effective_url) {
        $no_redirects[$i]['src'] = $src;
        $no_redirects[$i]['tgt'] = $tgt;
        $no_redirects[$i]['effective'] = $curl_effective_url;
      }
      else {
        $wrong_redirects[$i]['src'] = $src;
        $wrong_redirects[$i]['tgt'] = $tgt;
        $wrong_redirects[$i]['effective'] = $curl_effective_url;
      }
    }
    curl_close($curl);

    // Redirect count
    $commands[] = ajax_command_append('#htaccess-check', $redirect_count . ' redirects found in file ' . $file->filename);

    // Format response
    $successful_report = '<div class="success-redirects"><span class="success">' . $successful_redirects . '</span> redirects tested successfully.</div>';
    $commands[] = ajax_command_append('#htaccess-check', $successful_report);

    // No redirects report
    if (!empty($no_redirects)) {
      $no_redirect_report = array();
      foreach ($no_redirects as $i => $no_redirect) {
        $no_redirect_report[] = '<div class="no-redirects"><span class="src">' . $no_redirect['src'] . '</span> failed to redirect to <span class="tgt">' . $no_redirect['tgt'] . '</span> and instead redirected to <span class="effective">' . $no_redirect['effective'] . '</span></div>';
      }
      $commands[] = ajax_command_append('#htaccess-check', implode('',$no_redirect_report));
    }

    // Wrong redirects report
    if (!empty($wrong_redirects)) {
      $wrong_redirect_report = array();
      foreach ($wrong_redirects as $i => $wrong_redirect) {
        $wrong_redirect_report[] = '<div class="wrong-redirects"><span class="src">' . $wrong_redirect['src'] . '</span> failed to redirect to <span class="tgt">' . $wrong_redirect['tgt'] . '</span> and instead redirected to <span class="effective">' . $wrong_redirect['effective'] . '</span></div>';
      }
      $commands[] = ajax_command_append('#htaccess-check', implode('',$wrong_redirect_report));
    }

    return array(
      '#type' => 'ajax',
      '#commands' => $commands,
    );
  }
  else {
    $commands[] = ajax_command_append('#htaccess-check', 'No file uploaded.');
  }
}
