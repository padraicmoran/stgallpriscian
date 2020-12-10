<?php

function templateHeader() {
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>St Gall Priscian Glosses</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://fonts.googleapis.com/css?family=Droid+Sans|Droid+Serif:400,400i|GFS+Neohellenic" rel="stylesheet">
<link rel="stylesheet" media="screen" href="includes/priscian.css" />
<link rel="stylesheet" media="print" href="includes/priscian_print.css" />
<script src="includes/jquery-3.2.1.min.js"></script>
<script src="includes/jquery.auto-complete.min.js"></script>
<script src="includes/scripts.js"></script>
<script src="includes/sorttable.js"></script>
</head>

<body>

<div id="wrapper">
   <div id="header" class="full">

      <div id="headerText">
         <h1><a href="/">St Gall Priscian Glosses</a> <span class="note">v2.0</span></h1>
         <div class="byline">Bernhard Bauer, Rijcklof Hofman, Pádraic Moran</div>
      </div>

      <ul class="nav">
      <li><a href="/">Home</a></li>
      <li><a href="/forms">Old Irish forms</a></li>
      <li><a href="/glosses">About the glosses</a></li>
      <li><a href="/resource">About the digital resource</a><li>
      </ul>

   </div>

<?php
}
function templateFooter() {
   ?>

	<div id="footer">
	Bernhard Bauer, Rijcklof Hofman, Pádraic Moran, <i>St Gall Priscian Glosses</i>, version 2.0 (2017) &lt;<?php print $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>&gt; [accessed <?php print date("j F Y") ?>]
	</div>

</div>



<!-- Start of StatCounter Code -->
<script type="text/javascript">
var sc_project=5311348; 
var sc_invisible=1; 
var sc_partition=59; 
var sc_click_stat=1; 
var sc_security="e6af1850"; 
</script>

<script type="text/javascript"
src="http://www.statcounter.com/counter/counter_xhtml.js"></script><noscript><div
class="statcounter"><a title="website statistics"
class="statcounter" href="http://www.statcounter.com/"><img
class="statcounter"
src="http://c.statcounter.com/5311348/0/e6af1850/1/"
alt="website statistics" /></a></div></noscript>
<!-- End of StatCounter Code -->

</body>
</html>

<?php
}

function writeSigla() {
   ?>

<div class="small footer">

CONSPECTUS SIGLORUM
<dl>
<dt>G</dt><dd><a target="_blank" href="http://www.e-codices.unifr.ch/en/csg/0904/1/large">Sankt Gallen, Stiftsbibliothek, <span class="sc">ms</span> 904</a> (a. 851)</dd>
<dt>L</dt><dd><a target="_blank" href="https://socrates.leidenuniv.nl/R/-?func=dbin-jump-full&object_id=673756">Leiden, Universiteitsbibliotheek, <span class="sc">ms</span> BPL 67</a> (a. 838)</dd>
<dt>K</dt><dd><a target="_blank" href="http://digital.blb-karlsruhe.de/blbhs/Handschriften/content/titleinfo/64199">Karlsruhe, Badische Landesbibliothek, Reichenauer Pergamenthandschriften, Augiensis <span class="sc">cxxxii</span></a> (s. <span class="sc">ix</span><sup>b</sup>)</dd>
<dt>E</dt><dd><a target="_blank" href="http://gallica.bnf.fr/ark:/12148/btv1b84790031/f9.image">Paris, Bibliothèque Nationale, <span class="sc">ms</span> Latin 10290</a> (s. <span class="sc">ix</span><sup>c–d</sup>)</dd>
<dt>M</dt><dd>Milano, Biblioteca Ambrosiana, Cod. A 138 sup. (s. <span class="sc">ix</span>)</dd>
<dt>T</dt><dd>Dublin, Trinity College, <span class="sc">ms</span> 229 (C.1.8) (s. <span class="sc">xi</span>)</dd>
<br/>
Lemmata: <br/>
<dt>[ ]</dt><dd>the enclosed part is in the preceding or following line in the <span class="sc">ms</span></dd>
<dt>+</dt><dd>the gloss is not in the hand of the usual glossator A (in all <span class="sc">mss</span>)</dd>
<dt>*</dt><dd>the gloss explains a corrupt lemma and/or sentence</dd>
<br/>
Glosses:<br/>
<dt><span class="et">7</span></dt><dd><i>et/ocus</i></dd>
<dt>.i.</dt><dd><i>id est/ed-ón</i></dd>
<dt>├</dt><dd>= <i>spiritus asper</i></dd>
<dt>&lt; &gt;</dt><dd>part of the gloss is illegible [note: &lt; &gt; sometimes also enclose later additions in the <span class="sc">ms</span>; these are being revised and distinguished with ( )]</dd>
<dt>[ ]</dt><dd>letters which should be deleted</dd>
<dt><span style="text-decoration: line-through; ">abc</span></dt><dd>letters marked as deleted (but legible) in the <span class="sc">ms</span></dd>
<!-- cf. 48b17 -->
</dl>

</div>

<div id="popup"><!--<p span="note" style="margin-top: 40px; ">[<a href="#" onclick="document.getElementById('popup').style.display = 'none';">close</a>]</p>--></div>

<?php
}

?>
