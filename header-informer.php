<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>nix101.com - Header Informer</title>

  <meta name="description" content="A utility for checking server headers">
  <meta name="author" content="robert smith">
  <style>
    body {width:1366px; font-family:arial;}
    h2 {font-weight:normal; margin: 0 15px;}
    ul {padding-left:0;}
    li {list-style-type:none;}
    .half-width {width:40%;}
    .full-width {width:80%; margin-right:45px;}
    .float-left {float:left;}
    .box {border:1px solid black; border-radius:3px; margin:15px;}
    .box-inner {padding:15px;}
    .row {overflow:auto;}
    .line-pad {padding:5px;}
    .highlight {background-color:#ccffcc;}
    .fine-print {text-align:center; clear:left; margin:15px 15px;}
   </style>
</head>
<body onload="document.getElementsByTagName('input')[0].focus();">
<div class="row">
  <div class="half-width float-left">
    <div>
      <h2>Form data input via POST</h2>
    </div>
    <div class="box box-inner">
      <p>Type some value in the text box and click submit to see POST data</p>
      <p>Textbox name is <i>formInput</i></p>
      <form action="header-informer.php" method="post">
         <input name="formInput" type="text" value="hello world">
         <button type="submit">submit</button>
      </form>
    </div>
  </div>

  <div class="half-width float-left">
    <div>
      <h2>URL data input via GET</h2>
    </div>
    <div class="box box-inner">
      <ul>
        <li><a href="/tools/header-informer">home</a></li>
        <li><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">refresh</a></li>
        <li><a href="header-informer.php?test=urlinput">header-informer.php?test=urlinput</a></li>
        <li><a href="header-informer.php?hello=world">header-informer.php?hello=world</a></li>
      </ul>
    </div>
  </div>
  <div class="full-width">
    <p class="fine-print">Non-alpha-numeric characters discarded</p>
  </div>
</div>

<div class="row">
  <div class="full-width">
  <div>
    <h2>POST &amp; GET data</h2>
  </div>
  <div class="box box-inner">
  <?php
    if (count($_REQUEST) > 0)
      {
      foreach($_REQUEST as $k => &$v)
        {
        // discard unwanted input
        $new_k = implode("",preg_grep("/[a-zA-Z0-9]/",str_split($k)));
        $new_v = implode("",preg_grep("/[a-zA-Z0-9 ]/",str_split($v)));
        printf("<div>%s = %s</div>", $new_k, $new_v);
        }
      }
    else
      {
      printf("No data yet");
      }
  ?>
  </div>
  </div>
</div>

<div class="row">
  <div class="full-width">
  <div>
    <h2>Server header data</h2>
  </div>
  <div class="box box-inner">
  <div class="headerList">
  <?php
     $lineNumber=1;
     foreach ($_SERVER as $k => &$v)
      {
      if (is_int($lineNumber / 2))
        {
        printf('<div class="line-pad">%s = %s</div>', $k, $v);
        }
      else
        {
        printf('<div class="line-pad highlight">%s = %s</div>', $k, $v);
        }
        $lineNumber++;
      }
    ?>
  </div>
  </div>
  </div>
</div>
</body>
</html>
