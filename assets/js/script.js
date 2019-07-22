var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var beamplay = false;
var beamplaying = false;
var learning = false;
var userLoggedIn;
var timer;
var beatLogs = [];

// When document is ready

$(document).ready(() => {
	$(document).on('click', '.follow-btn', (e) => {
		$.get('includes/handlers/ajax/follow.php?id=' + $(e.target).data('id'), function (response) {
			if( response == 'followed' )
				$(this).html('UNFOLLOW').addClass('unsubscribe');
			else
				$(this).html('FOLLOW').removeClass('unsubscribe');
		}.bind(e.target));
		
		e.preventDefault();
	});
});
$(document).on('click', '#subscribeBtn', function(event) {
	// Subscribe button event handler
	$.post('includes/handlers/ajax/subscribe.php',
		{userTo: $(this).data('to'), userFrom: userId},
		function(response) {
			switch(response.msg) {
				case 'subscribed':
					$(this).val('Unsubscribe').addClass('unsubscribe');
					if( response.result ) {
						$('.num_subscribers').html('<span class="num_subscribers">' + response.result + ' subscribers</span>').show();
					}
					break;

				case 'unsubscribed':
					$(this).val('Subscribe').removeClass('unsubscribe');
					$('.num_subscribers').html('<span class="num_subscribers">' + response.result + ' subscribers</span>').show();
					if( response.result == 0 ) {
						$('.num_subscribers').hide();
					}
					break;
			}
		}.bind(this), 'json'
	);

	event.preventDefault();
});

$(document).click(function(click) {
	var target = $(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
		hideOptionsMenu();
	}
});

$(window).scroll(function() {
	hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
	var select = $(this);
	var playlistId = select.val();
	var songId = select.prev(".songId").val();

	$.post("includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId})
	.done(function(error) {

		if(error != "") {
			alert(error);
			return;
		}

		hideOptionsMenu();
		select.val("");
	});
});


function updateEmail(emailClass) {
	var emailValue = $("." + emailClass).val();

	$.post("includes/handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn})
	.done(function(response) {
		$("." + emailClass).nextAll(".message").text(response);
	})


}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
	var oldPassword = $("." + oldPasswordClass).val();
	var newPassword1 = $("." + newPasswordClass1).val();
	var newPassword2 = $("." + newPasswordClass2).val();

	$.post("includes/handlers/ajax/updatePassword.php",
		{ oldPassword: oldPassword,
			newPassword1: newPassword1,
			newPassword2: newPassword2,
			username: userLoggedIn})

	.done(function(response) {
		$("." + oldPasswordClass).nextAll(".message").text(response);
	})


}

function logout() {
	$.post("includes/handlers/ajax/logout.php", function() {
		location.reload();
	});
}

function openPage(url) {

	if(timer != null) {
		clearTimeout(timer);
	}

	if(url.indexOf("?") == -1) {
		url = url + "?";
	}

	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
}

function removeFromPlaylist(button, playlistId) {
	var songId = $(button).prevAll(".songId").val();

	$.post("includes/handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId })
	.done(function(error) {

		if(error != "") {
			alert(error);
			return;
		}

		//do something when ajax returns
		openPage("playlist.php?id=" + playlistId);
	});
}

function createPlaylist() {

	var popup = prompt("Please enter the name of your playlist");

	if(popup != null) {

		$.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
		.done(function(error) {

			if(error != "") {
				alert(error);
				return;
			}

			//do something when ajax returns
			openPage("yourMusic.php");
		});

	}

}

function deletePlaylist(playlistId) {
	var prompt = confirm("Are you sure you want to delte this playlist?");

	if(prompt == true) {

		$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
		.done(function(error) {

			if(error != "") {
				alert(error);
				return;
			}

			//do something when ajax returns
			openPage("yourMusic.php");
		});


	}
}

function hideOptionsMenu() {
	var menu = $(".optionsMenu");
	if(menu.css("display") != "none") {
		menu.css("display", "none");
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
	var left = $(button).position().left;

	menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline" });

}


function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60); //Rounds down
	var seconds = time - (minutes * 60);

	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100;
	$(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

function beamVocalEvent() {
	if( beamplay && !learning ) {
		// console.log(this.currentTime);
		if(this.clone_vocalLogs.length && this.vocalIndex < this.clone_vocalLogs.length) {
			entry = this.clone_vocalLogs[this.vocalIndex];
			if(this.currentTime > entry[0]) {
				console.log(this.currentTime, entry[0]);
				let status = !!entry[1];

				setVocals(!entry[1]);
				this.vocalIndex++;
			}
		}
	}
}

function beamBeatEvent() {
	if( beamplay && !learning ) {
		// console.log(this.currentTime);
		if(this.clone_beatLogs.length && this.beatIndex < this.clone_beatLogs.length) {
			entry = this.clone_beatLogs[this.beatIndex];
			if(this.currentTime > entry[0]) {
				console.log(this.currentTime, entry[0]);
				let status = !entry[1];

				setBeat(status);
				this.beatIndex++;
			}
		}
	}
}

function Audio() {

	this.currentlyPlaying;
	this.audio = null;

	this.createAudio = function(thefirst) {
		let audio = document.createElement('audio');

		if( thefirst ) {
			audio.addEventListener('timeupdate', beamVocalEvent);

			audio.addEventListener("ended", function() {
				learning = false;
				nextSong();
			});

			audio.addEventListener("canplay", function() {
				//'this' refers to the object that the event was called on
				var duration = formatTime(this.duration);
				$(".progressTime.remaining").text(duration);
			});

			audio.addEventListener("timeupdate", function(){
				if(this.duration) {
					updateTimeProgressBar(this);
				}
			});
			audio.addEventListener("volumechange", function() {
				updateVolumeProgressBar(this);
			});
		} else {
			audio.addEventListener('timeupdate', beamBeatEvent);
		}


		return audio;
	}

	this.audio = this.createAudio(true);
	this.audio2 = this.createAudio(false);

	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path1;
		this.audio2.src = track.path2;
	}

	this.play = function() {
		this.audio.play();
		this.audio2.play();
	}

	this.pause = function() {
		this.audio.pause();
		this.audio2.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
		this.audio2.currentTime = seconds;
	}

}