<?php

print '<h2>Gloss analysis</h2>';

// search glosses and lemmata only
$sql = "Select recordID, book, code, ms_ref, keil_vol, keil_page, keil_line, types, text, thesaurus_ref, thesaurus_page, translation, has_analysis
   From glosses Where recordID = " . $glossID;

$results = mysqli_query($link, $sql);
if (mysqli_num_rows($results) == 0) print '<p>Gloss not found.</p>';
else {
   $rows = mysqli_fetch_all($results, MYSQLI_ASSOC);
   print '<table class="table table-responsive mt-4">';
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
   print '<td class="small" nowrap="nowrap">' . formatMsRef($rows[$row]['ms_ref']) . '</td>';
   print '<td class="small" nowrap="nowrap">' . $rows[$row]['code'] . '</td>';
   print '<td class="small" nowrap="nowrap">' . formatKeilRef($rows[$row]['keil_vol'], $rows[$row]['keil_page'], $rows[$row]['keil_line'])  . '</td>';
   if ($rows[$row]['thesaurus_ref'] != '') print '<td class="small" nowrap="nowrap">' . formatThesRef($rows[$row]['thesaurus_ref'], $rows[$row]['thesaurus_page']) . '</td>';
   else print '<td></td>';
   print '<td class="small" nowrap="nowrap">' . formatBookRef($rows[$row]['book']) . '</td>';
   print '<td class="small" nowrap="nowrap" style="padding-right: 20px; ">' . formatTypes($rows[$row]['types']) . '</td>';
   print '<td>' . formatGloss($rows[$row]['text'], $searchStr, $rows[$row]['keil_vol'], $rows[$row]['keil_page'], $rows[$row]['recordID'], $rows[$row]['translation'], 0) . '</td>';
   print '</tr>';      
   print '</table>';

}

// get analysis details
$sql = "Select word_instance, headword, DIL_headword, wordclass, subclass, meaning, analysis, voice, rel From word_instances 
   Where glossID = " . $glossID . " 
   Order By old_recordID";

$results = mysqli_query($link, $sql);
if (mysqli_num_rows($results) == 0) print '<p>No details found.</p>';
else {
   $rows = mysqli_fetch_all($results, MYSQLI_ASSOC);
   print '<h3 class="h4 mt-5">Old Irish elements</h3>';

   print '<table class="table table-sm table-responsive mt-4">';
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
   while ($row < mysqli_num_rows($results)) {
      if ($row % 2 == 1) print '<tr>';
      else print '<tr style="background-color: #fcfcff; ">';
      print '<td nowrap="nowrap">' . $rows[$row]['word_instance'] . '</td>';
      print '<td nowrap="nowrap"><a data-bs-toggle="tooltip" title="Click to see all attestations of this headword." href="forms.php?aHw=' . $rows[$row]['headword'] . '">' . $rows[$row]['headword'] . '</a>';
      if ($rows[$row]['DIL_headword'] != 'n/a') print ' <span class="text-secondary small">[<a target="_blank" href="http://www.dil.ie/search?q=' . $rows[$row]['DIL_headword'] . '&search_in=headword">DIL</a>]</span>';
      print '</td>';
      print '<td class="small" nowrap="nowrap">' . $rows[$row]['wordclass'] . '</td>';
      print '<td class="small" nowrap="nowrap">' . $rows[$row]['subclass'] . '</td>';
      print '<td class="small" nowrap="nowrap">' . $rows[$row]['analysis'] . '</td>';
      print '<td class="small">' . $rows[$row]['meaning'] . '</td>';
      print '<td class="small" nowrap="nowrap">' . $rows[$row]['voice'] . '</td>';
      print '<td class="small" nowrap="nowrap">' . $rows[$row]['rel'] . '</td>';
      print '</tr>';
      $row ++;
   }

   print '</table>';
}

?>