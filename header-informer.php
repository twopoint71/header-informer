<?php
/**
 * HTML character encoding
 */
function html_e(String $str): String {
    return htmlspecialchars((String)$str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Only show headers that do not reveal information which may be sensitive
 */
$allowed_headers = [
    'GATEWAY_INTERFACE',
    'HTTPS',
    'HTTP_',
    'QUERY_',
    'REMOTE_',
    'REQUEST_',
    'SCRIPT_NAME',
    'SERVER_PORT',
    'SERVER_PROTOCOL',
];

/** 
 * Filter for permitted headers
 */
$headers = [];
foreach($allowed_headers as $allowed_header) {
  foreach($_SERVER as $header => $value) {
    if (str_starts_with($header, $allowed_header)) {
      $headers[$header] = $value;
    }
  }
}

/**
 * $_GET and $_POST are more definitive than $_REQUEST
 */
$inputs = array_merge($_GET, $_POST);

/**
 * Print inputs
 */
function print_input_rows(): Void {
    global $inputs;
    $line_number=1;
    
    if (count($inputs) > 0) {
        foreach($inputs as $variable => $value) {
            $highlight = ($line_number % 2 == 1) ? 'class="highlight"' : '';
            printf('<tr %s><td>%s</td><td>%s</td></tr>', $highlight, html_e($variable), html_e($value));
            $line_number++;
        }
    } else {
        printf('<tr><td colspan="2">No data</td></tr>');
    }
}

/**
 * Print headers rows
 */
function print_header_rows(): Void {
    global $headers;
    $line_number=1;

    foreach ($headers as $header => $value) {
        $highlight = ($line_number % 2 == 1) ? 'class="highlight"' : '';
        printf('<tr %s><td>%s</td><td>%s</td></tr>', $highlight, $header, $value);
        $line_number++;
    }
  }
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>nix101.com - Header Informer</title>

  <meta name="description" content="A utility for checking server headers">
  <meta name="author" content="github.com/twopoint71/header-informer">
  <style>
    :root {
      --greenbar: #ccffcc;
      --paper: #f1e9d2;
      --dark: #1f1f1f;
    }
    body {font-family:arial; color:var(--dark); padding: 0 15px;}
    h2 {font-weight:normal;}
    ul {padding-left:0;}
    li {list-style-type:none;}
    .box {border:1px solid var(--dark); border-radius:3px;}
    .sep-right {border-right:1px solid var(--dark);}
    .sep-bot {border-bottom:1px solid var(--dark);}
    table {background-color:var(--paper); border-collapse:separate; border-spacing:0;}
    table, th, td {border:0;}
    th, td {padding:6px 6px; text-align:left;}
    .highlight {background-color:var(--greenbar);}
  </style>
</head>
<body onload="document.getElementsByTagName('input')[0].focus();">
<h2>A simple tool for checking web server perspective</h2>
<h2>POST &amp; GET</h2>
<table class="box" >
  <thead><th class="sep-right sep-bot">Input via POST</th><th class="sep-right sep-bot">Input via GET</th><th class="sep-bot">Results</th></thead>
  <tbody>
    <tr>
      <td class="sep-right">
          <p>Type a value in the text box and click submit to see POST data</p>
          <p>Textbox name is <i>formInput</i></p>
          <form action="header-informer.php" method="post">
            <input name="formInput" type="text" value="hello world">
            <button type="submit">submit</button>
          </form>
      </td>
      <td class="sep-right">
        <ul>
          <li><a href="/tools/network/header-informer">home</a></li>
          <li><a href="<?=html_e($_SERVER['SCRIPT_NAME'])?>">refresh</a></li>
          <li><a href="header-informer.php?test=urlinput">?test=urlinput</a></li>
          <li><a href="header-informer.php?hello=world">?hello=world</a></li>
        </ul>
      </td>
      <td>
        <table>
          <thead>
            <th>Variable</th><th>Value</th>
          </thead>
          <tbody>
            <?=print_input_rows()?>
          </tbody>
        </table>
      </td>            
    </tr>
  </tbody>
</table>
<h2>Server header data</h2>
<table class="box">
    <thead>
        <th class="sep-bot">Header</th><th class="sep-bot">Value</th>
    </thead>
    <tbody>
        <?=print_header_rows()?>
    </tbody>
</table>
</body>
</html>
