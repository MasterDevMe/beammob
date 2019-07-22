<?php include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$beamBagId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$beamBag = new BeamBag($con, $beamBagId);
$artist = $beamBag->getArtist();
$artistId = $artist->getId();
?>

<div class="entityInfo">

	<div class="leftSection">
		<img src='assets/images/icons/beambags.png'>
	</div>

	<div class="rightSection">
		<h2><?php echo $beamBag->getBagName();?>  Bag</h2>
		<p role="link" tabindex="0" onclick="openPage('artist.php?id=<?php echo $artistId; ?>')">By <?php echo $artist->getName(); ?></p>

		<input type="button" value="Buy" class="tinybutton" onclick="location.href='shopCart.php'">

		<p><h4><?php echo $beamBag->getBagPrice(); ?> usd</h4></p>



		<p role="link" tabindex="0" onclick="openPage('artist.php?id=<?php echo $artistId; ?>')">Download This Bag</p>

	</div>

</div>

