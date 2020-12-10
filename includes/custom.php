<?php

//phpinfo();
if ($_SERVER['HTTP_HOST'] == 'beta.stgallpriscian.ie') {
	header('Location: http://www.stgallpriscian.ie' . $_SERVER['REQUEST_URI']);
	die();
}

if ($_SERVER['HTTP_HOST'] == 'localhost') $testing = true;
else $testing = false;

// load in type codes

$priscianBooks = array(
   'p' => array('Praefatio', 2, 1), 
   1 => array('De uoce, de littera', 2, 5),
   2 => array('De syllaba, de dictione, de oratione, de nomine, etc.', 2, 44), 
   3 => array('De comparatione, de superlativo, de diminutivo', 2, 83), 
   4 => array('De denominatiuis', 2, 117), 
   5 => array('De generibus, de numeris, de figuris, de casu', 2, 141),
   6 => array('De nominatiuo et genetiuo casu', 2, 194), 
   7 => array('De ceteris casibus', 2, 283),
   8 => array('De uerbo', 2, 369),
   9 => array('De generali uerbi declinatione', 2, 452), 
   10 => array('De praeterito perfecto tertiae coniugationis', 2, 494), 
   11 => array('De participio', 2, 548),
   12 => array('De pronomine', 2, 577),
   13 => array('De casibus [pronominum]', 3, 1),
   14 => array('De praepositione', 3, 24), 
   15 => array('De aduerbio, de interiectione', 3, 60),
   16 => array('De coniunctione', 3, 93), 
   17 => array('De constructione', 3, 106), 
   18 => array('De constructione', 3, 210)
   );

$glossTypesSummary = array(
   '1' => 'prosody', 
   '2' => 'lexical', 
   '3' => 'morphology', 
   '4' => 'syntax', 
   '5' => 'explanatory' 
   );
$glossTypes = array(
   '1' => '[Glosses on prosody]', 
   '11' => 'Length mark indicating syllable length in poetic quotations',  
   '12' => 'Glosses on the length of syllables', 
   '13' => 'Elaborate comment on metre', 
   '2' => '[Lexical glosses]', 
   '211' => 'Trans. into Old Irish', 
   '212' => 'Synonyms', 
   '213' => 'Negated antonyms', 
   '214' => 'Hyponym defined by a hypernym with differentia specifica', 
   '215' => 'Definition given by an entire sentence', 
   '221' => 'Greek glosses and glosses over Greek words', 
   '222' => 'Use of different prefixes', 
   '223' => 'Adjectives glossed with a noun in the genitive (or another case)', 
   '23' => 'Differentiae', 
   '24' => 'Further derivations in a gloss', 
   '25' => 'Glosses showing the original form of the word', 
   '3' => '[Glosses on morphology (grammatical glosses))]', 
   '31' => 'Grammatical glosses on the noun', 
   '311' => 'Glosses on case forms', 
   '3111' => 'Glosses on case: nominative', 
   '3112' => 'Glosses on case: vocative', 
   '3113' => 'Glosses on case: genitive', 
   '3114' => 'Glosses on case: dative', 
   '3115' => 'Glosses on case: accusative', 
   '3116' => 'Glosses on case: ablative', 
   '312' => 'Glosses on number', 
   '313' => 'Glosses on gender and various other morphological points', 
   '32' => 'Grammatical glosses on the pronoun', 
   '321' => 'Glosses on pronouns in general', 
   '322' => 'Glosses on relative pronouns', 
   '3221' => 'Rel. pronoun glossed by its antecedent', 
   '3222' => 'Rel. pronoun glossed by the gloss above the antecedent', 
   '3223' => 'Rel. pronoun glossed by an interpretation or lexical equivalent of the antecedent', 
   '3224' => 'Rel. pronoun without identifiable antecedent', 
   '323' => 'Other pronouns', 
   '3231' => 'Interchangeability of demonstrative pronouns or Old Irish glosses solving ambiguity', 
   '3232' => 'Glosses over pronouns referring to a concept in the preceding/following line/paragraph', 
   '3233' => 'Glosses which differ in case from the pronoun and can substitute it', 
   '33' => 'Grammatical glosses on the verb and the participle', 
   '331' => 'General glosses on morphology', 
   '332' => 'Morphological glosses on tense', 
   '333' => 'Morphological glosses on mood', 
   '334' => 'Morphological glosses on the participle and the gerund', 
   '34' => 'Grammatical glosses on the adverb', 
   '35' => 'Grammatical glosses on the conjunction', 
   '36' => 'Grammatical glosses on the preposition', 
   '37' => 'Grammatical glosses on the interjection', 
   '4' => '[Glosses on syntax]', 
   '41' => 'Syntactical glosses using symbols', 
   '4111' => 'Symbols correlating adjectives/prepositions with substantives', 
   '4112' => 'Symbols correlating a genitive in apposition with a substantive', 
   '4121' => 'Symbols correlating a rel. pronoun with its antecedent', 
   '4122' => 'Symbols correlating other pronouns with nouns', 
   '4123' => 'Symbols correlating verbal forms, verbs—subjects, etc.', 
   '413' => 'Glosses establishing word order with the help of different symbols', 
   '4141' => 'Symbols clarifying the skeletal structure of a sentence', 
   '4142' => 'Symbols correlating two sentences', 
   '4143' => 'Symbols supplying word(s) ommited by the author', 
   '4144' => 'Symbols correlating theoretical explanation with examples', 
   '4145' => 'Various other uses', 
   '42' => 'Syntactical glosses using words', 
   '421' => 'Glosses identifying a speaker or an example', 
   '422' => 'Suppletive glosses', 
   '4221' => 'Suppletive nouns/pronouns in the nominative', 
   '4222' => 'Suppletive nouns/pronouns in the genitive', 
   '4223' => 'Suppletive nouns/pronouns in the dative', 
   '4224' => 'Suppletive nouns/pronouns in the accusative', 
   '4225' => 'Suppletive nouns/pronouns in the vocative', 
   '4226' => 'Suppletive adverbial adjuncts', 
   '4227' => 'Suppletive adjectives and adjectival clauses', 
   '4228' => 'Suppletive verbs and short clauses', 
   '4229' => 'Suppletive conjunctions or prepositions', 
   '423' => 'Glosses modifying adjectives', 
   '424' => '<i>adit</i> glosses', 
   '5' => '[Explanatory glosses]', 
   '51' => 'Glosses decoding figures of speech', 
   '52' => 'Glosses summarizing content', 
   '53' => 'Cross-references', 
   '541' => '(Elaborate) comment on the main text', 
   '542' => '<i>quia</i> glosses', 
   '543' => 'Glosses elucidating the main text', 
   '55' => 'Etymological glosses', 
   '56' => 'Encyclopedic glosses', 
   '561' => 'Geographical names', 
   '562' => 'Unusual objects', 
   '563' => 'Proper names', 
   '57' => 'Source glosses', 
   '571' => 'Grammatical sources identified/Priscian confronted with other sources', 
   '572' => 'Glosses revealing an acquaintance with Latin authors or Roman mythology', 
   '58' => 'Glosses giving variant readings', 
   '59' => 'Glosses giving information about the socio-historical context' 
   );


function volConvert($vol) {
   if ($vol == 2) return 'II';
   else if ($vol == 3) return 'III';
   else return $vol;
}

function formatMsRef($txt) {
   global $testing;
   $pgName = '';
   if (preg_match('/([0-9]{1,3})([ab, ])*/', $txt, $matches)) {
      $pgName = $matches[1];
      if ($testing) return '<a class="tooltip" title="Manuscript page, column, line.<br/>Click to view image [local]." href="http://localhost/sg904images/' . str_pad($matches[1], 3, "0", STR_PAD_LEFT) . '.jpg" target="_blank">' . $txt . '</a>';
      else return '<a class="tooltip" title="Manuscript page, column, line.<br/>Click to view image." href="http://www.e-codices.unifr.ch/en/csg/0904/' . $matches[1] . '/large" target="_blank">' . $txt . '</a>';
   }
   else return $txt;
}

function formatThesRef($thesRef, $thesPage) {
   if ($thesRef <> '') {
      return '<a class="tooltip" title="Reference in <i>Thesaurus Palaeohibernicus</i>, vol. 2.<br/>Click to open a scanned image." href="images/thesaurus/Thes_vol2_' . str_pad($thesPage, 3, "0", STR_PAD_LEFT) . '.jpg" target="_blank">' . preg_replace('/(^|a|b|\s)0{0,2}/', '$1', $thesRef) . '</td>';
   }
   else return '';
}


function formatBookRef($n) {
   global $priscianBooks;
   if ($n == 0) {
      $txt = 'Praefatio';
      $title = 'Click to show all glosses from this section.';
   }
   else {
      $txt = 'book ' . $n;
      $title = 'Priscian, book ' . $n . ': ' . $priscianBooks[$n][0] . '.<br/>Click to show all glosses from this book.';
   }
   return '<a href="index.php?b=' . $n . '" class="tooltip" title="' . $title . '">' . $txt . '</a>';
} 
function formatKeilRef($kV, $kP, $kL) {
   if ($kP == '') return '';
   else return '<a class="tooltip" title="Vol., page and line of Hertz\'s edition in Keil, <i>Grammatici Latini</i>. <br/>Click to open scanned image (with variant apparatus)." href="/images/keil/Keil_v' . $kV . '_' . str_pad($kP, 3, "0", STR_PAD_LEFT) . '.gif" target="_blank">' . volConvert($kV) . ' ' . $kP . ',' . $kL . '</a>';
}
function formatTypes($strTypes) {
   global $glossTypes, $glossTypesSummary;
   $tmp = '';
   $splitTypes = explode("+", $strTypes);
   foreach ($splitTypes as $thisType) {
      if ($thisType != '') {
         if (isset($glossTypes[$thisType])) $tmp .= '<a href="index.php?t=' . $thisType . '" class="tooltip" title="Gloss type ' . $thisType . ' (' . $glossTypesSummary[substr($thisType, 0, 1)] . '): ' . $glossTypes[$thisType] . '. <br/>Click to list all glosses of this type.">' . $thisType . '</a> ';
         else $tmp .= '' . $thisType . '[?] ';
      }
   } 
   return $tmp;
}
function formatGloss($txt, $highlight, $kV, $kP, $id, $trans, $hasA) {
	$highlight = preg_quote($highlight, '/');

   if ($highlight != '') $txt = preg_replace('/' . $highlight . '/', '<span class="highlight">$0</span>', $txt);
   $txt = preg_replace('/ &gt; (\([0-9a-z,=\s\'"^\ap\.)]*\))/', ' &gt; <span class="construeRef">$1</span>', $txt);
   $txt = preg_replace('/\(ibid\.\)/', '<span class="construeRef">$0</span>', $txt);
   $txt = str_replace(' &gt; <span', ' <span class="construeConnector">→</span> <span', $txt);
   $txt = preg_replace('/\{[^\}]*\}/', '<span class="note">$0</span>', $txt);
   $txt = preg_replace('/ 7 /', ' ⁊ ', $txt);
   $txt = preg_replace('/<g>/', ' <span class="construeSymbol">', $txt);
   $txt = preg_replace('/<\/g>/', '</span>', $txt);
   $txt = preg_replace('/<ex>/', '<i>', $txt);
   $txt = preg_replace('/<\/ex>/', '</i>', $txt);
   $txt = preg_replace('/<supplied>/', '&lt;', $txt);
   $txt = preg_replace('/<\/supplied>/', '&gt;', $txt);
   $txt = preg_replace('/<add>/', '<sup>', $txt);
   $txt = preg_replace('/<\/add>/', '</sup>', $txt);
   $txt = preg_replace('/<del>/', '<span style="text-decoration: line-through;">', $txt);
   $txt = preg_replace('/<\/del>/', '</span>', $txt);
   $txt = preg_replace('/<\/term><gloss>/', '</term>: <gloss>', $txt);

   // add link to Priscian text
   if ($kP != '') {
      $txt = preg_replace('/<term>/', '<a class="tooltip" title="Go to context in Priscian." href="index.php?kV=' . $kV . '&amp;kP=' . $kP . '&amp;id=' . $id . '#hi">', $txt);
      $txt = preg_replace('/<\/term>/', '</a>', $txt);   
   }
   else {
      $txt = preg_replace('/<term>/', '', $txt);
      $txt = preg_replace('/<\/term>/', '', $txt);   
   }
   if ($trans != '' && ! is_null($trans)) $txt .= ' <br/><span class="trans">[‘' . $trans . '’]</span>';
   if ($hasA) $txt .= ' <span class="note">[<a class="tooltip" title="Click to see analysis of Old Irish forms in this gloss." href="index.php?id=' . $id . '&an=1">analysis</a>]</span>';
   return $txt;   
}


?>
