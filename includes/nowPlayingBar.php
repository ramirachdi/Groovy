<?php
$dsn = "mysql:host=localhost;dbname=groovy;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$sql = "SELECT id FROM songs ORDER BY RAND() LIMIT 10";
$stmt = $pdo->query($sql);

$resultArray = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);
?>

<script>

$(document).ready(function() {
	var test=0;
	newPlaylist = <?php echo $jsonArray; ?>;
	audioElement = new Audio();
    console.log(newPlaylist);
	setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);

    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
		e.preventDefault();
	});


    $(".playbackBar .progress").css("width", 0 + "%");

    $(".playbackBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".playbackBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {
			timeFromOffset(e, this);
		}
	});

	$(".playbackBar .progressBar").mouseup(function(e) {
		timeFromOffset(e, this);
	});

	$(document).mouseup(function() {
		mouseDown = false;
	});


$(".volumeBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".volumeBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {

			var percentage = e.offsetX / $(this).width();

			if(percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		}
	});

	$(".volumeBar .progressBar").mouseup(function(e) {
		var percentage = e.offsetX / $(this).width();

		if(percentage >= 0 && percentage <= 1) {
			audioElement.audio.volume = percentage;
		}
	});

	$(document).mouseup(function() {
		mouseDown = false;
	});

});

function timeFromOffset(mouse, progressBar) {
	var percentage = mouse.offsetX / $(progressBar).width() * 100;
	var seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds);
}

function prevSong() {
	if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
		audioElement.setTime(0);
	}
	else {
		currentIndex = currentIndex - 1;
		setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
	}
}


function nextSong() {



	if(repeat == true) {
		audioElement.setTime(0);
		playSong();
		return;
	}

	if(currentIndex == currentPlaylist.length - 1) {
		currentIndex = 0;
	}
	else {
		currentIndex++;
	}

    var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
	setTrack(trackToPlay, currentPlaylist, true);
}


function setMute() {
	audioElement.audio.muted = !audioElement.audio.muted;
	var imageName = audioElement.audio.muted ? "mute.svg" : "volume-low.svg";
	$(".controlButton.volume img").attr("src", "assets/icons/" + imageName);
}

function setRepeat() {
	repeat = !repeat;
	var imageName = repeat ? "repeat-active.svg" : "Repeat.svg";
	$(".controlButton.repeat img").attr("src", "assets/icons/" + imageName);
}

function setShuffle() {
	shuffle = !shuffle;
	var imageName = shuffle ? "shuffle-active.svg" : "Shuffle.svg";
	$(".controlButton.shuffle img").attr("src", "assets/icons/" + imageName);
    if(shuffle == true) {
		shuffleArray(shufflePlaylist);
		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
	}
	else {
		currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
	}

}

function shuffleArray(a) {
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
}




function setTrack(trackId, newPlaylist, play) {

    if(newPlaylist != currentPlaylist) {
		currentPlaylist = newPlaylist;
		shufflePlaylist = currentPlaylist.slice();
		shuffleArray(shufflePlaylist);
	}

	if(shuffle == true) {
		currentIndex = shufflePlaylist.indexOf(trackId);
	}
	else {
		currentIndex = currentPlaylist.indexOf(trackId);
	}
    pauseSong();
    $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
        var track = JSON.parse(data);
        $(".trackName span").text(track.title);

		$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
			var artist = JSON.parse(data);

			$(".artistName span").text(artist.name);
		});
        $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
			var album = JSON.parse(data);
			$(".albumLink img").attr("src", album.artworkPath);
		});

        audioElement.setTrack(track);
        audioElement.play();
    });




    if(play == true) {
    playSong();
}

}
function playSong() {
    if(audioElement.audio.currentTime == 0) {
		$.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
	}

    audioElement.play();
}
function pauseSong(){
    audioElement.pause();
}
</script>
<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
					<span class="albumLink">
						<img src="" class="albumArtwork">
					</span>
                <div class="trackInfo">
                    <span class="trackName"><span></span></span>
                    <span class="artistName"><span></span></span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle Button" onclick="setShuffle()">
                        <img src="assets/icons/shuffle.svg" alt="Shuffle" >
                    </button>
                    <button class="controlButton previous" title="previous Button" onclick="prevSong()">
                        <img src="assets/icons/previous.svg" alt="previous" >
                    </button>
                    <button class="controlButton play" title="play Button" onclick="playSong()">
                        <img src="assets/icons/play.svg" alt="play" >
                    </button>
                    <button class="controlButton pause" title="pause Button" style="display: none" onclick="pauseSong()">
                        <img src="assets/icons/pause.svg" alt="pause" >
                    </button>
                    <button class="controlButton next" title="next Button" onclick="nextSong()">
                        <img src="assets/icons/next.svg" alt="next" >
                    </button>
                    <button class="controlButton repeat" title="repeat Button" onclick="setRepeat()">
                        <img src="assets/icons/repeat.svg" alt="repeat" >
                    </button>
                </div>
                <div class="playbackBar">
                    <span class="progressTime current">0:00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"><style></style></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0:00</span>
                </div>
            </div>
        </div>
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="volume button" onclick="setMute()">
                    <img src="assets/icons/volume-low.svg" alt="volume">
                </button>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
