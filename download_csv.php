<?php
include ("includes/cms.php");

// query copied from forms.php

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
$aSubclass = str_replace('io', 'i̯o', $aSubclass);
$aSubclass = str_replace('ia', 'i̯a', $aSubclass);




// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=OIr_forms_' . date('Y-m-d_H-i') . '.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('MS', 'Gloss', 'Thes.', 'Word form', 'Headword', 'Sub-class', 'Morph.', 'Meaning', 'Voice', 'Relative?'));


if ($aWordForm <> '' or $aHeadword <> '' or $aWordClass <> '' or $aSubclass <> '' or $aMorph <> '' /*or $aHeadword <> '' or $aHeadword <> '' or */) {

   // search analysis data
   $sql = "Select g.ms_ref, g.code, g.thesaurus_ref, g.thesaurus_page, w.glossID, w.word_instance, w.headword, w.DIL_headword, w.wordclass, w.subclass, w.meaning, w.analysis, w.voice, w.rel 
      From word_instances w Left Join
         glosses g On w.glossID = g.recordID
      Where g.recordID > 0 ";    // dummy condition
   if ($aWordForm <> '') $sql .= "And w.word_instance_index Like '" . str_replace($findChars, $replaceChars, $aWordForm) . "' ";
   if ($aHeadword <> '') $sql .= "And w.headword_index Like '" . str_replace($findChars, $replaceChars, $aHeadword) . "' ";
   if ($aWordClass <> '') $sql .= "And w.wordclass Like '" . $aWordClass . "%' ";
   if ($aSubclass <> '') $sql .= "And w.subclass Like '%" . $aSubclass . "%' ";
   if ($aMorph <> '') $sql .= "And w.analysis Like '%" . $aMorph . "%' ";
   $sql .= "Order By g.recordID ";

   $results = db_query($sql);
   if (mysql_num_rows($results) > 0) {
      $row = 0;
      while ($row < mysql_num_rows($results)) {
         fputcsv($output, array(
         mysql_result($results, $row, 'g.ms_ref'),
         mysql_result($results, $row, 'g.code'), 
         mysql_result($results, $row, 'g.thesaurus_ref'),
         mysql_result($results, $row, 'w.word_instance'), 
         mysql_result($results, $row, 'w.headword'), 
         mysql_result($results, $row, 'w.wordclass'), 
         mysql_result($results, $row, 'w.subclass'), 
         mysql_result($results, $row, 'w.analysis'), 
         mysql_result($results, $row, 'w.meaning'), 
         mysql_result($results, $row, 'w.voice'), 
         mysql_result($results, $row, 'w.rel') 
         ));
         $row ++;
      }
   }
}

?>
