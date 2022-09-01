<?php
/* 
	This script filters podcast items to only keep the wanted ones.
	The result is cached for 24 hours.
*/
$now = time();
header('Content-Type: application/xml; charset=utf-8');
?>
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:media="https://search.yahoo.com/mrss/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:googleplay="http://www.google.com/schemas/play-podcasts/1.0" xmlns:spotify="http://www.spotify.com/ns/rss" xmlns:podcast="https://podcastindex.org/namespace/1.0" version="2.0">
	<channel>
		<title>Les Grosses Têtes - Filtrées</title>
		<link>
		<![CDATA[https://www.rtl.fr/emission/les-grosses-tetes]]>
		</link>
		<description>
			<![CDATA[Uniquement les emissions intégrales. Pas de superflu. Du lundi au vendredi de 15h30 à 18h, retrouvez Laurent Ruquier, chef d'orchestre de l'émission. Entouré de ses fidèles Grosses Têtes, il imprime sa marque à ce programme culte de la radio tout en restant fidèle à ses fondamentaux.]]>
		</description>
		<language>fr</language>
		<copyright>Podcast : Copyright RTL, filtre : RJG</copyright>
		<lastBuildDate><?php echo gmdate('D, d M Y H:i:s', $now) ?> GMT</lastBuildDate>
		<pubDate><?php echo gmdate('D, d M Y 00:00:00', $now) ?> GMT</pubDate>
		<webMaster>romain@giovanetti.fr</webMaster>
		<generator>RJG</generator>
		<itunes:subtitle>
			<![CDATA[Les Grosses Têtes - Filtrées]]>
		</itunes:subtitle>
		<itunes:author>
			<![CDATA[RTL & RJG]]>
		</itunes:author>
		<itunes:summary>
			<![CDATA[Uniquement les emissions intégrales. Pas de superflu. Du lundi au vendredi de 15h30 à 18h, retrouvez Laurent Ruquier, chef d'orchestre de l'émission. Entouré de ses fidèles Grosses Têtes, il imprime sa marque à ce programme culte de la radio tout en restant fidèle à ses fondamentaux.]]>
		</itunes:summary>
		<itunes:owner>
			<itunes:name>
				<![CDATA[RJG]]>
			</itunes:name>
			<itunes:email>
				<![CDATA[romain@giovanetti.fr]]>
			</itunes:email>
		</itunes:owner>
		<itunes:explicit>no</itunes:explicit>
		<itunes:block>no</itunes:block>
		<itunes:type>episodic</itunes:type>
		<itunes:image href="https://www.giovanetti.fr/extra/rtl/lesgrossestetes/index.jpg" />
		<spotify:countryOfOrigin>fr</spotify:countryOfOrigin>
		<googleplay:author>
			<![CDATA[RJG]]>
		</googleplay:author>
		<googleplay:description>
			<![CDATA[Uniquement les emissions intégrales. Pas de superflu. Du lundi au vendredi de 15h30 à 18h, retrouvez Laurent Ruquier, chef d'orchestre de l'émission. Entouré de ses fidèles Grosses Têtes, il imprime sa marque à ce programme culte de la radio tout en restant fidèle à ses fondamentaux.]]>
		</googleplay:description>
		<googleplay:email>
			<![CDATA[romain@giovanetti.fr]]>
		</googleplay:email>
		<googleplay:explicit>no</googleplay:explicit>
		<googleplay:block>no</googleplay:block>
		<googleplay:image href="https://www.giovanetti.fr/extra/rtl/lesgrossestetes/index.jpg" />
		<itunes:keywords>Divertissement,RTL,humour,rire,actualité,blague,insolite,culture,Laurent Ruquier</itunes:keywords>
		<image>
			<url>
				<![CDATA[https://www.giovanetti.fr/extra/rtl/lesgrossestetes/index.jpg]]>
			</url>
			<title>
				<![CDATA[Les Grosses Têtes]]>
			</title>
			<link>
			<![CDATA[https://www.rtl.fr/emission/les-grosses-tetes]]>
			</link>
		</image>
		<category>News</category>
		<category>Comedy</category>
		<itunes:category text="News">
			<itunes:category text="Entertainment News" />
		</itunes:category>
		<itunes:category text="Comedy" />
		<googleplay:category text="News" />
		<googleplay:category text="Comedy" />
		<?php
			$mustRefreshCacheFile = false;
			if (!file_exists('./cache.txt')) {
				touch('./cache.txt');
				$mustRefreshCacheFile = true;
			} else {
				$cacheLastModified = filemtime('./cache.txt');
				if ($cacheLastModified > (time() + 86400)) {
					$mustRefreshCacheFile = true;
				}
			}

			$itemsToBeAdded = "";

			if ($mustRefreshCacheFile) {
				$xmlContent = file_get_contents("https://feeds.audiomeans.fr/feed/d7c6111b-04c1-46bc-b74c-d941a90d37fb.xml");
				preg_match_all('(<item>.*<title>.+INTÉ.+<\/title>.*<\/item>)', $xmlContent, $matches);
				// var_dump($matches); 
				for ($i = 0; $i < count($matches[0]); $i++) {
					$itemsToBeAdded .= $matches[0][$i];
				}
				file_put_contents("./cache.txt", $itemsToBeAdded);
			} else {
				$itemsToBeAdded = file_get_contents("./cache.txt");
			}

			echo $itemsToBeAdded;
		?>
	</channel>
</rss>
