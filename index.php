<?php
include ("includes/cms.php");

$searchStr = initVars('s', '');
$glossID = initVars('id', '');

$analysis = initVars('an', '');
$analysisHeadword = initVars('anH', '');

$type = initVars('t', '');
$searchBook = initVars('b', '');
$searchIn = initVars('si', 'gl');

$keilVol = initVars('kV', '');
$keilPage = initVars('kP', '');
$keilLine = initVars('kL', '');
$browseBook = initVars('bb', '');
$msPage = initVars('ms', '');

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
      $result = db_query("Select keil_vol, keil_page From glosses Where ms_ref RegExp '^$msPage' And keil_page Is Not Null Limit 0,1 ");
      if (mysql_num_rows($result) == 0) $error = '<p>There are no glosses on p. ' . formatMsRef($msPage) . '.</p>';
      else {
         $keilVol = mysql_result($result, 0, 'keil_vol');
         $keilPage = mysql_result($result, 0, 'keil_page');
      }
      
   }
}

// check to see if keil pages are within limits
if ($keilVol == 2 && $keilPage > 597) $error = '<p><i>GL</i> 2 ends at p. <a href="index.php?kV=2&kP=597">597</a>.</p>';
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
      $results = db_query($sql);
      // if no match, then display results of an MS page search instead
      if (mysql_num_rows($results) == 0) $msPage = substr($thes, 0, $colPos);
      else {
         $glossID = mysql_result($results, 0, 0);
         $analysis = 1;
      }   
   }
}


// template
templateHeader();

?>
   <div id="searchPanel">


      <div id="leftPanel">

<!-- browse form -->

<h2 class="header">Browse Priscian</h2>

<form action="index.php" method="get">
<p> 
<label for="bb">Go to book:</label>
<select class="search" id="bb" name="bb">
<option value=""></option>
<?php
foreach ($priscianBooks As $key => $val) {
   if ($key == 0) writeOption($val[0], $key, $browseBook);
   else writeOption($key . ': ' . $val[0], $key, $browseBook);
} 
?>
</select> 
<input type="submit" value="go" />
</p>
</form>

<form action="index.php" method="get">
<p><label for="kP">Or to Hertz, ed.</label>
<i>GL</i> 
<select name="kV">
<?php
writeOption('II ', '2', $keilVol); 
writeOption('III ', '3', $keilVol);
?>
</select>
page <input type="text" id="kP" name="kP" value="<?php print $keilPage ?>" style="width: 35px; "/>
<input type="submit" value="go" />
</p>
</form>

<form action="index.php" method="get">
<p><label for="ms">Or to <span class="sc">ms</span> page (1–249):</label>
<input type="text" id="ms" name="ms" value="<?php print $msPage ?>"  style="width: 35px; "/>
<input type="submit" value="go" />
<span class="note">(e.g. 10, 10b)</span>
</p>
</form>


      </div>



      <div id="rightPanel">


<!-- search form -->

<h2 class="header">Search for glosses</h2>

<form action="index.php" method="get">
<p><label for="thes">Search by <i>Thes.</i> ref.</label>
<input type="text" id="thes" name="thes" style="width: 35px; "/>
<input type="submit" value="go"/>
<span class="note">(e.g. 14a6)</span>
</p>
<form>


<form action="index.php" method="get">


<p><label for="s">Or, search for text:</label> 
<input class="search" type="text" id="s" name="s" value="<?php print $searchStr ?>" />
</p>

<p><label for="t">Gloss type:</label>
<!--<input class="search" id="t" name="t" value="<?php print $type; ?>" />-->
<select class="search" id="t" name="t">
<option value="">(any)</option>
<?php
foreach ($glossTypes as $code => $description) {
   writeOption($code . ': ' . $description, $code, $type);
} 
?>
</select>
</p>

<p> 
<label for="b">In book:</label>
<select class="search" id="b" name="b">
<option value="">(all)</option>
<?php
foreach ($priscianBooks As $key => $val) {
   if ($key == 0) writeOption($val[0], $key, $searchBook);
   else writeOption($key . ': ' . $val[0], $key, $searchBook);
} 
?>
</select> 
</p>

<p>
<div class="label">Search in:</div>
<input type="radio" id="si_gl" name="si" value="gl"<?php if ($searchIn == 'gl') print ' checked="checked"'; ?> />
<label class="option" for="si_gl">glosses/lemmata</label>

<input type="radio" id="si_pr" name="si" value="pr"<?php if ($searchIn == 'pr') print ' checked="checked"'; ?> />
<label class="option" for="si_pr">Priscian</label>
</p>

<div class="label">&nbsp;</div>
<input type="submit" value="go" />
<span class="note">(Or search for <a href="forms.php">Old Irish forms</a>.)</span>
</form>




      </div>
   </div>

   <div id="content">

<?php
   
if ($error != '') print $error;

// show gloss analysis
elseif ($analysis != '') {

   print '<h2>Gloss analysis</h2>';

   // search glosses and lemmata only
   $sql = "Select recordID, book, code, ms_ref, keil_vol, keil_page, keil_line, types, text, thesaurus_ref, thesaurus_page, translation, has_analysis
      From glosses Where recordID = " . $glossID;

   $results = db_query($sql);
   if (mysql_num_rows($results) == 0) print '<p>Gloss not found.</p>';
   else {
      print '<table cellpadding="0" cellspacing="0" class="search">';
      print '<tr>';
      print '<th>MS</th>';
      print '<th>Gloss</th>';
      print '<th nowrap="nowrap">Keil, <i>GL</i></th>';
      print '<th><i>Thes.</i></th>';
      print '<th>Priscian</th>';
      print '<th>Type(s)</th>';
      print '<th>Lemma: gloss</th>';
      print '</tr>';

      $row = 0;         
      print '<tr>';
      print '<td class="small" nowrap="nowrap">' . formatMsRef(mysql_result($results, $row, 'ms_ref')) . '</td>';
      print '<td class="small" nowrap="nowrap">' . mysql_result($results, $row, 'code') . '</td>';
      print '<td class="small" nowrap="nowrap">' . formatKeilRef(mysql_result($results, $row, 'keil_vol'), mysql_result($results, $row, 'keil_page'), mysql_result($results, $row, 'keil_line'))  . '</td>';
      if (mysql_result($results, $row, 'thesaurus_ref') != '') print '<td class="small" nowrap="nowrap">' . formatThesRef(mysql_result($results, $row, 'thesaurus_ref'), mysql_result($results, $row, 'thesaurus_page')) . '</td>';
      else print '<td></td>';
      print '<td class="small" nowrap="nowrap">' . formatBookRef(mysql_result($results, $row, 'book')) . '</td>';
      print '<td class="small" nowrap="nowrap" style="padding-right: 20px; ">' . formatTypes(mysql_result($results, $row, 'types')) . '</td>';
      print '<td class="glosses">' . formatGloss(mysql_result($results, $row, 'text'), $searchStr, mysql_result($results, $row, 'keil_vol'), mysql_result($results, $row, 'keil_page'), mysql_result($results, $row, 'recordID'), mysql_result($results, $row, 'translation'), 0) . '</td>';
      print '</tr>';      
      print '</table>';

   }

   // get analysis details
   $sql = "Select word_instance, headword, DIL_headword, wordclass, subclass, meaning, analysis, voice, rel From word_instances 
      Where glossID = " . $glossID . " 
      Order By old_recordID";

   $results = db_query($sql);
   if (mysql_num_rows($results) == 0) print '<p>No details found.</p>';
   else {
      print '<p>&nbsp;</p>';
      print '<p>Old Irish elements:</p>';

      print '<table cellpadding="0" cellspacing="0" class="search">';
      print '<tr>';
      print '<th>Word form</th>';
      print '<th>Headword</th>';
      print '<th>Word class</th>';
      print '<th>Sub-class</th>';
      print '<th>Morph.</th>';
      print '<th>Meaning</th>';
      print '<th>Voice</th>';
      print '<th>Relative?</th>';
      print '</tr>';
         
      $row = 0;
      while ($row < mysql_num_rows($results)) {
         if ($row % 2 == 1) print '<tr>';
         else print '<tr style="background-color: #fcfcff; ">';
         print '<td nowrap="nowrap">' . mysql_result($results, $row, 'word_instance') . '</td>';
         print '<td nowrap="nowrap"><a class="tooltip" title="Click to see all attestations of this headword." href="forms.php?aHw=' . mysql_result($results, $row, 'headword') . '">' . mysql_result($results, $row, 'headword') . '</a>';
         if (mysql_result($results, $row, 'DIL_headword') != 'n/a') print ' <span class="note">[<a class="note" target="_blank" href="http://www.dil.ie/search?q=' . mysql_result($results, $row, 'DIL_headword') . '&search_in=headword">DIL</a>]</span>';
         print '</td>';
         print '<td class="small" nowrap="nowrap">' . mysql_result($results, $row, 'wordclass') . '</td>';
         print '<td class="small" nowrap="nowrap">' . mysql_result($results, $row, 'subclass') . '</td>';
         print '<td class="small" nowrap="nowrap">' . mysql_result($results, $row, 'analysis') . '</td>';
         print '<td class="small" nowrap="nowrap">' . mysql_result($results, $row, 'meaning') . '</td>';
         print '<td class="small" nowrap="nowrap">' . mysql_result($results, $row, 'voice') . '</td>';
         print '<td class="small" nowrap="nowrap">' . mysql_result($results, $row, 'rel') . '</td>';
         print '</tr>';
         $row ++;
      }

      print '</table>';


   }
}
elseif ($searchStr != '' || $searchBook != '' || $type != '') {

   // search glosses and lemmata 
   if ($searchIn == 'gl') {
      $sql = "Select recordID, book, code, ms_ref, keil_vol, keil_page, keil_line, types, text, thesaurus_ref, thesaurus_page, translation, has_analysis
         From glosses
         Where
            Replace(
               Replace(
                  Replace(
                     Replace(
                        Replace(
                           Replace(
                              Replace(
                                 Replace(
                                    Replace(
                                       Replace(text, 
                                       '<ex>', ''), 
                                    '</ex>', ''), 
                                 '<supplied>', ''), 
                              '</supplied>', ''), 
                           '<del>', ''), 
                        '</del>', ''), 
                     '<add>', ''), 
                  '</add>', ''), 
               '*', ''), 
            ',', '') 
            Like '%" . addslashes($searchStr) . "%'  
            ";
      if ($searchBook == 'p') $sql .= "And book = 0 ";
      elseif ($searchBook != '') $sql .= "And book = $searchBook ";
      if ($type != '') $sql .= "And types Like '%+$type%+%' ";
//      print "<pre>$sql</pre>";
       
         
      $results = db_query($sql);
      print '<h2>Search results</h2>';
      if (mysql_num_rows($results) == 0) print '<p>No matches found.</p>';
      else {
         if (mysql_num_rows($results) == 1) print '<p>One match found. ';
         else print '<p>' .   mysql_num_rows($results) . ' matches found. ';
         print 'Point to any link below for more information. '; 
         print '(See <a href="/">introduction</a> for further notes.) ';
         print '</p>';
       
         print '<table cellpadding="0" cellspacing="0" class="search">';
         print '<tr>';
         print '<th>MS</th>';
         print '<th>Gloss</th>';
         print '<th nowrap="nowrap">Keil, <i>GL</i></th>';
         print '<th><i>Thes.</i></th>';
         print '<th>Priscian</th>';
         print '<th>Type(s)</th>';
         print '<th>Lemma: gloss</th>';
         print '</tr>';
         
         $row = 0;
         while ($row < mysql_num_rows($results)) {
            if ($row % 2 == 1) print '<tr>';
            else print '<tr style="background-color: #fcfcff; ">';
// IDs            print '<td class="small" nowrap="nowrap">[id ' . mysql_result($results, $row, 'recordID') . '] ' . formatMsRef(mysql_result($results, $row, 'ms_ref')) . '</td>';
            print '<td class="small" nowrap="nowrap">' . formatMsRef(mysql_result($results, $row, 'ms_ref')) . '</td>';
            print '<td class="small" nowrap="nowrap">' . mysql_result($results, $row, 'code') . '</td>';
            print '<td class="small" nowrap="nowrap">' . formatKeilRef(mysql_result($results, $row, 'keil_vol'), mysql_result($results, $row, 'keil_page'), mysql_result($results, $row, 'keil_line'))  . '</td>';
            print '<td class="small" nowrap="nowrap">' . formatThesRef(mysql_result($results, $row, 'thesaurus_ref'), mysql_result($results, $row, 'thesaurus_page')) . '</td>';
            print '<td class="small" nowrap="nowrap">' . formatBookRef(mysql_result($results, $row, 'book')) . '</td>';
            print '<td class="small" nowrap="nowrap" style="padding-right: 20px; ">' . formatTypes(mysql_result($results, $row, 'types')) . '</td>';
            print '<td class="glosses">' . formatGloss(mysql_result($results, $row, 'text'), $searchStr, mysql_result($results, $row, 'keil_vol'), mysql_result($results, $row, 'keil_page'), mysql_result($results, $row, 'recordID'), mysql_result($results, $row, 'translation'), mysql_result($results, $row, 'has_analysis')) . '</td>';
            print '</tr>';      
            $row ++;
         }
         print '</table>';

      }
   }
   else {

      // search Priscian only
      print '<h2>Search results</h2>';
      $sqlP = "Select book, keil_vol, keil_page, keil_line, text From priscian_lines Where text Like '%$searchStr%' ";
      $resultsP = db_query($sqlP);
   
      if (mysql_num_rows($resultsP) == 0) print '<p>No matches found.</p>';
      else {
         // heading      
         if (mysql_num_rows($resultsP) == 1) print '<p>One match found. ';
         else print '<p>' . mysql_num_rows($resultsP) . ' matches found. ';
         print '(See <a href="/">introduction</a> for further notes.) ';
         print '</p>';
         
         // advisory note
//         print '<p>Point to any link below for more information. ';
//         print '</p>';
         
         $rowP = 0;
         print '<table cellpadding="0" cellspacing="0" class="browse" border="0">';
         while ($rowP < mysql_num_rows($resultsP)) {
            // line of Priscian
            print '<tr>';
            print '<td class="priscian" nowrap="nowrap"><a class="tooltip" title="Vol., page and line of Hertz\'s edition in Keil, <i>Grammatici Latini</i>. <br/>Click to go to context in Priscian. " href="index.php?kV=' . mysql_result($resultsP, $rowP, 'keil_vol') . '&amp;kP=' . mysql_result($resultsP, $rowP, 'keil_page') . '&amp;kL=' . mysql_result($resultsP, $rowP, 'keil_line') . '#hi">' . volConvert(mysql_result($resultsP, $rowP, 'keil_vol')) . ' ' . mysql_result($resultsP, $rowP, 'keil_page') . ',' . mysql_result($resultsP, $rowP, 'keil_line') . '</td>';
            print '<td class="priscian mainText">… ' . mysql_result($resultsP, $rowP, 'text') . ' …</td>';
            print '</tr>';
            $rowP ++;
         }
         print '</table>' . "\r\n";

      }
   }
}




/* browsing */

elseif ($keilVol != '' && $keilPage != '') {
   // combined Priscian/gloss display
   
   $sqlP = "Select book, keil_vol, keil_page, keil_line, text From priscian_lines Where keil_vol = $keilVol And keil_page = $keilPage ";
   $sqlG = "Select recordID, keil_vol, keil_ref, keil_page, keil_line, code, ms_ref, book, types, text, thesaurus_ref, thesaurus_page, translation, has_analysis From glosses Where keil_vol = $keilVol And keil_page = $keilPage  Order By keil_page, keil_line";

   $resultsP = db_query($sqlP);
   $resultsG = db_query($sqlG);

   if (mysql_num_rows($resultsP) == 0) {
      print '<p>No text available for p. ' . $keilPage . '.</p>';
      print '<p>The page in Keil may comprise variant apparatus only. Try pages 
         <a href="index.php?kV=' . $keilVol . '&amp;kP=' . ($keilPage - 1) . '#hi">' . ($keilPage - 1) . '</a> or 
         <a href="index.php?kV=' . $keilVol . '&amp;kP=' . ($keilPage + 1) . '#hi">' . ($keilPage + 1) . '</a>?</p>';
   }
   else {
      // heading      
      print '<h2><i>Grammatici Latini</i> ' . volConvert($keilVol) . ', p. ' . $keilPage . ': ';
      if (mysql_result($resultsP, 0, 'book') == 0) print ' Priscian, <i>Praefatio</i></h2>';
      else print ' Priscian, book ' . mysql_result($resultsP, 0, 'book') . ' (<i>' . $priscianBooks[mysql_result($resultsP, 0, 'book')][0] . '</i>)</h2>';
      
      // paging
      $nextPage = $keilPage + 1;
      $nextVol = $prevVol = $keilVol; 
      if ($keilVol == 2 && $nextPage > 597) {
         $nextVol = 3; 
         $nextPage = 1;
      }
      elseif ($msCutOff && $keilVol == 3 && $nextPage > 147) $nextPage = 0;
      $prevPage = $keilPage - 1;
      if ($keilVol == 3 && $prevPage < 1) {
         $prevVol = 2; 
         $prevPage = 597;
      }
      elseif ($keilVol == 2 && $prevPage < 1) $prevPage = 0;
      print '<p class="small" style="margin-bottom: 20px; ">';
      if ($prevPage > 0) print '<a class="button" href="index.php?kV=' . $prevVol . '&amp;kP=' . $prevPage . '#end">previous page</a>';
//      if ($prevPage > 0 && $nextPage > 0) print ' | ';
      if ($nextPage > 0) print '<a class="button" href="index.php?kV=' . $nextVol . '&amp;kP=' . $nextPage . '">next page</a>';
      print '</p>';
      
      // advisory note
      print '<p>Point to any link below for more information. ';
      print 'Note that the text of Priscian below is that of Hertz’s edition, and that of the St Gall manuscript may differ. ';  
      if ($glossID != '') print 'The gloss you selected is <a class="tooltip" title="Click to go to highlighted text." href="#hi">highlighted</a> in yellow. ';
      if ($keilLine != '') print 'The line of Priscian you selected is <a class="tooltip" title="Click to go to highlighted text." href="#hi">highlighted</a> in yellow. ';
      if ($msPage != '') print "Glosses for manuscript p. $msPage begin below. ";
      print '(See <a href="/">introduction</a> for further notes.) ';
      print '</p>';
      

      $rowP = 0;
      $rowG = 0;
      print '<table cellpadding="0" cellspacing="0" class="browse" border="0">';
      while ($rowP < mysql_num_rows($resultsP)) {
         // line of Priscian
         print '<tr>';
         if ($keilLine == mysql_result($resultsP, $rowP, 'keil_line')) {
            print '<td class="priscianHighlight small" nowrap="nowrap">' . formatKeilRef(mysql_result($resultsP, $rowP, 'keil_vol'), mysql_result($resultsP, $rowP, 'keil_page'), mysql_result($resultsP, $rowP, 'keil_line')) . '</td>';
            print '<td colspan="7" class="mainText priscianHighlight"><a name="hi"></a>' . mysql_result($resultsP, $rowP, 'text') . '</td>';
         }
         else {
            print '<td class="priscian small" nowrap="nowrap">' . formatKeilRef(mysql_result($resultsP, $rowP, 'keil_vol'), mysql_result($resultsP, $rowP, 'keil_page'), mysql_result($resultsP, $rowP, 'keil_line')) . '</td>';
            print '<td colspan="7" class="mainText priscian">' . mysql_result($resultsP, $rowP, 'text') . '</td>';
         }
         print '<tr>';

         // glosses for this line
         while (
            $rowG < mysql_num_rows($resultsG) && (
               mysql_result($resultsG, $rowG, 'keil_vol') == mysql_result($resultsP, $rowP, 'keil_vol') &&
               mysql_result($resultsG, $rowG, 'keil_page') == mysql_result($resultsP, $rowP, 'keil_page') &&
               intval(mysql_result($resultsG, $rowG, 'keil_line')) == mysql_result($resultsP, $rowP, 'keil_line')
               )
            ) {
            writeGlossRow();
            $rowG ++;
         }
         $rowP ++;
      }
      // catch any remaining glosses, not successfully linked
      while ($rowG < mysql_num_rows($resultsG)) {
         writeGlossRow();
         $rowG ++;
      }
      print '</table>' . "\r\n";
            
      // recap paging
      print '<p><a name="end"></a>&nbsp;</p>';
      print '<p class="small">';
      if ($prevPage > 0) print '<a class="button" href="index.php?kV=' . $prevVol . '&amp;kP=' . $prevPage . '#end">previous page</a>';
//      if ($prevPage > 0 && $nextPage > 0) print ' | ';
      if ($nextPage > 0) print '<a class="button" href="index.php?kV=' . $nextVol . '&amp;kP=' . $nextPage . '">next page</a>';
      print '</p>';

      writeSigla();
   }
}
else {
   // introduction
   include ("home_text.php");
}

?>
   </div>


<?php
// template
templateFooter();



function writeGlossRow() {
   global $resultsG, $rowG, $glossID, $searchStr, $priscianBooks;

   if (mysql_result($resultsG, $rowG, 'recordID') == $glossID) {
      print '<tr class="highlight">';
      $highlightAnchor = '<a name="hi"></a>';
   }
   else {
      print '<tr>';
      $highlightAnchor = '';
   }
   print '<td></td>';
   print '<td class="small" nowrap="nowrap" style="padding-left: 60px; ">' . $highlightAnchor . formatMsRef(mysql_result($resultsG, $rowG, 'ms_ref')) . '</td>';
   print '<td class="small" nowrap="nowrap">' . mysql_result($resultsG, $rowG, 'code') . '</td>';
   print '<td class="small" nowrap="nowrap">' . mysql_result($resultsG, $rowG, 'keil_ref') . '</td>';
   if (mysql_result($resultsG, $rowG, 'thesaurus_ref') != '') print '<td class="small" nowrap="nowrap">' . formatThesRef(mysql_result($resultsG, $rowG, 'thesaurus_ref'), mysql_result($resultsG, $rowG, 'thesaurus_page')) . '</td>';
   else print '<td></td>';
   print '<td class="small" nowrap="nowrap">' . formatBookRef(mysql_result($resultsG, $rowG, 'book')) . '</td>';
   print '<td class="small" nowrap="nowrap">' . formatTypes(mysql_result($resultsG, $rowG, 'types')) . '</td>';
   print '<td>' . formatGloss(mysql_result($resultsG, $rowG, 'text'), '', '', '', mysql_result($resultsG, $rowG, 'recordID'), mysql_result($resultsG, $rowG, 'translation'), mysql_result($resultsG, $rowG, 'has_analysis')) . '</td>';
   print '</tr>';     
}


?>
