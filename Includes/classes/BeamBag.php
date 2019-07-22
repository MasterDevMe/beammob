<?php
	class BeamBag {

		private $con;
		private $id;
		private $bagName;
		private $artistId;
		private $bagPrice;
		
		public function __construct($con, $id) {
			$this->con = $con;
			$this->id = $id;

			$query = mysqli_query($this->con, "SELECT * FROM beamBags WHERE id='$this->id'");
			$beamBag = mysqli_fetch_array($query);

			$this->bagName = $beamBag['bagName'];
			$this->artistId = $beamBag['artist'];
			$this->bagPrice = $beamBag['bagPrice'];
		

		}

		public function getBagName() {
			return $this->bagName;
		}

		public function getArtist() {
			return new Artist($this->artistId);

		}

		public function getBagPrice() {
			return $this->bagPrice;
		}





	}
?>