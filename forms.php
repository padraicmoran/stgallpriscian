<?php
include ("includes/cms.php");

// update download_csv.php with any changes made here

$searchStr = initVars('s', '');
$glossID = initVars('id', '');

$aWordForm = initVars('aWf', '');
$aHeadword = initVars('aHw', '');
$aWordClass = initVars('aWc', '');
$aSubclass = initVars('aSc', '');
$aMorph = initVars('aMor', '');

$findChars = array('*', '·', '-');
$replaceChars = array('%', '', '');

// custom replacements
$aSubclass = preg_replace('/\bio\b/', 'i̯o', $aSubclass);
$aSubclass = preg_replace('/\bia\b/', 'i̯a', $aSubclass);

// lists
$aWordClassList = array('adjective', 'adverb', 'article', 'conjunction', 'noun', 'number', 'particle', 'preposition', 'pronoun', 'verb');

// error checking
$error = '';


templateHeader();
?>

<div class="container-fluid bg-light border-bottom mb-5 ">
   <div class="container px-4 py-4 ">

<!-- browse form -->

<h2 class="h3 border-bottom">Search for Old Irish forms</h2>

<form name="form01" id="form01" action="forms.php" method="get">

<div class="row">
    <div class="col-lg-2 py-1">
<label for="aWf">Word form:</label> 
   </div>
   <div class="col-lg-4 py-1">
<input class="form-control" type="text" id="aWf" name="aWf" value="<?php print $aWordForm ?>" placeholder=""/>
   </div>
</div>

<div class="row">
    <div class="col-lg-2 py-1">
<label for="aHw">Headword:</label> 
   </div>
   <div class="col-lg-4 py-1">
<input class="form-control" type="text" id="aHw" name="aHw" value="<?php print $aHeadword ?>" placeholder=""/>
   </div>
</div>

<div class="row">
    <div class="col-lg-2 py-1">
<label for="aWc">Word class:</label> 
   </div>
   <div class="col-lg-4 py-1">
<select class="form-select" id="aWc" name="aWc">
<option value="">(any)</option>
<?php
foreach ($aWordClassList As $val) {
   writeOption($val, $val, $aWordClass);
} 
?>
</select> 
   </div>
</div>

<div class="row">
    <div class="col-lg-2 py-1">
<label for="aSc">Sub-class:</label> 
   </div>
   <div class="col-lg-4 py-1">
<input class="form-control" type="text" id="aSc" name="aSc" value="<?php print $aSubclass ?>" placeholder="" />
   </div>
</div>

<div class="row">
    <div class="col-lg-2 py-1">
<label for="aMor">Morphology:</label> 
   </div>
   <div class="col-lg-4 py-1">
<input class="form-control" type="text" id="aMor" name="aMor" value="<?php print $aMorph ?>" placeholder="" />
   </div>
</div>

<div class="row">
    <div class="col-lg-2 py-1"></div>
   <div class="col-lg-4 py-1">
<input class="btn btn-secondary btn-sm" type="submit" value="Search" />
<input class="btn btn-secondary btn-sm" type="button" id="formClear" value="Clear" />
   </div>
</div>

</form>

<script src="components/forms_autocomplete.js"></script>

   </div>
</div>
<div class="container">

<?php

// searching
if ($error != '') print $error;

elseif ($aWordForm <> '' or $aHeadword <> '' or $aWordClass <> '' or $aSubclass <> '' or $aMorph <> '') {

   print '<h2>Search results</h2>';

      // search analysis data
   $sql = "Select g.ms_ref, g.code, g.thesaurus_ref, g.thesaurus_page, w.glossID, w.word_instance, w.headword, w.DIL_headword, w.wordclass, w.subclass, w.meaning, w.analysis, w.voice, w.rel 
      From word_instances w Left Join
         glosses g On w.glossID = g.recordID
      Where g.recordID > 0 ";    // dummy condition
   if ($aWordForm <> '') $sql .= "And w.word_instance_index Like '" . str_replace($findChars, $replaceChars, $aWordForm) . "' ";
   if ($aHeadword <> '') $sql .= "And w.headword Like '" . $aHeadword . "' ";
   if ($aWordClass <> '') $sql .= "And w.wordclass Like '" . $aWordClass . "%' ";
   if ($aSubclass <> '') $sql .= "And w.subclass Like '%" . $aSubclass . "%' ";
   if ($aMorph <> '') $sql .= "And w.analysis Like '%" . $aMorph . "%' ";
   $sql .= "Order By g.recordID ";

   $results = mysqli_query($link, $sql);
   if (mysqli_num_rows($results) == 0) {
      print '<p>No details found.</p><p>&nbsp;</p>';
      writeInstructions();
   }
   else {
      $rows = mysqli_fetch_all($results, MYSQLI_ASSOC);

      if (mysqli_num_rows($results) == 1) print '<p>One matching Old Irish form found. ';
      else print '<p>' . mysqli_num_rows($results) . ' matching Old Irish forms found. ';
      print ' (Click on a column heading to sort by that column.) </p>';

      print '<table id="myTable" class="table table-striped mt-5 sortable">';
      print '<tr>';
      print '<th onclick="sortTable(0);">MS</th>';
      print '<th>Gloss</th>';
      print '<th><i>Thes.</i></th>';
      print '<th onclick="sortTable(3);">Word form</th>';
      print '<th onclick="sortTable(4);">Headword</th>';
      print '<th onclick="sortTable(5);">Word class</th>';
      print '<th onclick="sortTable(6);">Sub-class</th>';
      print '<th onclick="sortTable(7);">Morph.</th>';
      print '<th>Meaning</th>';
      print '<th>Voice</th>';
      print '<th>Relative?</th>';
      print '</tr>';
         
      $row = 0;
      while ($row < mysqli_num_rows($results)) {
         print '<tr>';
         print '<td class="small" nowrap="nowrap">' . formatMsRef($rows[$row]['ms_ref']) . '</td>';
         print '<td class="small" nowrap="nowrap">' . $rows[$row]['code'] . '</td>';
         print '<td class="small" nowrap="nowrap">' . formatThesRef($rows[$row]['thesaurus_ref'], $rows[$row]['thesaurus_page']) . '</td>';
         print '<td nowrap="nowrap"><a data-bs-toggle="tooltip" title="Click to view full gloss." href="index.php?id=' . $rows[$row]['glossID'] . '&an=1">' . $rows[$row]['word_instance'] . '</a></td>';
         print '<td nowrap="nowrap"><a data-bs-toggle="tooltip" title="Click to see all attestations of this headword." href="forms.php?aHw=' . $rows[$row]['headword'] . '">' . $rows[$row]['headword'] . '</a>';
         if ($rows[$row]['DIL_headword'] != 'n/a') print ' <span class="note">[<a class="note" target="_blank" href="http://www.dil.ie/search?q=' . $rows[$row]['DIL_headword'] . '&search_in=headword">DIL</a>]</span>';
         print '</td>';
         print '<td class="small" nowrap="nowrap">' . $rows[$row]['wordclass'] . '</td>';
         print '<td class="small" nowrap="nowrap"><a href="forms.php?aSc=' . $rows[$row]['subclass'] . '">' . $rows[$row]['subclass'] . '</a></td>';
         print '<td class="small"><a href="forms.php?aMor=' . $rows[$row]['analysis'] . '">' . $rows[$row]['analysis'] . '</a></td>';
         print '<td class="small">' . $rows[$row]['meaning'] . '</td>';
         print '<td class="small" nowrap="nowrap">' . $rows[$row]['voice'] . '</td>';
         print '<td class="small" nowrap="nowrap">' . $rows[$row]['rel'] . '</td>';
         print '</tr>';
         $row ++;
      }
      print '</table>';
      print '<p>&nbsp;</p>';
      print '<p class="small">Download this table as a <a href="download_csv.php?' . $_SERVER['QUERY_STRING'] . '">CSV file</a> (Unicode/UTF-8 character set).</p>';

   }
}
else { 
   writeInstructions();
}

?>

</div>

<?php
templateFooter();



function writeInstructions() {
?>

<p>How to use the search form:</p>

<ul>
<li><b>Word form</b> represents the form actually found in the manuscript.
<br/><span class="small">Enter a precise form or use * as a wildcard, e.g. <i>dogniat, dogn*, *iat</i>. Diacritics, etc. unnecessary.<span></li>

<li><b>Headword</b> is the normalised lemma (usually corresponding to the headword in <a href="http://www.dil.ie" target="_blank">DIL</a>).
<br/><span class="small">Enter a complete form or use * as a wildcard, e.g. <i>dogni, dog*, *ni</i>.  Diacritics, etc. unnecessary.<span></li>

<li><b>Word class</b> corresponds to part of speech.
</li>

<li><b>Sub-class</b> refers to the headword's morphological class (e.g. <i>ā</i>-stem noun, BI verb).
<br/><span class="small">e.g. <i>m, o; f, a; 3pl</i>. Type something to see options.<span></li>

<li><b>Morphology</b> provides a description of the specific word form.
<br/><span class="small">e.g. <i>gen.sg., 3sg., pass., imperf.</i> Type something to see options.<span></li>
</ul>

<?php
}
?>
