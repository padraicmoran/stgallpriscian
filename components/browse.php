<?php

// combined Priscian/gloss display
   
$sqlP = "Select book, keil_vol, keil_page, keil_line, text From priscian_lines Where keil_vol = $keilVol And keil_page = $keilPage ";
$sqlG = "Select recordID, keil_vol, keil_ref, keil_page, keil_line, code, ms_ref, book, types, text, thesaurus_ref, thesaurus_page, translation, has_analysis From glosses Where keil_vol = $keilVol And keil_page = $keilPage  Order By keil_page, keil_line";

$resultsP = mysqli_query($link, $sqlP);
$rowsP = mysqli_fetch_all($resultsP, MYSQLI_ASSOC);
$resultsG = mysqli_query($link, $sqlG);
$rowsG = mysqli_fetch_all($resultsG, MYSQLI_ASSOC);

if (mysqli_num_rows($resultsP) == 0) {
   print '<p>No text available for p. ' . $keilPage . '.</p>';
   print '<p>The page in Keil may comprise variant apparatus only. Try pages 
      <a href="index.php?kV=' . $keilVol . '&amp;kP=' . ($keilPage - 1) . '#hi">' . ($keilPage - 1) . '</a> or 
      <a href="index.php?kV=' . $keilVol . '&amp;kP=' . ($keilPage + 1) . '#hi">' . ($keilPage + 1) . '</a>?</p>';
}
else {
   // heading      
   print '<h1>Priscian, <i>Ars grammatica</i>: ';
   $book = $rowsP[0]['book'];
   if ($book == 0) print '<i>Praefatio</i></h2>';
   else print 'book ' . $book . ' (<i>' . $priscianBooks[$book][0] . '</i>)</h1>';
   print '<p>Text of Priscian from Hertz ed., <i>Grammatici Latini</i>, vol. ' . volConvert($keilVol) . ', p. ' . $keilPage . '
      (not a transcription from the St Gall manuscript).</p>';
   
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
   if ($prevPage > 0) print '<a class="btn btn-secondary" href="index.php?kV=' . $prevVol . '&amp;kP=' . $prevPage . '#end">previous page</a> ';
   if ($nextPage > 0) print '<a class="btn btn-secondary" href="index.php?kV=' . $nextVol . '&amp;kP=' . $nextPage . '">next page</a>';
   print '</p>';
   
   // advisory note
   print '<p>';  
   if ($glossID != '') print 'The gloss you selected is <a data-bs-toggle="tooltip" title="Click to go to highlighted text." href="#hi">highlighted</a> in yellow. ';
   if ($keilLine != '') print 'The line of Priscian you selected is <a data-bs-toggle="tooltip" title="Click to go to highlighted text." href="#hi">highlighted</a> in yellow. ';
//      if ($msPage != '') print "Glosses for manuscript p. $msPage begin below. ";
   print '</p>';
   
   // output main content
   $rowP = 0;
   $rowG = 0;
   print '<table class="table table-borderless table-responsive mt-5">';
   while ($rowP < mysqli_num_rows($resultsP)) {
      // line of Priscian
      print '<tr class="bg-light border-bottom">';
      $keilRef = formatKeilRef($rowsP[$rowP]['keil_vol'], $rowsP[$rowP]['keil_page'], $rowsP[$rowP]['keil_line']);
      $textP = $rowsP[$rowP]['text'];
      if ($keilLine == $rowsP[$rowP]['keil_line']) {
         print '<td class="small highlight" nowrap="nowrap">' . $keilRef . '</td>';
         print '<td colspan="7" class="fs-5 highlight"><a name="hi"></a>' . $textP . '</td>';
      }
      else {
         print '<td class="small" nowrap="nowrap">' . $keilRef . '</td>';
         print '<td colspan="7" class="fs-5">' . $textP . '</td>';
      }
      print '<tr>';

      // glosses for this line
      while (
         $rowG < mysqli_num_rows($resultsG) && (
            $rowsG[$rowG]['keil_vol'] == $rowsP[$rowP]['keil_vol'] &&
            $rowsG[$rowG]['keil_page'] == $rowsP[$rowP]['keil_page'] &&
            intval($rowsG[$rowG]['keil_line']) == $rowsP[$rowP]['keil_line']
            )
         ) {
         writeGlossRow();
         $rowG ++;
      }
      $rowP ++;
   }
   // catch any remaining glosses, not successfully linked
   while ($rowG < mysqli_num_rows($resultsG)) {
      writeGlossRow();
      $rowG ++;
   }
   print '</table>' . "\r\n";
         
   // recap paging
   print '<p><a name="end"></a>&nbsp;</p>';
   print '<p class="small">';
   if ($prevPage > 0) print '<a class="btn btn-secondary" href="index.php?kV=' . $prevVol . '&amp;kP=' . $prevPage . '#end">previous page</a> ';
   if ($nextPage > 0) print '<a class="btn btn-secondary" href="index.php?kV=' . $nextVol . '&amp;kP=' . $nextPage . '">next page</a>';
   print '</p>';

   writeSigla();
}


function writeGlossRow() {
   global $rowsG, $rowG, $glossID, $searchStr, $priscianBooks;

   if ($rowsG[$rowG]['recordID'] == $glossID) {
      print '<tr class="highlight">';
      $highlightAnchor = '<a name="hi"></a>';
   }
   else {
      print '<tr>';
      $highlightAnchor = '';
   }
   print '<td></td>';
   print '<td class="small" nowrap="nowrap" style="padding-left: 60px; ">' . $highlightAnchor . formatMsRef($rowsG[$rowG]['ms_ref']) . '</td>';
   print '<td class="small" nowrap="nowrap">' . $rowsG[$rowG]['code'] . '</td>';
   print '<td class="small" nowrap="nowrap">' . $rowsG[$rowG]['keil_ref'] . '</td>';
   if ($rowsG[$rowG]['thesaurus_ref'] != '') print '<td class="small" nowrap="nowrap">' . formatThesRef($rowsG[$rowG]['thesaurus_ref'], $rowsG[$rowG]['thesaurus_page']) . '</td>';
   else print '<td></td>';
   print '<td class="small" nowrap="nowrap">' . formatBookRef($rowsG[$rowG]['book']) . '</td>';
   print '<td class="small" nowrap="nowrap">' . formatTypes($rowsG[$rowG]['types']) . '</td>';
   print '<td>' . formatGloss($rowsG[$rowG]['text'], '', '', '', $rowsG[$rowG]['recordID'], $rowsG[$rowG]['translation'], $rowsG[$rowG]['has_analysis']) . '</td>';
   print '</tr>';     
}

?>