<?php
class User {

	private $con;
	private $username;
	private $profilePic;
	public $id;

	public function __construct($con, $username) {
		$this->con = $con;
		$this->username = $username;

		$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
		$profile = mysqli_fetch_array($query);
		$this->id = $profile['id'];

		$this->profilePic = $profile['profilePic'];
	}

	public static function fromID($con, $id) {
		$query = mysqli_query($con, "SELECT username FROM users WHERE id='$id'");
		$profile = mysqli_fetch_array($query);
		$user = new self($con, $profile['username']);
		
		return $user;
	}

	public static function isLoggedIn() {
    	return isset($_SESSION["userLoggedIn"]);
	}

	public function getprofilePic() {
		return $this->profilePic;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getEmail() {
		$query = mysqli_query($this->con, "SELECT email FROM users WHERE username='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['email'];
	}

	public function getFirstAndLastName() {
		$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name'  FROM users WHERE username='$this->username'");
		$row = mysqli_fetch_array($query);
		return $row['name'];
	}


    public function getSignUpDate() {
        return $this->sqlData["signUpDate"];
    }


	public function isSubscribedTo($userTo) {
        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $username);
        $username = $this->getUsername();
        $query->execute();
        return $query->rowCount() > 0;
    }

    public function getSubscriberCount() {
        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo");
        $query->bindParam(":userTo", $username);
        $username = $this->getUsername();
        $query->execute();
        return $query->rowCount();
    }
}
?>
