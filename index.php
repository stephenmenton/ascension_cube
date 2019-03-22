<?php
ini_set( "display_errors", 1 );
error_reporting( E_ALL );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <title>aquaone&#39;s Ascension cube</title>
  <link rel="stylesheet" href="css/default.css" type="text/css" media="print, projection, screen" />
  <link rel="stylesheet" href="css/mtg.css" type="text/css" media="print, projection, screen" />
  <link rel="stylesheet" href="css/tablesorterBlue.css" type="text/css" media="print, projection, screen" />
  <link rel="stylesheet" href="css/jquery.tablefilter.css" type="text/css" media="print, projection, screen" />
  <link rel="stylesheet" href="css/jquery.tooltip.css" type="text/css" media="projection, screen" />

  <script src="../../js/jquery/jquery.1-3-1.min.js" type="text/javascript"></script>
  <script src="../../js/jquery/jquery.tablesorter.min.js" type="text/javascript"></script>
  <script src="../../js/jquery/jquery.tooltip.js" type="text/javascript"></script>
  <script src="js/jquery.tablefilter.js" type="text/javascript"></script>
  <script type="text/javascript">
//<![CDATA[
$("document").ready(function(){

  // tablesorter
  $dt = $("table.tablesorter").tablesorter({
    widgets: [ "zebra" ],
    sortList: [[2,0],[4,0],[1,0]] 
    });

  // tablefilter
  $("table.tablefilter").tablefilter({
    headers: {
      0: { filter: false },
      1: { filter: "regex" },
      2: { filter: "regex" },
      3: { filter: "regex" },
      4: { filter: "numeric" },
      5: { filter: "numeric" },
      6: { filter: "regex" },
      7: { filter: "regex" },
      8: { filter: "select", caseSensitive: true },
      9: { filter: "select", caseSensitive: true },
      10: { filter: "regex" }
      },
    widgets: [ "zebra" ],
    eraser: true
    });

  // "x cards visible"
  $("table.tablefilter").bind( "filterEnd", function(){
    $tbody = $(this).children( "tbody" );
    // ~~ is bitwise op, for rounding on percentage
    $("#cardsVisible").text( $("tr:visible", $tbody).length + " cards visible (" + ~~( $("tr:visible", $tbody).length / $("tr", $tbody).length * 100 ) + "%)" );
    $("#cardsHidden").text( $("tr:hidden", $tbody).length + " cards hidden" );
    });

  // tooltips
  $("th[title]").tooltip();

  // force card links to open in a new window
  $("a[rel='external']").each(function(){
    this.target = "_blank";
    });

  $("table.tablefilter").trigger( "filterSet" );

  });

//]]>
  </script>
</head>
<!--[if lt IE 7 ]>
<body class="ie ie6"><![endif]-->
<!--[if IE 7 ]>
<body class="ie ie7"><![endif]-->
<!--[if IE 8 ]>
 <body class="ie ie8"><![endif]-->
<!--[if !IE]>
--><body><!--<![endif]-->
<p>These is my current Ascension cube. If you have constructive feedback please <a href="mailto:aquaone@gmail.com">e-mail me</a>.</p>
<p>Ascension, all images, card data, and card text are &copy; 2014 Stoneblade Entertainment.<br />
All other content and design &copy; 2014 Stephen Menton.</p>
<p>to-do:
<ul>
  <li>full card art, link</li>
  <li>history viewer</li>
  <li>icons, better css</li>
  <li>buy Darkness Unleashed, Realms Unraveled, promos and update</li>
</ul>
<p>known issues:
<ul>
  <li>no image for New Event, Tinkering Monk, all cards from Realms Unraveled</li>
  <li>no CSS for event, treasure, monster</li>
</ul>
</p>
<table id="cube" class="tablesorter tablefilter">
  <caption>aquaone's Ascension cube | <span id="cardsVisible"></span> | <span id="cardsHidden"></span></caption>
  <thead>
    <tr>
      <th style="width: 60px;" title="image of the card">image</th>
      <th style="width: 150px;" title="the card's name">card name</th>
      <th style="width: 50px;" title="the factions of the card">factions</th>
      <th style="width: 50px;" title="hero, construct, monster, treasure, ...">type</th>
      <th style="width: 30px;" title="cost to acquire or defeat the card">cost</th>
      <th style="width: 30px;" title="honor value printed on the card">honor</th>
      <th style="width: 150px;" title="text of the card">text</th>
      <th style="width: 30px;" title="set abbreviations, details ot be added later">set</th>
      <th style="width: 30px;" title="whether or not the card was signed by the artist">signed</th>
      <th style="width: 30px;" title="whether or not artistic modifications/alterations <br />have been performed on the card">altered</th>
      <th style="width: 120px;" title="miscellaneous notes about the card">notes</th>
    </tr>
  </thead>
  <tbody>
<?php

$cubeFile = "cube.xml";
$cubeXml = simplexml_load_file( $cubeFile ) or die( "cube file {$cubeFile} not found" );

function get_class_by_type_and_faction( $type, $a_factions) {
  // monster, treasure, etc
  if( ! in_array( $type, array( "Hero", "Construct" ))) {
    return $type;
  }
  // at least one faction
  if( count( $a_factions ) == 1 ) {
    return $a_factions[0];
  }
  // ???
  return "unknown";
}

$center_deck = array();

foreach( $cubeXml->cards->card as $card ) {
  // generic cardName
  $cardName = $cubeXml->xpath( "/cube/cardNames/cardName[@name=\"{$card->name}\"]" );

  $factions = array();

  // factions
  foreach( $cardName[0]->factions as $faction_xml ) {
    foreach( $faction_xml->faction as $faction ) {
      array_push( $factions, $faction );
    }
  }
  $s_factions = implode( ' ', $factions );

  $tr_class = get_class_by_type_and_faction( $cardName[0]->type, $factions );
  $imgPath = sprintf( 'images/cards/%s_small.jpg', preg_replace( '/ /', '_', $card->name ));

  for( $i = 0; $i < $card->quantity; $i++ ) {
    // print row
    echo "    <tr class=\"$tr_class\">\n";
    echo "      <td>" . ( file_exists( $imgPath ) ? "<img src=\"$imgPath\" />" : '' ) . "</td>\n";
    echo "      <td>{$card->name}</td>\n";
    echo "      <td>$s_factions</td>\n";
    echo "      <td>{$cardName[0]->type}</td>\n";
    echo "      <td>{$cardName[0]->cost}</td>\n";
    echo "      <td>{$cardName[0]->honor}</td>\n";
    echo "      <td>{$cardName[0]->text}</td>\n";
    echo "      <td>" . ( isset( $cardName[0]->set ) ? $cardName[0]->set : $card->set ) . "</td>\n";
    echo "      <td>{$card->signed}</td>\n";
    echo "      <td>{$card->altered}</td>\n";
    echo "      <td>{$card->notes}</td>\n";
    echo "    </tr>\n";

    // add to center deck
    array_push( $center_deck, $card );
  }
}
?>
  </tbody>
</table>

<br />
<table class="tablesorter">
  <caption>sample center row</caption>
  <tbody>
    <tr>
<?php
// shuffle center deck
shuffle( $center_deck );

// build center row
$center_row = array();
$center_row_index = 0;
$center_deck_index = 0;
$new_event_count = 0;
while( $center_row_index < 6 ) {
  // get a card
  $card = $center_deck[$center_deck_index];
  $cardName = $cubeXml->xpath( "/cube/cardNames/cardName[@name=\"{$card->name}\"]" );
  // event?
  if( $cardName[0]->type == "Event" ) {
    $new_event_count++;
  } elseif( $cardName[0]->type == "Treasure" ) {
    if( ! isset( $center_row[$center_row_index] )) {
      $center_row[$center_row_index] = array();
    }
    array_push( $center_row[$center_row_index], $card->name );
  } else {
    if( ! isset( $center_row[$center_row_index] )) {
      $center_row[$center_row_index] = array();
    }
    array_push( $center_row[$center_row_index], $card->name );
    $center_row_index++;
  }
  $center_deck_index++;
}

// print center row
foreach( $center_row as $center_row_slot ) {
  printf( "      <td>%s</td>\n", implode( ', ', $center_row_slot ));
}
echo "    </tr>\n";
echo "  </tbody>\n";
echo "  <tfoot>\n";
echo "    <tr>\n";
echo "      <td colspan=\"6\">{$new_event_count} New Events</td>\n";
echo "    </tr>\n";
echo "  </tfoot>\n";
echo "</table>\n";

function pvar_dump( $var ) {
  echo "<pre>";
  var_dump( $var );
  echo "\n</pre>";
  }

function pprint_r( $var ) {
  echo "<pre>";
  print_r( $var );
  echo "\n</pre>";
  }

?>
</body>
</html>
