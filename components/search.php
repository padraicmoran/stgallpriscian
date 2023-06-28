<?php

// display search results

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
   if ($searchType != '') $sql .= "And types Like '%+$searchType%+%' ";
//      print "<pre>$sql</pre>";
      
      
   $results = mysqli_query($link, $sql);
   print '<h2>Search results</h2>';
   if (mysqli_num_rows($results) == 0) print '<p>No matches found.</p>';
   else {
      $rows = mysqli_fetch_all($results, MYSQLI_ASSOC);
      if (mysqli_num_rows($results) == 1) print '<p>One match found. ';
      else print '<p>' .   mysqli_num_rows($results) . ' matches found. ';
      print 'Point to any link below for more information. '; 
      print '</p>';
      
      print '<table class="table table-responsive mt-5">';
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
      while ($row < mysqli_num_rows($results)) {
         print '<tr>';
         print '<td class="small" nowrap="nowrap">' . formatMsRef($rows[$row]['ms_ref']) . '</td>';
         print '<td class="small" nowrap="nowrap">' . $rows[$row]['code'] . '</td>';
         print '<td class="small" nowrap="nowrap">' . formatKeilRef($rows[$row]['keil_vol'], $rows[$row]['keil_page'], $rows[$row]['keil_line'])  . '</td>';
         print '<td class="small" nowrap="nowrap">' . formatThesRef($rows[$row]['thesaurus_ref'], $rows[$row]['thesaurus_page']) . '</td>';
         print '<td class="small" nowrap="nowrap">' . formatBookRef($rows[$row]['book']) . '</td>';
         print '<td class="small" nowrap="nowrap" style="padding-right: 20px; ">' . formatTypes($rows[$row]['types']) . '</td>';
         print '<td class="glosses">' . formatGloss($rows[$row]['text'], $searchStr, $rows[$row]['keil_vol'], $rows[$row]['keil_page'], $rows[$row]['recordID'], $rows[$row]['translation'], $rows[$row]['has_analysis']) . '</td>';
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
   if ($searchBook <> '') $sqlP .= "And book = " . $searchBook . "";
   $resultsP = mysqli_query($link, $sqlP);

   if (mysqli_num_rows($resultsP) == 0) print '<p>No matches found.</p>';
   else {
      $rowsP = mysqli_fetch_all($resultsP, MYSQLI_ASSOC);

      // heading      
      if (mysqli_num_rows($resultsP) == 1) print '<p>One match found. ';
      else print '<p>' . mysqli_num_rows($resultsP) . ' matches found. ';
      print '</p>';
      
      $rowP = 0;
      print '<table class="table table-responsive mt-5">';
      while ($rowP < mysqli_num_rows($resultsP)) {
         // line of Priscian
         print '<tr class="bg-light">';
         print '<td nowrap="nowrap"><a data-bs-toggle="tooltip" title="Vol., page and line of Hertz\'s edition in Keil, Grammatici Latini. Click to go to context in Priscian. " href="index.php?kV=' . $rowsP[$rowP]['keil_vol'] . '&amp;kP=' . $rowsP[$rowP]['keil_page'] . '&amp;kL=' . $rowsP[$rowP]['keil_line'] . '#hi">' . volConvert($rowsP[$rowP]['keil_vol']) . ' ' . $rowsP[$rowP]['keil_page'] . ',' . $rowsP[$rowP]['keil_line'] . '</td>';
         print '<td class="fs-5">… ' . $rowsP[$rowP]['text'] . ' …</td>';
         print '</tr>';
         $rowP ++;
      }
      print '</table>' . "\r\n";

   }
}

?>