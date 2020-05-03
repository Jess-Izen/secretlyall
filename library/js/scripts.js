/*
 * SY Scripts File
 *
*/




function loadGravatars() {
  // set the viewport using the function above
  viewport = updateViewportDimensions();
  // if the viewport is tablet or larger, we load in the gravatars
  if (viewport.width >= 768) {
  jQuery('.comment img[data-gravatar]').each(function(){
    jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
  });
	}
} // end function


function QueueStoryPlayer(id, audioURL, storyName, eventName, postURL, themeURL, storyTags){
  //embed audio - swaps out the existing src URL in the mediaelements audio widget
  var clickedListen = event.target;
  var audioEmbed = document.getElementsByTagName("mediaelementwrapper")[0];
  var audioSRC = audioEmbed.firstChild;
  var playerWrapper = document.getElementById('story-player');
  staticListen = document.querySelector('[storyid="'+ id + '"]'); //pull static DOM list for validation
  clickState = staticListen.getAttribute("state");

  // if story already open
  if (clickState !== "inactive"){
    clickedListen.setAttribute("state","inactive");
    audioSRC.setAttribute("src","");
    playerWrapper.style.display = "none";
    clickedListen.style.backgroundImage = "url(/wp-content/themes/secretlyyall/library/images/play-small.svg)";
    clickedListen.style.filter = "brightness(70%)";
    return;
  }

  //if story isn't open
  if (clickState == "inactive"){
    allListenButtons = document.querySelectorAll('a.listen-btn');
    allListenButtons.forEach(function(button) {
      if (button.getAttribute("state") == "active"){
        button.style.filter = "brightness(70%)"
        button.setAttribute("state", "inactive");
        button.style.backgroundImage = "url(/wp-content/themes/secretlyyall/library/images/play-small.svg)";
      }
      });
    
    /*allListenButtons.forEach(ListenButton => {
      ListenButton.setAttribute("state", "inactive");
      ListenButton.style.backgroundImage = "url(/wp-content/themes/secretlyyall/library/images/play-small.svg)";
    });*/
    //display player, load music
    playerWrapper.style.display = "flex";
    audioSRC.setAttribute("src",audioURL);
    audioSRC.setAttribute("autoplay","");

    //handle table listen button
    clickedListen.style.backgroundImage = "url(/wp-content/themes/secretlyyall/library/images/stop-small.svg)";
    clickedListen.style.filter = "brightness(100%)";
    clickedListen.setAttribute("state","active");

    //set focus on play/pause button
    var playPause = playerWrapper.querySelector("div.mejs-playpause-button button");
    playPause.focus();
      
    //Description
    var playerDescription = document.getElementById('player-description');
    playerDescription.innerHTML =' <div id="player-name">' + storyName +'</div> <a id="player-theme">' + eventName + '</a';

    //theme page link
    var playerTitleTheme = document.getElementById('player-theme')
    playerTitleTheme.setAttribute("href",themeURL);

    //download button
    var playerDownload = document.getElementById('player-download-btn');
    playerDownload.setAttribute("data",audioURL);


    //pass post ID & URL over to tag form modal button as custom attributes (click listener set in jquery)
    var tagButton = document.getElementById("player-tag-btn");
    tagButton.setAttribute('post_id',id);
    tagButton.setAttribute('post_url',postURL);

    //display tags
    var playerTags = document.getElementById('player-tags');
    playerTags.innerHTML = '<p>' + storyTags + '</p>';
    } 

    //continue to next story in table when audio complete 
    var clickedRow = clickedListen.closest(".post-row"); 
    var nextRow = clickedRow.nextSibling;
    var nextListen = nextRow.getElementsByClassName("listen-btn")[0];  
    audioSRC.onended = function() {
      clickedListen.style.backgroundImage = "url(/wp-content/themes/secretlyyall/library/images/play-small.svg)";
      clickedListen.style.filter = "brightness(70%)";  
      clickedListen.setAttribute("state","inactive");
      nextListen.click();
      return;
      };

      //previous button
      var prevButton = document.getElementById('player-previous');
      prevButton.onclick = function skipStory() {
        var previousRow = clickedRow.previousSibling;
        var prevListen = previousRow.getElementsByClassName("listen-btn")[0];    
        clickedListen.style.backgroundImage = "url(/wp-content/themes/secretlyyall/library/images/play-small.svg)";
        clickedListen.style.filter = "brightness(70%)";  
        clickedListen.setAttribute("state","inactive");
        prevListen.click();
        return;
        };


    //next button
    var skipButton = document.getElementById('player-next');
    skipButton.onclick = function skipStory() {
      nextListen.click();
      clickedListen.style.backgroundImage = "url(/wp-content/themes/secretlyyall/library/images/play-small.svg)";
      clickedListen.style.filter = "brightness(70%)";  
      clickedListen.setAttribute("state","inactive");
      return;
    };


    //close button
    var playerClose = document.getElementById('player-close');
    playerClose.onclick = function closePlayer (){
      audioSRC.setAttribute("src","");
      playerWrapper.style.display = "none";
      clickedListen.style.backgroundImage = "url(/wp-content/themes/secretlyyall/library/images/play-small.svg)";
      clickedListen.style.filter = "brightness(70%)";
      clickedListen.setAttribute("state","inactive");
      return;
    };
      
    //let's make the escape key close too, for screenreaders
    document.onkeydown = function(evt) {
      evt = evt || window.event;
      if (evt.keyCode == 27) {
        audioSRC.setAttribute("src","");
        playerWrapper.style.display = "none";
        clickedListen.style.backgroundImage = "url(/wp-content/themes/secretlyyall/library/images/play-small.svg)";
        clickedListen.style.filter = "brightness(70%)";
        clickedListen.setAttribute("state","inactive");
        return;
      }
    }


};




/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
  
  //add click listener to player tag button, open fancybox using post's URL as src (which has proper form embedded)
  $("#player-tag-btn").click(function() {
    var id = $(this).attr("post_id");
    var postURL = $(this).attr("post_url");
    $.fancybox.open({
      src  : postURL,
      type : 'iframe',
      opts : {
        smallBtn: true, 
      },
      });
  });

  //add click listener to download button (in table and player), to open up fancybox w/ donation prompt
  $('.download-btn').on('click',function(){
  $(this).css("filter","brightness(70%)");
  var audioURL = $(this).attr("data");
  var downloadButton = $("#modal-download-btn");
  //passes proper mp3 link based on download button's data attribute
  downloadButton.attr("href",audioURL);
  });

});
/* end of as page load scripts */
