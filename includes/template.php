<?php

// top part common to every page
function templateHeader() {
  global $version;
   ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>St Gall Priscian Glosses</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<!-- Custom CSS -->
<link href="https://fonts.googleapis.com/css?family=Droid+Sans|Droid+Serif:400,400i|GFS+Neohellenic" rel="stylesheet">
<link rel="stylesheet" media="screen" href="includes/priscian.css" />

<!-- scripts --> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="includes/jquery-3.2.1.min.js"></script>
<script src="includes/jquery.auto-complete.min.js"></script>
<script src="includes/sorttable.js"></script>

<script type="text/javascript">
// sroll up on load; this brings anchored text into view (from behind the sticky navbar)
window.addEventListener('load', function() {
	window.scrollBy(0, -500);
});

</script>
</head>

<body>
<nav class="navbar navbar-expand-lg px-4 py-2 border-bottom border-secondary shadow sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">St Gall Priscian Glosses</a>
    <span class="small">v<?php print $version; ?></span>
    

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ps-5 me-auto mb-2 mb-lg-0">
        <li class="nav-item px-2"><a class="nav-link" href="/">Home</a></li>
        <li class="nav-item px-2"><a class="nav-link" href="/forms">Old Irish forms</a></li>
        <li class="nav-item px-2"><a class="nav-link" href="/glosses">About the glosses</a></li>
        <li class="nav-item px-2"><a class="nav-link" href="/resource">About the digital resource</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php
}

// bottom part common to every page
function templateFooter() {
  global $version, $versionYear;
   ?>

<div class="container-fluid bg-secondary mt-5 p-5 text-light">
Rijcklof Hofman, Pádraic Moran, Bernhard Bauer, <i>St Gall Priscian Glosses</i>, version <?php print $version . ' (' . $versionYear . ') '; ?> &lt;http://<?php print $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>&gt; [accessed <?php print date("j F Y") ?>]
</div>

<!-- scripts -->

<!-- script for tooltips -->
<script language="JavaScript" type="text/javascript">
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>

<!-- Start of StatCounter Code -->
<script type="text/javascript">
var sc_project=5311348; 
var sc_invisible=1; 
var sc_partition=59; 
var sc_click_stat=1; 
var sc_security="e6af1850"; 
</script>

<!--
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


// search forms
function templateSearchForm() {
  global $priscianBooks, $browseBook, $keilVol, $keilPage, $msPage, $searchStr, $searchIn, $searchType, $glossTypes, $searchBook;
?>

<div class="row bg-light px-4 py-4 border-bottom mb-5 ">
  <div class="col-lg-5 px-4 border-end">

<!-- browse options -->
<h2 class="h3 border-bottom">Browse Priscian</h2>


<!-- go to book -->
<form action="index.php" method="get" id="goToBook">
  <div class="row">
    <div class="col-lg-4 py-1">
<label class="form-label" class="form-label" for="bb">Go to book:</label>
    </div>
    <div class="col-lg-8 py-1">

<select class="form-select" id="bb" name="bb" onchange="document.getElementById('goToBook').submit(); ">
<option value=""></option>
<?php
foreach ($priscianBooks As $key => $val) {
   if ($key == 0) writeOption($val[0], $key, $browseBook);
   else writeOption($key . ': ' . $val[0], $key, $browseBook);
} 
?>
</select> 
    </div>
  </div>
</form>

<!-- go to Keil page -->
<form action="index.php" method="get" id="goToBook">
  <div class="row">
    <div class="col-lg-4 py-1">
<label class="form-label" for="kP">Or to Hertz, ed.:</label>
    </div>
    <div class="col-lg-8 py-1">
      
<i>GL</i> 
<select class="form-select d-inline-flex" style="width: 70px;" name="kV">
<?php
writeOption('II ', '2', $keilVol); 
writeOption('III ', '3', $keilVol);
?>
</select>
page 
<input class="form-control d-inline-flex" type="text" id="kP" name="kP" value="<?php print $keilPage ?>" style="width: 60px; "/>
<input class="btn btn-secondary btn-sm" type="submit" value="go" />
    </div>
  </div>
</form>

<!-- go to MS page -->
<form action="index.php" method="get" id="goToBook">
    <div class="row">
    <div class="col-lg-4 py-1">
<label class="form-label" for="ms">Or to MS page:</label>
    </div>
    <div class="col-lg-8 py-1">
<input class="form-control d-inline-flex" type="text" id="ms" name="ms" value="<?php print $msPage ?>"  style="width: 60px; "/>
<input class="btn btn-secondary btn-sm" type="submit" value="go" />
(e.g. 10, 10b; range 1–249)
    </div>
  </div>
</form>

  </div>
  <div class="col-lg-5 px-4">

<!-- search options -->
<h2 class="h3 border-bottom">Search glosses</h2>

<form action="index.php" method="get">

<!-- search for text -->
  <div class="row">
    <div class="col-lg-4 py-1">
<label class="form-label" for="s">Search for text:</label> 
    </div>
    <div class="col-lg-8 py-1">
<input class="form-control" class="search" type="text" id="s" name="s" value="<?php print $searchStr ?>" />

Search in:
<input class="form-check-input" type="radio" id="si_gl" name="si" value="gl"<?php if ($searchIn == 'gl') print ' checked="checked"'; ?> />
<label class="form-label" class="option" for="si_gl">glosses/lemmata</label>
<input class="form-check-input" type="radio" id="si_pr" name="si" value="pr"<?php if ($searchIn == 'pr') print ' checked="checked"'; ?> />
<label class="form-label" class="option" for="si_pr">Priscian</label>
    </div>
  </div>


<!-- search Thes. 
<form action="index.php" method="get">
<label class="form-label" for="thes">Search by <i>Thes.</i> ref.</label>
<input class="form-control" type="text" id="thes" name="thes" style="width: 35px; "/>
<input type="submit" value="go"/>
<span class="note">(e.g. 14a6)</span>
-->

<!-- restrict by type -->
  <div class="row">
    <div class="col-lg-4 py-1">
<label class="form-label" for="t">Within gloss type:</label>
    </div>
    <div class="col-lg-8 py-1">

<select class="form-select" id="t" name="t">
<option value="">(any)</option>
<?php
foreach ($glossTypes as $code => $description) {
   writeOption($code . ': ' . $description, $code, $searchType);
} 
?>
</select>
    </div>
  </div>

<!-- restrict to book -->
    <div class="row">
    <div class="col-lg-4 py-1">
<label class="form-label" for="b">In book:</label>
    </div>
    <div class="col-lg-8 py-1">
<select class="form-select" id="b" name="b">
<option value="">(all)</option>
<?php
foreach ($priscianBooks As $key => $val) {
   if ($key == 0) writeOption($val[0], $key, $searchBook);
   else writeOption($key . ': ' . $val[0], $key, $searchBook);
} 
?>
</select> 
    </div>
  </div>

  <div class="row">
    <div class="col-lg-4 py-1"></div>
    <div class="col-lg-8 py-1">
<input class="btn btn-secondary btn-sm" type="submit" value="go" />
    </div>
  </div>

<!--
<span class="note">(Or search for <a href="forms.php">Old Irish forms</a>.)</span>
-->
</form>

  </div>
</div>

<?php
}


// footer for gloss content pages
function writeSigla() {
   ?>

<div class="mt-5 border-top pt-3 small text-secondary">

<h3 class="h4">Conspectus siglorum</h3>
<h4 class="h5">Manuscripts</h3>
<dl class="row">
<dt class="col-1">G</dt><dd class="col-11"><a target="_blank" href="http://www.e-codices.unifr.ch/en/csg/0904/1/large">Sankt Gallen, Stiftsbibliothek, MS 904</a> (a. 851)</dd>
<dt class="col-1">L</dt><dd class="col-11"><a target="_blank" href="http://hdl.handle.net/1887.1/item:1603880">Leiden, Universiteitsbibliotheek, MS BPL 67</a> (a. 838)</dd>
<dt class="col-1">K</dt><dd class="col-11"><a target="_blank" href="https://nbn-resolving.de/urn:nbn:de:bsz:31-7326">Karlsruhe, Badische Landesbibliothek, Reichenauer Pergamenthandschriften, Augiensis CXXXII</a> (s. IX<sup>b</sup>)</dd>
<dt class="col-1">E</dt><dd class="col-11"><a target="_blank" href="http://gallica.bnf.fr/ark:/12148/btv1b84790031/f9.image">Paris, Bibliothèque Nationale, MS Latin 10290</a> (s. IX<sup>c–d</sup>)</dd>
<dt class="col-1">M</dt><dd class="col-11">Milano, Biblioteca Ambrosiana, Cod. A 138 sup. (s. IX)</dd>
<dt class="col-1">T</dt><dd class="col-11">Dublin, Trinity College, MS 229 (C.1.8) (s. XI)</dd>
</dl>

<h4 class="h5">Lemmata</h3>
<dl class="row">
<dt class="col-1">[ ]</dt><dd class="col-11">the enclosed part is in the preceding or following line in the MS</dd>
<dt class="col-1">+</dt><dd class="col-11">the gloss is not in the hand of the usual glossator A (in all MSS)</dd>
<dt class="col-1">*</dt><dd class="col-11">the gloss explains a corrupt lemma and/or sentence</dd>
</dl>

<h4 class="h5">Glosses</h3>
<dl class="row">
<dt class="col-1"><span class="et">7</span></dt><dd class="col-11"><i>et/ocus</i></dd>
<dt class="col-1">.i.</dt><dd class="col-11"><i>id est/ed-ón</i></dd>
<dt class="col-1">├</dt><dd class="col-11">= <i>spiritus asper</i></dd>
<dt class="col-1">&lt; &gt;</dt><dd class="col-11">part of the gloss is illegible [note: &lt; &gt; sometimes also enclose later additions in the MS; these are being revised and distinguished with ( )]</dd>
<dt class="col-1">[ ]</dt><dd class="col-11">letters which should be deleted</dd>
<dt class="col-1"><span style="text-decoration: line-through; ">abc</span></dt><dd class="col-11">letters marked as deleted (but legible) in the MS</dd>
<!-- cf. 48b17 -->
</dl>

</div>

<?php
}

?>