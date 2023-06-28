
<div class="row">
   <div class="col-6">

<h2>The St Gall Priscian glosses</h2>

<p>The Latin grammarian Priscian wrote his magisterial <i>Ars grammatica</i> at Constantinople around AD 527. His work is the most exhaustive compendium 
of information on Latin (and Greek) language and literature to survive from the ancient world.
</p>

<p>The <a href="https://www.stiftsbezirk.ch/en/stiftsbibliothek">Stiftsbibliothek</a> (Abbey Library) in St Gall in Switzerland contains a manuscript, 
numbered <a href="http://www.e-codices.unifr.ch/en/list/one/csg/0904">904</a>, that is a copy of Priscian
written by Irish scribes in AD 850–1, probably in Ireland.
It was brought to the Continent between 855 and 863, reaching St Gall sometime after 888. 
</p>   

<p>The manuscript also contains a commentary of over 9,400 interlinear and marginal glosses, as well as c. 3,000 symbol glosses. 
About one-third of the verbal glosses are written in Old Irish, providing one of our earliest sources for the Irish language.</p>

<p>This digital edition provides access to the text of the glosses alongside that of Priscian, and to additional resources inlcuding links to manuscript images 
 and linguistic information on the Old Irish glosses.
</p>

<p>The text of the glosses was originally transcribed by <a href="https://www.ru.nl/en/people/hofman-r">Rijcklof Hofman</a> in the early 1990s. 
<a href="http://www.pmoran.ie">Pádraic Moran</a> created the digital edition in 2010 and continues to maintain this site.
<a href="https://uni-graz.academia.edu/BernhardBauer">Bernhard Bauer</a> supplied translations and linguistic information for the Old Irish glosses in 2017.
(<a href="/resource">Read more…</a>)
</p>

<p>Browse the text and glosses by book:
</p>

<ul>
<?php
foreach ($priscianBooks As $key => $val) {
   print '<li>';
   if ($key == 'p') print '<a href="/index.php?bb=p">' . $val[0] . '</a>';
   else print '<a href="/index.php?bb=' . $key . '">' . $key . ': ' . $val[0] . '</a>';
   print '</li>';
} 
?>
</ul>

<p>(The manuscript breaks off in book 17. Book 18 is missing.)</p>

   </div>
   <div class="col-6">

<a href="http://www.e-codices.unifr.ch/en/csg/0904/25/medium"><img src="images/home_025.jpg" alt="St Gall, MS 904" class="img-fluid" /></a>

   </div>
</div>
