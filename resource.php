<?php
include ("includes/cms.php");

// template
templateHeader();
?>
   <div class="container my-5">
      <div class="col-lg-8">

<h2>About the digital resource</h2>

<p>This digital edition combines several resources in order to facilitate more efficient study of this collection of glosses:</p>

<ul>

<li>The transcription for all of the glosses was supplied by Rijcklof Hofman, who had already published the first half 
   of the corpus (with an introduction, translations and commentary) in <i>The Sankt Gall Priscian Commentary. Part 1</i> 
   (2 vols, Münster, 1996). </li>

<li>Bernhard Bauer supplied translations and morphological analysis for the Old Irish glosses, based on his 
   <a href="http://www.univie.ac.at/indogermanistik/priscian/" target="_blank">Database of the Old Irish Priscian 
      Glosses</a> (funded by the Austrian <a target="_blank" 
      href="http://pf.fwf.ac.at/en/research-in-practice/project-finder?search[what]=22859">FWF</a>).</li>

<li>The text of Priscian was made available thanks to the <a href="https://htldb.huma-num.fr/exist/apps/cgl/" 
target="_blank">Corpus Grammaticorum Latinorum</a> project (and Alessandro Garcea in particular). </li>

<li>The resource also provides images of the printed edition (with critical apparatus and apparatus of sources) by 
   Martin Hertz in Heinrich Keil (ed.), <i>Grammatici Latini</i> (6 vols, Leipzig, 1855–80), vols 2–3.</li>

<li>The edition links to manuscript images at <a href="http://www.e-codices.unifr.ch/en" target="_blank">e-Codices—Virtual
   Manuscript Library of Switzerland</a>.</li>

<li>It also provides images of the edition of Old Irish glosses (with translations and occasional notes) by Whitley 
   Stokes and John Strachan in <i>Thesaurus Palaeohibernicus</i> (2 vols, London, 1901–1910), 
   <a href="http://www.archive.org/details/thesauruspalaeoh02stokuoft" target="_blank">vol. 2</a>, pp. 49–224. </li>

</ul>

<h3 class="h4">Version history</h3>

<table class="table">
<tr>
<th>Version</th>
<th>Year</th>
<th>Notes</th>
</tr>

<tr>
<td>1.0</td>
<td>2010</td>
<td>Developed as part of a postdoctoral research project (2009–2011) funded by the Irish 
   Research Council for Humanities and Social Sciences (now <a href="http://www.research.ie/" target="_blank">Irish 
      Research Council</a>).</td>
</tr>

<tr>
<td>2.0</td>
<td>2018</td>
<td>Incorporating Bernhard Bauer's database of Old Irish glosses. Launched first in beta (testing) version in November 2017. 
   Replaced the original version on 13 May 2018.</td>
</tr>

<tr>
<td>2.1</td>
<td>2023</td>
<td>Released 28 June 2023. The front-end was adapted to <a href="https://getbootstrap.com/">Bootstrap</a> 5.2 for better 
   cross-platform compatibility. </td>
</tr>
</table>


</ul>

<p>Source code is available from <a href="https://github.com/padraicmoran/stgallpriscian/">GitHub</a>.</p>

<p><a href="http://www.pmoran.ie" target="_blank">Pádraic Moran</a> was responsible for all aspects of technical production. Please send any corrections or feedback to: 
<a href="&#109;&#097;&#105;&#108;&#116;&#111;&#058;padraic.moran&#64;universityofgalway&#46;ie">padraic.moran&#64;universityofgalway&#46;ie</a>
</p>

<!--
<h3>Work in progress</h3>

<p>As at April 2013:</p>

<ul>
<li>Links to <i>Thesaurus</i> images broken for about 10% (c. 400) of references.</li>
<li>Some category codes diverge from the master schema (these are marked [?] pending resolution).</li>
<li>On a few pages, the glosses do not all appear under the relevant lines of Priscian, but at the bottom of the page instead.</li>
<li>Information on different glossing hands is in the process of being encoded.</li>
<li>The sigla &lt; &gt; represent both text illegible and later additions; these are in the process of being distinguished.</li>
</ul>
-->
      </div>
   </div>


<?php
templateFooter();
?>
