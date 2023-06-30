<?php
include ("includes/cms.php");

$glossID = initVars('id', '');
$analysis = initVars('an', '');
$analysisHeadword = initVars('anH', '');

$browseBook = initVars('bb', '');
$keilVol = initVars('kV', '');
$keilPage = initVars('kP', '');
$keilLine = initVars('kL', '');
$msPage = initVars('ms', '');

$searchStr = initVars('s', '');
$searchIn = initVars('si', 'gl');
$searchType = initVars('t', '');
$searchBook = initVars('b', '');
// if searching in Priscan, clear gloss type
if ($searchIn == 'pr') $searchType = '';

$thes = initVars('thes', '');

$msCutOff = initVars('cutoff', '');
if ($msCutOff == '0') $msCutOff = false;
else $msCutOff = true;

// error checking
$error = '';
if ($keilPage != '' && ! is_numeric($keilPage)) {
   $keilPage = ''; 
   $error = 'The page number given for Hertz edition is not a number.';
} 
if (! is_numeric($keilLine)) $keilLine = '';

// for browsing by book or MS, determine Keil vol, page here
if ($browseBook != '') {
   $keilVol = $priscianBooks[$browseBook][1];
   $keilPage = $priscianBooks[$browseBook][2];
}
elseif ($msPage != '') {
   if ($msPage > 78 && $msPage < 88) $error = '<p>The manuscript pagination jumps from <a href="index.php?ms=78">78</a> to <a href="index.php?ms=88">88</a> (even though there appears to be no textual lacuna). Click either number to go to that page.</p>';
   elseif ($msPage > 249) $error = '<p>The manuscript ends at p. <a href="index.php?ms=249">249</a>.</p>';
   else {
      $result = mysqli_query($link, "Select keil_vol, keil_page From glosses Where ms_ref RegExp '^$msPage' And keil_page Is Not Null Limit 0,1 ");
      if (mysqli_num_rows($result) == 0) $error = '<p>There are no glosses on p. ' . formatMsRef($msPage) . '.</p>';
      else {
         $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
         $keilVol = $rows[0]['keil_vol'];
         $keilPage = $rows[0]['keil_page'];
      }
      
   }
}

// check to see if keil pages are within limits
if ($keilVol == 2 && $keilPage > 597) $error = '<p><i>GL</i> II ends at p. <a href="index.php?kV=2&kP=597">597</a>.</p>';
elseif ($msCutOff && ($keilVol == 3 && $keilPage > 147)) $error = '<p>This edition displays only the text of Priscian to <i>GL</i> III, p. <a href="index.php?kV=3&kP=147">147</a>, where the St Gall manuscript ends (at <i>naturaliter</i>, line 18).</p>';

// process Thes. ref. search
if ($thes <> '') {
   $colPos = strpos($thes, 'a');
   if ($colPos == false) $colPos = strpos($thes, 'b');
   if ($colPos != false) {
      // split and pad Thes. ref. to match db values
      $thesSearch = str_pad(substr($thes, 0, $colPos), 3, "0", STR_PAD_LEFT) . substr($thes, $colPos, 1) . str_pad(substr($thes, $colPos + 1), 2, "0", STR_PAD_LEFT);
      // search db
      $sql = "Select recordID From glosses Where thesaurus_ref = '$thesSearch'";
      $results = mysqli_query($link, $sql);

      // if no match, then display results of an MS page search instead
      if (mysqli_num_rows($results) == 0) $msPage = substr($thes, 0, $colPos);
      else {
         $rows = mysqli_fetch_all($results, MYSQLI_ASSOC);
         $glossID = $rows[0]['recordID'];
         $analysis = 1;
      }   
   }
}


// template
templateHeader();
templateSearchForm();
?>

<div class="container mt-5">
<?php
   
if ($error != '') print $error;

// show gloss analysis
elseif ($analysis != '') {
   require('components/analysis.php');
}
// search glosses and lemmata 
elseif ($searchStr != '' || $searchBook != '' || $searchType != '') {
   require('components/search.php');
}
// browse text and glosses
elseif ($keilVol != '' && $keilPage != '') {
   require('components/browse.php');
}
// show home page text
else {
   include ("components/home.php");
}

?>
</div>

<?php
// template
templateFooter();
?>
