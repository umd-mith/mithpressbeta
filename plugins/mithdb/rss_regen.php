<?php

$year = date("Y");
$current = date("D, d M Y H:i:s -0500");
	
$header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\" version=\"2.0\">

<channel>
	<title>MITH's Digital Dialogues</title>
	<link>http://mith.umd.edu/podcast</link>
	<language>en-us</language>
	<copyright>Copyright $year Maryland Institute for Technology in the Humanities</copyright>
	<lastBuildDate>$current</lastBuildDate>
	<pubDate>$current</pubDate>
	<webMaster>mith@umd.edu (MITH Staff)</webMaster>

	
	<itunes:subtitle>MITH's Weekly Digital Humanities Speaker Series</itunes:subtitle>
	<itunes:author>Maryland Institute for Technology in the Humanities</itunes:author>
	<itunes:summary>Digital Dialogues is MITH's signature events program. Held almost every week while the academic semesters are in session, and (almost) always on the same day and time--Tuesdays, 12:30-1:45--Digital Dialogues is an occasion for discussion, presentation, and intellectual exchange that you can build into your weekly schedule. Past presentations have run the gamut from current Fellows and members of the MITH community presenting their work in progress to distinguished visiting speakers engaging with audiences in an informal seminar setting.</itunes:summary>
	
	<description>Digital Dialogues is MITH's signature events program. Held almost every week while the academic semesters are in session, and (almost) always on the same day and time--Tuesdays, 12:30-1:45--Digital Dialogues is an occasion for discussion, presentation, and intellectual exchange that you can build into your weekly schedule. Past presentations have run the gamut from current Fellows and members of the MITH community presenting their work in progress to distinguished visiting speakers engaging with audiences in an informal seminar setting.</description>

	<itunes:owner>
		<itunes:name>Maryland Institute for Technology in the Humanities</itunes:name>
		<itunes:email>mith@umd.edu</itunes:email>
	</itunes:owner>
	<itunes:image href=\"http://mith.umd.edu/images/digitaldialogues.jpg\" />
	<itunes:category text=\"Education\">
		<itunes:category text=\"Education Technology\"/>
	</itunes:category>
	<itunes:category text=\"Technology\">
		<itunes:category text=\"Tech News\"/>
	</itunes:category>
	<itunes:category text=\"Arts\">
		<itunes:category text=\"Design\"/>
	</itunes:category>
	<itunes:category text=\"Arts\">
		<itunes:category text=\"Literature\"/>
	</itunes:category>
	<itunes:category text=\"Arts\">
		<itunes:category text=\"Performing Arts\"/>
	</itunes:category>
	<itunes:explicit>no</itunes:explicit>

";
		

	// Items	
		
		$items = "";
		
		$link = mysql_connect("zelda.umd.edu","mithwp_admin","HyP%toaD6") or die("OMG");
		mysql_select_db("mithpress",$link);
		
		$qry = "SELECT * FROM wp_mth_podcast WHERE mth_dd_audio IS NOT NULL ORDER BY mth_dd_date DESC LIMIT 20 ";
		$result = mysql_query($qry);
		while ($row = mysql_fetch_assoc($result)) {
			
			// format date, ex.
			// Mon, 26 Jan 2009 23:33:32 -0500
			$date = date("D, d M Y H:i:s -0500", strtotime($row['mth_dd_date']));
			
			$subtitle = htmlspecialchars(substr(strrchr($row['mth_dd_title'], ":"), 1));
			$path = "http://mith.umd.edu/programs/digitaldialogue/mp3";
	
			$items .= "
	<item>
		<title>".htmlspecialchars(stripslashes($row['mth_dd_title']))."</title>
		<itunes:author>".$row['mth_dd_speaker']."</itunes:author>
		<itunes:subtitle>".$subtitle."</itunes:subtitle>
		<itunes:summary>".htmlentities(stripslashes($row['mth_dd_desc']))."</itunes:summary>
		<enclosure url=\"".$path."/".$row['mth_dd_audio']."\" length=\"".$row['mth_dd_length']."\" type=\"audio/mpeg\" />
		<guid>".$path."/".$row['mth_dd_audio']."</guid>
		<pubDate>".$date."</pubDate>
		<itunes:duration>".$row['mth_dd_duration']."</itunes:duration>
		<itunes:keywords>".$row['mth_dd_tags']."</itunes:keywords>
	</item>

";		
		}
		
	// Footer
	
		$footer = "
	</channel>

</rss>";
		

	$file = "../digitaldialogues/podcast.xml";
	//$file = "podcast.xml";
	$handler = fopen($file, 'w');
	
	$data = $header.$items.$footer;	
	$success = fwrite($handler, $data);
	
	fclose($handler);
	
	$regendate = date("g:ia, D M j, Y");
	if ($success) echo "Podcast RSS successfully regenerated at $regendate";
	else echo "Error writing file";
	
?>