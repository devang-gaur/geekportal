//Setting up the AJAX loading GIF
var article_heads;
var content_divs=document.getElementsByClassName("accordion-section-content");
for(var i=0;i<5;i++)
content_divs[i].innerHTML= "<img src='img/loading.gif' />";

//Function to get the feed
function getFeed(the_site, index, callback, callback2,callback3)
{
    //var content_divs=document.getElementsByClassName("accordion-section-content");
    
    if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
    }
    else
    {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function() {
        
        if (xmlhttp.readyState==4 && xmlhttp .status==200) {
          content_divs[index].innerHTML=xmlhttp.responseText;
          callback(index,callback2,callback3);
        }
    }
    
    xmlhttp.open("GET","loadRSS.php?site="+the_site,true);
    xmlhttp.send();
    console.log(content_divs[index]);
}


//array of title divs
var title_divs=document.getElementsByClassName("accordion-section-title");

var techcrunch_div=title_divs[0];;
techcrunch_div.onclick=function(){
    //var url="http://techcrunch.com/feed/";
    getFeed("techcrunch",0,getReady,popit,pop);
    //getReady(0);
    //popit(article_heads);
};
    
var bbc_div=title_divs[1];
bbc_div.onclick=function(){
    //var url="http://feeds.bbci.co.uk/news/technology/rss.xml";
    getFeed("bbc",1,getReady,popit,pop);
    //getReady(1);
    //popit(article_heads);
};

var digit_div=title_divs[2];
digit_div.onclick=function(){
    //var url="http://feeds.feedburner.com/digit/latest-news?format=xml";
    getFeed("digit",2,getReady,popit,pop);
    //getReady(2);
    //popit(article_heads);
 };

var appleinsider_div=title_divs[3];
appleinsider_div.onclick=function(){
    //var url="http://appleinsider.com/rss/news/";
    getFeed("appleinsider",3,getReady,popit,pop);
};

var android_div=title_divs[4];
android_div.onclick=function(){
    //var url="http://feed.androidauthority.com";
    getFeed("androidauthority",4,getReady,popit,pop);
};


function getReady(x,callback,callback2){
    console.log("ready function called!");
    //var str="con" 
    article_heads=content_divs[x].getElementsByClassName("feed");;

    console.log(article_heads);

    callback(article_heads,callback2);
}


function popit(feeds,callback){
    
//console.log(feeds);
//console.log();
//console.log(feeds.length);
for(var i=0;i<feeds.length;i++){
    //console.log(feeds[i]);
    feeds[i].onclick=function(){
        console.log("pressed");
        var href_str=this.getElementsByClassName("feed-link")[0].href;
        console.log(href_str);
        callback(href_str);
    };
}
}


function pop(str){
    $('#myPopDiv iframe').attr("src",str);
    $('#myPopDiv').popup("open").attr("data-transition","Slide");
    
}