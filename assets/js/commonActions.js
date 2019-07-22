var songs = [], song;

function numberSongs() {
	return jQuery('#accorditionSongs').my().data.songs.length;
}

var _validSongFileExtensions = [".mp3", ".wav"];
var _validPhotoFileExtensions = [".jpg", ".png"];

function showErrorMsg(msg) {
	$('#errorMsg .modal-content .modal-body').html(msg);
	$('#errorMsg').modal();
}
function showMsg(msg) {
	$('#sucessMsg .modal-content .modal-body').html(msg);
	$('#sucessMsg').modal();
}

function redirectTo(url) {
	location.href = url;
}


function reloadWithMsg(msg) {
	redirectTo('uploadSong.php?msg=' + encodeURIComponent(msg));
}

const SHOW = true, HIDE = false;
function processingModal(status) {
	if( status )
		$("#loadingModal").modal('show');
	else
		$("#loadingModal").modal('hide');
}

function uploadingSongsCheck(numFiles, albumTitle) {
	this.albumTitle = albumTitle;
	this.totalFiles = numFiles;
	this.remainFiles = numFiles;
	this.finished = false;
	
	this.sub = () => {
		this.remainFiles-=1;
		console.log(this.remainFiles);
		
		if( this.remainFiles <= 0 )
			this.finished = true;
	};
	
	return this;
}

function validateFileName(oInput, fileExtensions) {
	if (oInput.type == "file") {
		var sFileName = oInput.files[0].name;
		
		 if (sFileName.length > 0) {
			var blnValid = false;
			for (var j = 0; j < fileExtensions.length; j++) {
				var sCurExtension = fileExtensions[j];
				if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
					blnValid = true;
					break;
				}
			}
			 
			if (!blnValid) {
				str = "Sorry, \"" + sFileName + "\" is invalid, allowed extensions are: " + fileExtensions.join(", ");
				showErrorMsg(str);
			}
		}
	}
}

async function handleUpload() {
	let action = '';
	let fd = null;
	
	switch(currentTab) {
		case 'nav-song-tab':
			frm = $('form.songUpload.asong-upload')[0];
			action = 'uploadSong';
			
			
			if( frm.checkValidity() ) {				
				processingModal(SHOW);
				
				fd = new FormData(frm);
				albumFd = new FormData();
				
				// Album
				albumFd.append('albumTitle', fd.get('songTitle'));
				albumFd.append('albumPrice', fd.get('songPrice'));
				albumFd.append('albumPhoto', $('input[name=songPhotoFile]', frm)[0].files[0]);
				albumFd.append('albumGenre', fd.get('albumGenre'));
				// console.log(albumFd);
				
				await $.ajax({
					url: 'Includes/handlers/ajax/uploadSong.php?action=createAlbum',
					data: albumFd,
					processData: false,
					contentType: false,
					dataType: 'json',
					type: 'POST',
					success: function(data) {
						// Completed
						if( data.status == 'done' ) {
							// Album ID
							this.append('albumId', data.id);
							
							$.ajax({
								url: 'Includes/handlers/ajax/uploadSong.php?action=uploadSong',
								data: this,
								processData: false,
								contentType: false,
								dataType: 'json',
								type: 'POST',
								success: function(data) {
									if( data.status == 'done' ) {										
										reloadWithMsg('Uploaded new song: ' + data.title);
									} else {
										showErrorMsg(data.msg);
									}
								}
							});
						} else {
							showErrorMsg(data.msg);
						}
					}.bind(fd)
				});
			}
			
			break;
		
		case 'nav-album-tab':
			frm = $('form.album-upload')[0];
			action = 'createAlbum';
			
			$songFrms = $('#nav-album.tab-pane form.song-upload');
			let err = false;
			
			for( i = 0; i < $songFrms.size(); i++ ) {
				if( $songFrms[i].checkValidity() == false ) {
					$('button[type="submit"]', $songFrms[i]).click();
					err = true;
				}
			}
			
			// Check album form
			if( !frm.checkValidity() ) {
				$('button[type="submit"]').click();
				err = true;
			}
			
			// Found error
			if( err ) {
				processingModal(HIDE);
				showErrorMsg("Please check upload information.");
			} else {
				processingModal(SHOW);
				
				fd = new FormData(frm);
				await $.ajax({
					url: 'Includes/handlers/ajax/uploadSong.php?action=' + action,
					data: fd,
					processData: false,
					contentType: false,
					dataType: 'json',
					type: 'POST',
					success: function(data) {
						let num_songs = $songFrms.size();
						if( num_songs ) {
							let um = new uploadingSongsCheck(num_songs, data.title);
							
							for( i = 0; i < num_songs; i++ ) {
								songUpload.call(um, $songFrms[i], data.id);
							}
						}
						// Completed
						if( data.status == 'done' ) {
							/*
							let msg = encodeURIComponent('Uploaded beambag file ' + data.fname);
							redirectTo('uploadSong.php?activeTab=' + action + '&msg=' + msg);
							*/
						} else {
							showErrorMsg(data.msg);
						}
					}
				});
			}
			break;
		
		case 'nav-beambag-tab':	
			frm = $('#nav-beambag.tab-pane form.beambagUpload')[0];
			action = 'uploadBeambag';
			
			fd = new FormData(frm);
			
			if( frm.checkValidity() ) {				
				processingModal(SHOW);
				await $.ajax({
					url: 'Includes/handlers/ajax/uploadSong.php?action=' + action,
					data: fd,
					processData: false,
					contentType: false,
					dataType: 'json',
					type: 'POST',
					success: function(data) {					
						// Completed
						processingModal(HIDE);
						if( data.status == 'done' ) {
							if( action == 'uploadBeambag' )
								reloadWithMsg('Created new beambag: ' + data.title);
							/*
							let msg = encodeURIComponent('Uploaded beambag file ' + data.fname);
							redirectTo('uploadSong.php?activeTab=' + action + '&msg=' + msg);
							*/
						} else {
							showErrorMsg(data.msg);
						}
					}
				});
			}
			break;
	}
}

async function songUpload(frm, albumId) {
	let fd = new FormData(frm);
	fd.append('albumId', albumId);
	
	return await $.ajax({
		url: 'Includes/handlers/ajax/uploadSong.php?action=uploadSong',
		data: fd,
		processData: false,
		contentType: false,
		dataType: 'json',
		type: 'POST',
		success: function(data) {			
			// Completed
			if( data.status == 'done' ) {
				this.sub();
				
				if( this.finished ) {
					// processingModal(HIDE);
					reloadWithMsg('Created album \"' + this.albumTitle + '\" with its songs');
				}
			} else {
				showErrorMsg(data.msg);
			}
		}.bind(this)
	});
}

var currentTab = 'nav-song-tab';

(async function() {	
	$(document).ready(function() {
		$('#artistLogout').click((event) => $.get("includes/handlers/ajax/logout.php", () => location.href = '/artistRegister.php'));
		
		$(".navShowHide").on("click", function() {		
			var main = $("#mainSectionContainer");
			var nav = $("#sideNavContainer");

			if(main.hasClass("leftPadding")) {
				nav.hide();
			}
			else {
				nav.show();
			}

			main.toggleClass("leftPadding");

		});
		
		$(document).on('click', '#nav-album form.album-upload ~ button[name="uploadButton"]', (e) => {
			$('#nav-album form.album-upload button[name=uploadButton]').click();
			
			event.preventDefault();
		});
		
		$('#nav-song.tab-pane select[name=songPrivacy]').change(function() {
			let cls = '#nav-song.tab-pane input[name=songPrice]';
			if( this.value == 1 ) {
				$(cls).val('0.00').attr('disabled', true);
				$(cls).after('<input type="hidden" name="songPrice" value="0.00" />');
			} else {
				$(cls).val('1.00').attr('disabled', false);
				$(cls + ' ~ input[type="hidden"][name="songPrice"]').remove();
			}
		});
		
		// Set current tab
		$('#nav-tab a[data-toggle="tab"]').on('shown.bs.tab', (e) => currentTab = e.target.id );
		
		$(document).on('submit', '#nav-tabContent .tab-pane form', function(event) {
			if (this.checkValidity() === false) {
				event.preventDefault();
				event.stopPropagation();
			}
			
			handleUpload();
			
			this.classList.add('was-validated');
			event.preventDefault();
		});
		
		// Missing file name for bootstrap form
		$(document).on('change', 'input[type="file"]',function(e){
			var fileName = e.target.files[0].name;
			
			$(this).next('.custom-file-label').html(fileName);
			
			if( $(this).hasClass('song-validation') ) {
				validateFileName(this, _validSongFileExtensions);
			}
			if( $(this).hasClass('photo-validation') ) {
				validateFileName(this, _validPhotoFileExtensions);
			}
		})

		song = {
			id: 0,
			order: 0,
			title: 'Song 1',
			featuredBy: '',
			productedBy: '',
			privacy: 0,
			price: 1,
			vocalFile: '',
			beatFile: '',
			fullSongFile: '',
			songPhotoFile: ''
		};
		
		var songsManifest = {
			data: { songs: [{ id: () => numberSongs(), title: 'Song 1', order: 0 }] },
			init: function ($node, runtime ) {
				$node.html('<button type="button" id="addSong" class="btn btn-primary mb-3"><span class="oi oi-plus mr-2"></span>Add more song</button><div id="accorditionSongs"><div class="song mb-3"></div></div>');
				jQuery('#accorditionSongs', $node).sortable();
			},
			ui: {
				'#accorditionSongs': {
					bind: 'songs',
					manifest: 'songManifest',
					list: '>.song',
				},
				'#addSong': function (data, val ) {
					if( null != val ) this.my.insert('#accorditionSongs', { id: () => numberSongs(), title: 'Song ' + (numberSongs() + 1), order: numberSongs() });
					
					$('.songUpload ~ h5 >.badge.badge-secondary').html(data.songs.length);
				}
			},
			songManifest: {
				data: {},
				init: function ($node, runtime ) {
					$node.html('<!-- CARD HEADER -->\
		<div class="card-header">\
			<h2 class="mb-0">\
				<button class="btn btn-handle" type="button" data-toggle="collapse" data-target="#collapse' + runtime.data.id() + '" aria-expanded="true" aria-controls="collapse' + runtime.data.id() + '"><span class="oi oi-menu"></span>&nbsp;<span class="songTitle"></span></button>\
				<button type="button" class="btn btn-danger float-right"><span class="oi oi-circle-x mr-2"></span>Remove</button>\
			</h2>\
		</div>\
		\
		<!-- CARD BODY -->\
		<div id="collapse' + runtime.data.id() + '" class="collapse" aria-labelledby="headingOne" data-parent="#accorditionSongs">\
			<div class="card-body">\
			<form class="songUpload song-upload" action="" method="POST" novalidate enctype="multipart/form-data">\
				<input type="hidden" name="songOrder" />\
				<div class="input-group mb-3">\
					<div class="input-group-prepend"><span class="input-group-text">Song title</span></div>\
					<input required name="songTitle" type="text" class="form-control">\
				</div>\
				<div class="input-group">\
					<div class="input-group-prepend"><span class="input-group-text">Featuring by</span></div>\
					<input required type="text" name="featuredBy" aria-describedby="featuredHelpBlock" class="form-control">\
				</div>\
				<small class="form-text text-muted mb-3" id="featuredHelpBlock">(Separate by commas)</small>\
				<div class="input-group">\
					<div class="input-group-prepend"><span class="input-group-text">Produced by</span></div>\
					<input required name="producedBy" type="text" aria-describedby="productedHelpBlock" class="form-control">\
				</div>\
				<small class="form-text text-muted mb-3" id="productedHelpBlock">(Separate by commas)</small>\
				<div class="input-group mb-3">\
					<div class="input-group-pretend"><label for="" class="input-group-text">Privacy</label></div> <select name="songPrivacy" id="" class="custom-select">\
						<option value="0">Private (for sale only)</option>\
						<option value="1">Public (stream promo only)</option>\
					</select>\
				</div>\
				<div class="input-group mb-3">\
					<div class="input-group-prepend"><span class="input-group-text">Price</span></div> <input pattern="[\\d]+[\\.]*[\\d]*" required name="songPrice" type="text" class="form-control" placeholder="1.00">\
					<div class="input-group-append"> <span class="input-group-text">$</span>\
					<div class="invalid-feedback">Please enter a numberic price</div>\
					</div>\
				</div>\
				<div class="input-group mb-3">\
					<div class="input-group-prepend">\
						<div class="input-group-text"><span class="oi oi-file"></span>&nbsp;Vocal file</div>\
					</div>\
					<div class="custom-file"> <input required name="vocalFile" type="file" class="custom-file-input song-validation"> <label class="custom-file-label">Choose file</label> </div>\
				</div>\
				<div class="input-group mb-3">\
					<div class="input-group-prepend">\
						<div class="input-group-text"><span class="oi oi-file"></span>&nbsp;Beat file</div>\
					</div>\
					<div class="custom-file"> <input required name="beatFile" type="file" class="custom-file-input song-validation"> <label class="custom-file-label">Choose file</label> </div>\
				</div>\
				<div class="input-group mb-3">\
					<div class="input-group-prepend">\
						<div class="input-group-text"><span class="oi oi-file"></span>&nbsp;Full song file</div>\
					</div>\
					<div class="custom-file"> <input required name="fullsongFile" type="file" class="custom-file-input song-validation"> <label class="custom-file-label">Choose file</label> </div>\
				</div>\
				<div class="input-group mb-3">\
					<div class="input-group-prepend">\
						<div class="input-group-text"><span class="oi oi-file"></span>&nbsp;Songs photo file</div>\
					</div>\
					<div class="custom-file"><input required type="file" class="custom-file-input photo-validation" name="songPhotoFile"> <label class="custom-file-label">Choose file</label> </div>\
				</div>\
				<button type="submit" class="invisible"></button>\
			</form>\
			</div>\
		</div>');
				},
				
				// Bindings
				ui: {
					'.songTitle': {
						bind: function( data, val, node ) {
							return data.title;
						},
						watch: 'input[name=songTitle]'
					},
					'input[name=songOrder]': { bind: function(data, val, node) {
						let order = jQuery(node).parents('.song').index('#accorditionSongs .song');
						data.order = order;
						
						return order;
					}},
					'input[name=songTitle]': { bind: 'title' },
					'input[name=featuredBy]': { bind: 'featuredBy' },
					'input[name=producedBy]': { bind: 'producedBy' },
					'select[name=songPrivacy]': { bind: 'songPrivacy', check: function(data, value, node) {
						let cls = $(node).parents('form').find('input[name=songPrice][type="text"]');
						
						// If song privacy is public
						if( value == 1 ) {							
							$(cls).val('0.00').attr('disabled', true);
							$(cls).after('<input type="hidden" name="songPrice" value="0.00" />');
						} else {
							$(cls).val('1.00').attr('disabled', false);
							$(cls).siblings('input[type="hidden"][name="songPrice"]').remove();
						}
					} },
					'input[name=songPrice]': { bind: 'price' },
					'.btn-danger': {
						bind: function (data, val) {
							if (null != val) this.my.remove();
							
							jQuery.delay(100, function() {
								$('#songUpload > h5 >.badge.badge-secondary').html(numberSongs());
							});
						},
						events:"click.my"
					}
				}
			}
		};
		
		if( $('#nav-album .songs-container').size() )
			$('#nav-album .songs-container').my(songsManifest, songs);
	});
})();