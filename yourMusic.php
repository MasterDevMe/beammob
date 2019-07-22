<?php
include("includes/includedFiles.php");
?>

<div class="playlistsContainer">

	<div class="gridViewContainer">
		<h1>PLAYLISTS </h1>
		<h3>Every month we showcase new art pieces as playlist icons.</h3>
		

		<div class="buttonItemsYourMusic">
			<button class="button green" onclick="createPlaylist()">NEW PLAYLIST</button>
		</div>



		<?php
			$username = $userLoggedIn->getUsername();

			$playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE curator='$username'");

			if(mysqli_num_rows($playlistsQuery) == 0) {
				echo "<span class='noResults'>You don't have any playlists yet.</span>";
			}
			
			while($row = mysqli_fetch_array($playlistsQuery)) {
				$playlist = new Playlist($con, $row);

				echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
						<div class='playlistImage'>
							<img src='assets/images/icons/playlist.png'>
						</div>
						<div class='playlistText'>"
							. $playlist->getName() .
						"</div>
					</div>";
			}
		?>
		
		<h2>USERS</h2>
		
		<div class="gridViewContainer">
			<?php
				$users = $database->select('users',['id', 'profilePic', 'username'], ['id[!]' => $userLoggedIn->id]);

				foreach($users as $u) {
					echo "<div class='gridViewItem'>
							<span role='link' tabindex='0' onclick='openPage(\"userProfile.php?id=" . $u['id'] . "\")'>
								<img src='" . $u['profilePic'] . "'>

								<div class='gridViewInfo'>"
									. $u['username'] .
								"</div>
							</span>

						</div>";
				}
			?>
		</div>
	</div>

</div>