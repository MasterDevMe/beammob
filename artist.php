<?php
include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$artistId = $_GET['id'];
} else {
	header("Location: index.php");
}

$artist = new Artist($artistId);



////////////


if(isset($_GET['id'])) {
	$artistPicId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$artistPicture  = $artist->getartistPic();
$artistId = $artist->getId();
?>
<div class="ownerbox">
	<table style="border:none #AAAAAA solid; background: url(); padding:0 0 2px 0;" cellspacing="0" cellpadding="0">
	    <tbody>
			<tr>
				<td></td>
			    <td>
				    <table cellspacing="0" cellpadding="3">
						<tbody>
							<tr>
								<td>
									<table style="width:10px;padding:1px" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td>
													<a href="#" target="_top"><img src="assets/images/profile-pics/becky.png" width="50" height="50" alt="Juicy Girl"></a>
												</td>
											</tr>
										</tbody>

									</table>
								</td>
								<td valign="middle">
								    <div>
								    	<a href="#" class="noneYet">USER NAME</a> owns this artist at <b><font style="color:#55b2f6"> <?php echo $artist->getArtistPrice(); ?></font></b>   usd
								 	</div>

								    Buyout Price:
								    <input type='number'name="amount" value="<?php echo $artist->getArtistPrice() + 1.99; ?>" size="3">
								    <input type="button" value="Buy" class="tinybutton" onclick="location.href='signup.php'">
							    </td>
							</tr>
						</tbody>
					</table>
			    </td>
			</tr>
		</tbody>
	</table>
</div>



<div class="entityInfo borderBottom">
	<div class="centerSection">
		<div class="artistInfo">
			<img src="<?php echo $artist->getartistPic(); ?>">
			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>

			<div class="subscribers-container">
				<?php
				$subscribed = $database->count('subscribers', array(
					'userFrom' => $id,
					'userTo' => $artist->getId()
				));
				$countSub = $artist->getSubNum();

				print('<span class="num_subscribers">');
				if( $countSub ) {
					printf('%d subscribers', $countSub);
				}
				print('</span>'); ?>

				<h4><input type="button" value="<?php echo $subscribed == 0 ? 'Subscribe' : 'Unsubscribe'; ?>" class="tinybutton subscribe-btn <?php echo $subscribed ? 'unsubscribe' : ''; ?>" data-to="<?php echo $artistId; ?>" id="subscribeBtn"></h4>
			</div>

			<div class="headerButtons">
				<button class="button green" onclick="playFirstSong()">PLAY</button>
			</div>
		</div>
	</div>
</div>


<div class="tracklistContainer borderBottom">
	<h2>SONGS</h2>
	<ul class="tracklist">
		<?php
		$songIdArray = $artist->getSongIds();

		$i = 1;
		foreach($songIdArray as $song) {
			$songId = $song['id'];

			if($i > 5) {
				break;
			}

			$albumSong = new Song($con, $songId);

			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . ' - produced by ' .  $albumSong->getProducer().' ' . $albumSong->getFeature() .  "</span>
						<span class='artistName'>" . $artist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
						<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>


				</li>";

			$i = $i + 1;
		}

		?>

		<script>
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>
	</ul>
</div>

<div class="tracklistContainer borderBottom">
	<div class="gridViewContainer">
		<h2>ALBUMS</h2>
		<?php
			$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

			while($row = mysqli_fetch_array($albumQuery)) {
				echo "<div class='gridViewItem'>
						<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
							<img src='" . $row['artworkPath'] . "'>
							<div class='gridViewInfo'>"
								. $row['title'] .
							"</div>
						</span>
					</div>";
			}
		?>
	</div>
</div>
</div>

<div class="tracklistContainer borderBottom">
	<div class="gridViewContainer">
		<h2>SUBSCRIBERS</h2>
		<?php
		$subscriber_list = $database->select('subscribers', ['[><]users' => ['subscribers.userFrom' => 'id']], ['users.username', 'users.profilePic'], ['subscribers.userTo' => $artistId]);

		foreach( $subscriber_list as $index => $val ) {
			printf('<div class="subscriber-profile"><img src="%s" /><a href="#">%s</a></div>', $subscriber_list[$index]['profilePic'], $subscriber_list[$index]['username']);
		}
		?>
		<div class="clear"></div>
	</div>
</div>


<div class="gridViewContainer">
	<h2>Beam Bags&trade; (Owner only)</h2> <div class="beamText"> Get tons of updated downloadable items ie. poems, unreleased songs, remixes, and more. </div>
	<?php
		$beamBagQuery = mysqli_query($con, "SELECT * FROM beamBags WHERE artist='$artistId'");

		while($row = mysqli_fetch_array($beamBagQuery)) {
			echo "<div class='gridViewItem'>
			<span role='link' tabindex='0' onclick='openPage(\"beambag.php?id=" . $row['id'] . "\")'>
						<img src='assets/images/icons/beambags.png'>
						<div class='gridViewInfo'>"
							. $row['bagName'] .
						"</div>
				</div>";
		}
	?>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
