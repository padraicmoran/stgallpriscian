
<div class="home">

<a href="http://www.e-codices.unifr.ch/en/csg/0904/25/medium" target="_blank"><img src="images/home_025.jpg" alt="" style="float: right; margin-top: 1.5em; margin-right: -500px; width: 450px; height: 470px; border: solid 1px;  "/></a>

<h2>The St Gall Priscian glosses</h2>

<p>The St Gall Priscian is a manuscript of 240 pages containing Priscian's encyclopaedic Latin grammar, completed at Constantinople c. <span class="sc">ad</span> 527. The text was known in Ireland possibly already in the following century. The manuscript now catalogued as <a href="http://www.e-codices.unifr.ch/en/list/one/csg/0904" target="_blank"><span class="sc">ms</span> 904</a> in the St Gall Stiftsbibliothek was written by Irish scribes in 850–1, probably in Ireland, from where it was brought to the Continent between 855 and 863, reaching St Gall sometime after 888. The manuscript contains over 9,400 interlinear and marginal glosses, in addition to c. 3,000 symbol glosses (symbols to aid reading). About one-third of the verbal glosses are written in Old Irish, and these constitute one of our earliest sources for the language.</p>

<p>This digital edition provides access to the text of the glosses and that of Priscian, along with links to images of the manuscript and previous editions, and linguistic information on the Old Irish glosses.
</p>

<p>Browse the text and glosses by book:
</p>

<ul>
<?php
foreach ($priscianBooks As $key => $val) {
   print '<li>';
   if ($key == 0) print '<a href="/index.php?bb=p">' . $val[0] . '</a>';
   else print '<a href="/index.php?bb=' . $key . '">' . $key . ': ' . $val[0] . '</a>';
   print '</li>';
} 
?>
</ul>

<p>(The manuscript breaks off in book 17. Book 18 is missing.)</p>


</div>
