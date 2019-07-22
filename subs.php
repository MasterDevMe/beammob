<?php include("includes/includedFiles.php"); ?>
<div class="entityInfo">
	<div class="centerSection">
		<div class="userInfo">
			<div class="profile">
				<img src="<?php echo $userLoggedIn->getprofilePic(); ?>">
			</div>
			<h1><?php echo $userLoggedIn->getUsername(); ?></h1>
		</div>
	</div>
</div>

<div class="tracklistContainer borderBottom">
	<h2>SUBSCRIBERS</h2>
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

<div class="tracklistContainer borderBottom">
	<h2>SUBSCRIBED TO</h2>
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






<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
