<?php
error_reporting(E_ERROR | E_PARSE); 
$site=$_GET['site'];

$html="";

function loadFeed($site,$url)
{
    $xml=simplexml_load_file($url);
    
    for($i=0;$i<10;$i++)
    {
        $html="";
	$title=$xml->channel->item[$i]->title;
	$description=$xml->channel->item[$i]->description;
	$html.='<div class="feed" id="PopDiv-'.$i.'"><div class="feed-title">'.$title.'</div><br />';
        
        $guid=$xml->channel->item[$i]->guid;
        $html.='<div class="feed-description">'.$description.'<a class="feed-link" href='.$guid.'>read more.</a></div>'
                .'</div><hr />';
        
        
        if($url=="")
        {
            $html="Some Error occured.";
        }

        echo $html=="" ? "<h3>No feed available</h3>" : $html ;

    }
}


if($site=="androidauthority"){
    $url="http://feed.androidauthority.com";
    loadFeed($site,$url);
}
elseif ($site=="techcrunch") {
    $url="http://techcrunch.com/feed/";
    loadFeed($site,$url);
}
elseif ($site=="digit") {
    $url="http://feeds.feedburner.com/digit/latest-news?format=xml";
    loadFeed($site,$url);
}
elseif ($site=="bbc") {
    $url="http://feeds.bbci.co.uk/news/technology/rss.xml";
    loadFeed($site,$url);
}
elseif ($site=="appleinsider") {
    $url="http://appleinsider.com/rss/news/";
    loadFeed($site,$url);
}

?>