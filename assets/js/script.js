var userLoggedIn;
var timer;
function createPlaylist() {
    var popup = prompt("Please enter the name of your playlist");
    if(popup != null) {

        $.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
            .done(function() {
                openPage("?yourMusic.php");
            });

    }

}

function deletePlaylist(playlistId) {
    var prompt = confirm("Are you sure you want to delete this playlist?");
    if(prompt == true) {

        $.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
            .done(function() {

                //do something when ajax returns
                openPage("yourMusic.php");
            });


    }
}
function showOptionsMenu(button) {
    var songId = $(button).prevAll(".songId").val();
    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    menu.find(".songId").val(songId);
    var scrollTop = $(window).scrollTop(); //Distance from top of window to top of document
    var elementOffset = $(button).offset().top; //Distance from top of document
    var top = elementOffset - scrollTop;
    var rect=button.getBoundingClientRect();
    var left = rect.left+window.scrollX; // Distance between button and left of document

    menu.css({ "top": top + "px", "left": left - menuWidth+ "px", "display": "inline",});

}

$(document).click((click)=>
{  var target=$(click.target);
    if((!target.hasClass("item"))&&(!target.hasClass('moreImg')))
    {
        hideOptionsMenu();
    }
});

function hideOptionsMenu()
{
    var menu=$(".optionsMenu")
    if(menu.css("display")!="none")
    {
        menu.css("display","none");
    }
}
function logout()
{
    $.post("includes/handlers/ajax/logout.php",()=>{location.reload();});
}


//function that allows to load the pages dynamically without needing the page to refresh
function openPage(url)
{
    if(timer !=null)
    {
        clearTimeout(timer);
    }
    if(url.indexOf("?")==-1)// Checking if uri begins with ?
    {
        url+='?';
    }
    var encodeUrl=encodeURI(url+"&userLoggedIn="+userLoggedIn); // Encoding the url
    $('#mainContent').load(encodeUrl);  // Loading the new mainContent in the place of the old one
    $("body").scrollTop(0); // automatically scroll to the top when changing the page
    history.pushState(null,null,url); // changing the url in the bar
}
function updateEmail(emailClass)
{
    var emailValue=$("."+emailClass).val();
    $.post("includes/handlers/ajax/updateEmail.php",{email: emailValue, username:userLoggedIn})
        .done((response)=>{
        $("."+emailClass).nextAll('.message1').text(response)
        })
}
function updatePassword(oldPasswordClass,newPasswordClass1,newPasswordClass2)
{
    var oldPassword=$("."+oldPasswordClass).val();
    var newPassword1=$("."+newPasswordClass1).val();
    var newPassword2=$("."+newPasswordClass2).val();

    $.post("includes/handlers/ajax/updatePassword.php",
        {oldPassword:oldPassword,
            newPassword1:newPassword1,
            newPassword2:newPassword2,
            username:userLoggedIn})
        .done((response)=>{
            $("."+oldPasswordClass).nextAll('.message2').text(response)
        })
}
$(document).on("change","select.Playlist",function()
{   var select=$(this);
    var playlistId=select.val();
    console.log(playlistId);
     var songId=select.prev(".songId").val();
     console.log(songId);
     $.post("includes/handlers/ajax/addToPlaylist.php",{playlistId:playlistId,songId:songId}).done
     (function()
         {
            hideOptionsMenu();
            select.val("");
         }
     );

})


function removeFromPlaylist(button,playlistId)
{
    var songId = $(button).prevAll(".songId").val();
    $.post("includes/handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId ,songId:songId})
        .done(function() {

            //do something when ajax returns
            openPage("playlist.php?id=" + playlistId);
        });

}
var currentPlaylist = [];
var audioElement;
var mouseDown=false;
var currentIndex=0;
var repeat=false;
var shuffle=false;
var tempPlaylist=[];
function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60); //Rounds down
    var seconds = time - (minutes * 60);

    var extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds;
}
function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration));

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}
function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function() {
        nextSong();
    });


    this.audio.addEventListener("canplay", function() {
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate", function(){
        if(this.duration) {
            updateTimeProgressBar(this);
        }
    });
    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
    });


    this.setTrack = function(track) {
        this.currentlyPlaying=track;
        this.audio.src = track.path;
    }

    this.play = function() {
        this.audio.play();
    }
    this.pause =function() {
        this.audio.pause();
    }
    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }

}
