/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *	// update the viewport, in case the window size has changed
 *	viewport = updateViewportDimensions();
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
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
  //un-hide
  var playerWrapper = document.getElementById('story-player');
  playerWrapper.style.display = "block";
   
  //embed audio - swaps out the existing src URL in the mediaelements audio widget
  var audioEmbed = document.getElementsByTagName("mediaelementwrapper")[0];
  var audioSRC = audioEmbed.firstChild;
  audioSRC.setAttribute("src",audioURL);
  audioSRC.setAttribute("autoplay","");

  //continue to next story in table when audio complete
  var clickedListen = event.target; 
  var clickedRow = clickedListen.closest(".post-row"); 
  audioSRC.onended = function() {
    var nextRow = clickedRow.nextSibling;
    var nextListen = nextRow.getElementsByClassName("listen-btn")[0];  
    nextListen.click();
};
  
    //previous button
    var prevButton = document.getElementById('player-previous');
    prevButton.onclick = function skipStory() {
      var previousRow = clickedRow.previousSibling;
      var prevListen = previousRow.getElementsByClassName("listen-btn")[0];    
      prevListen.click();
    };


  //next button
  var skipButton = document.getElementById('player-next');
  skipButton.onclick = function skipStory() {
    nextListen.click();
  };

  //close button
  var playerClose = document.getElementById('player-close');
  playerClose.onclick = function closePlayer (){
    audioSRC.setAttribute("src","");
    playerWrapper.style.display = "none";
    //let's make the listen button close too
  };

  
  //Description
  var playerDescription = document.getElementById('player-description');
  playerDescription.innerHTML =storyName +' <br> ' + eventName;
  
  //download button
  var playerDownload = document.getElementById('player-download');
  playerDownload.setAttribute("data",audioURL);
  


  //pass post ID & URL over to tag form modal button as custom attributes (click listener set in jquery)
  var tagButton = document.getElementById("player-tag-btn");
  tagButton.setAttribute('post_id',id);
  tagButton.setAttribute('post_url',postURL);

  //theme page button
  var playerTheme = document.getElementById('player-theme-page');
  playerTheme.setAttribute("href",themeURL);

  //display tags
  var playerTags = document.getElementById('player-tags');
  playerTags.innerHTML = '<p>' + storyTags + '</p>';



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
  var audioURL = $(this).attr("data");
  var downloadButton = $("#modal-download-btn");
  //passes proper mp3 link based on download button's data attribute
  downloadButton.attr("href",audioURL);
  });

});
/* end of as page load scripts */
