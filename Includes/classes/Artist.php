<?php
class Artist {
	private $id;
	private $artistPic;
	private $artistId;
	private $artistPrice;

	public function __construct($id) {
		global $database;
		$artist = $database->get('artists', '*', ['id' => $id]);

		$this->id = $artist['id'];
		$this->artistPic = $artist['artistPic'];
		$this->artistId = $artist['id'];
		$this->artistPrice = $artist['artistPrice'];
	}

	static function getLoggedIn() {
		global $database;

		if( isset($_SESSION['userLoggedIn']) ) {
			$artist = $database->get('artists', '*', ['name' => $_SESSION['userLoggedIn']]);

			$classArtist = new self($artist['id']);

			return $classArtist;
		}
	}

	public function getartistPic() {
		return $this->artistPic;
	}

	public function getArtist() {
		return $this;
	}

	public function getArtistPrice() {
		return $this->artistPrice;
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		global $database;
		
		$name = $database->get('artists', 'name', ['id' => $this->getId()]);
		return $name;
	}

	// can delete this if it doesn't work to show artist pic
	public function getSongIds() {
		global $database;

		$result = $database->query('SELECT id FROM songs WHERE artist='.$this->id.' ORDER BY plays ASC')->fetchAll();

		return $result;

	}

	public function getSongs() {
		global $database;
		
		return $database->select('songs', '*', ['artist' => $this->id]);
	}

	public function getSubNum() {
		global $database;

		return $database->count('subscribers', [
			'userTo' => $this->id
		]);
	}
} ?>
