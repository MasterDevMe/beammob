<?php
include("includes/includedFiles.php");

$isMyselfProfile = false;
$upUserId = null;
if(isset($_GET['id']))
{
	$upUserId = $_GET['id'];
}

if( !isset($upUserId) ) {
	$user = $userLoggedIn;
	$isMyselfProfile = true;
} else {
	
	if(is_numeric($upUserId))
	{
		$user = User::fromID($con, $upUserId);
	}
	else
	{
		$user = new User($con, $upUserId);
		if(isset($user->id))
		{
			$upUserId = $user->id;
		}
	}
}

?>
<div class="entityInfo">
	<div class="centerSection">
		<div class="userInfo">
			<div class="profile">
				<img src="<?php echo $user->getprofilePic(); ?>">
			</div>
			<h1><?php echo $user->getUsername(); ?></h1>
			
			<?php if( !$isMyselfProfile ) :
				global $database;
				
				if( $database->has('follows', ['AND' => ['followFrom' => $userLoggedIn->id, 'followTo' => $upUserId ]]) )
					$followed = true;
				?>
				<div style="text-align: center;">
					<a href="#" class="tinybutton follow-btn <?php echo $followed ? 'unsubscribe' : ''; ?>" data-id="<?php echo $upUserId; ?>">
						<?php echo $followed ? 'UNFOLLOW' : 'FOLLOW'; ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>


<div class="tracklistContainer borderBottom">
	<h2>ALBUMS PURCHASED</h2>
</div>

<div class="gridViewContainer">
	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 200");

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


<div class="tracklistContainer borderBottom">
	<h2>ARTISTS CURRENTLY OWNED</h2>
</div>

<div class="gridViewContainer">
	<?php
		$ownershipQuery = mysqli_query($con, "SELECT * FROM artists ORDER BY RAND() LIMIT 10");

		while($row = mysqli_fetch_array($ownershipQuery)) {
			echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artistPic'] . "'>

						<div class='gridViewInfo'>"
							. $row['name'] .
						"</div>
					</span>

				</div>";
		}
	?>
</div>




<div class="playlistsContainer">
	<div class="gridViewContainer">
		<div class="tracklistContainer borderBottom">
		<h2>PLAYLISTS CREATED</h2>
	</div>
		<h3>Every month we showcase new art pieces as playlist icons.</h3>
		<?php
			$username = $user->getUsername();

			$playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE curator='$username'");

			if(mysqli_num_rows($playlistsQuery) == 0) {
				echo "<span class='noResults'>You don't have any playlists yet.</span>";
			}

			while($row = mysqli_fetch_array($playlistsQuery)) {

				$playlist = new Playlist($con, $row);

				echo "<div class='gridViewItem' role='link' tabindex='0'
							onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>

						<div class='playlistImage'>
							<img src='assets/images/icons/playlist.png'>
						</div>

						<div class='playlistText'>"
							. $playlist->getName() .
						"</div>

					</div>";
			}
		?>
	</div>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $user->getUsername()); ?>
</nav>
