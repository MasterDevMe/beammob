<?php
	class Song {

		private $con;
		private $id;
		private $mysqliData;
		private $title;
		private $artstId;
		private $albumId;
		private $genre;
		private $duration;
		private $path1;
		private $path2;
		private $mixdown;
		private $producer;
		private $feature;
		private $privacy;


		public function __construct($con, $id) {
			$this->con = $con;
			$this->id = $id;

			$query = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
			$this->mysqliData = mysqli_fetch_array($query);
			$this->title = $this->mysqliData['title'];
			$this->artstId = $this->mysqliData['artist'];
			$this->albumId = $this->mysqliData['album'];
			$this->genre = $this->mysqliData['genre'];
			$this->duration = $this->mysqliData['duration'];
			$this->path1 = $this->mysqliData['path1'];
			$this->path2 = $this->mysqliData['path2'];
			$this->mixdown = $this->mysqliData['mixdown'];
			$this->producer = $this->mysqliData['producer'];
			$this->feature = $this->mysqliData['feature'];
			$this->privacy = $this->mysqliData['privacy'];




		}

		public function getTitle() {
			return $this->title;
		}

		public function getId() {
			return $this->id;
		}

		public function getArtist() {
			return new Artist($this->artstId);
		}

		public function getAlbum() {
			return new Album($this->con, $this->albumId);
		}

		public function getPath1() {
			return $this->path1;
		}

		public function getPath2() {
			return $this->path2;
		}

		public function getMixdown() {
			return $this->mixdown;
		}

		public function getProducer() {
			return $this->producer;
		}

		public function getFeature() {
			return $this->feature;
		}

		public function getPrivacy() {
			return $this->privacy;
		}

		public function getDuration() {
			return $this->duration;
		}

		public function getGenre() {
			return $this->genre;
		}

		public function getMysqliData() {
			return $this->mysqliData;
		}


	}
?>