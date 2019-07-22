<?php
	class ArtistAccount {

		private $con;
		private $errorArray;

		public function __construct($con) {
			$this->con = $con;
			$this->errorArray = array();
		}



public function login($aun, $apw) {

			$apw = md5($apw);

			$query = mysqli_query($this->con, "SELECT * FROM artists WHERE name='$aun' AND artistPassword='$apw'");

			if(mysqli_num_rows($query) == 1) {
				return true;
			}
			else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}

		}




		public function register($aun, $afn, $aln, $aem, $aem2, $apw, $apw2) {
			$this->validateArtistUsername($aun);
			$this->validateArtistFirstName($afn);
			$this->validateArtistLastName($aln);
			$this->validateArtistEmails($aem, $aem2);
			$this->validateArtistPasswords($apw, $apw2);

			if(empty($this->errorArray) == true) {
				//Insert into db
				return $this->insertUserDetails($aun, $afn, $aln, $aem, $apw);
			}
			else {
				return false;
			}

		}
		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}
//this is where the update into the server slots begin
		private function insertUserDetails($aun, $afn, $aln, $aem, $apw) {
			$encryptedPw = md5($apw);
			$artistPic = "assets/images/profile-pics/head_artist.png";
			$artistSignUpDate = date("Y-m-d");

			$result = mysqli_query($this->con, "INSERT INTO artists VALUES ('', '$aun', '$afn', '$aln', '$aem', '$encryptedPw', '$artistSignUpDate', '$artistPic', '$artistPrice')");

			return $result;
			}

			//this is where the update into the server slots end

		private function validateArtistUsername($aun) {

			if(strlen($aun) > 25 || strlen($aun) < 5) {
				array_push($this->errorArray, "Your username must be between 5 and 25 characters");
				return;
			}

			$checkUsernameQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE name='$aun'");
			if(mysqli_num_rows($checkUsernameQuery) != 0) {
				array_push($this->errorArray, Constants::$artistUsernameTaken);
				return;
			}

		}

		private function validateArtistFirstName($afn) {
			if(strlen($afn) > 25 || strlen($afn) < 2) {
				array_push($this->errorArray, "Your first name must be between 2 and 25 characters");
				return;
			}
		}

		private function validateArtistLastName($aln) {
			if(strlen($aln) > 25 || strlen($aln) < 2) {
				array_push($this->errorArray, "Your last name must be between 2 and 25 characters");
				return;
			}
		}
/* OLD sorta works
		private function validateArtistEmails($aem, $aem2) {
			if($aem != $aem2) {
				array_push($this->errorArray, "Your emails don't match");
				return;
			}

			if(!filter_var($aem, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, "Email is invalid");
				return;
			}
			
*/



		private function validateArtistEmails($aem, $aem2) {
			if($aem != $aem2) {
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return;
			}

			if(!filter_var($aem, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}

		$checkEmailQuery = mysqli_query($this->con, "SELECT artistEmail FROM artists WHERE artistEmail='$aem'");
			if(mysqli_num_rows($checkEmailQuery) != 0) {
				array_push($this->errorArray, Constants::$emailTaken);
				return;
			}

		














			//TODO: Check that username hasn't already been used

		}

		private function validateArtistPasswords($apw, $apw2) {

			if($apw != $apw2) {
				array_push($this->errorArray, "Your passwords don't match");
				return;
			}

			if(preg_match('/[^A-Za-z0-9]/', $apw)) {
				array_push($this->errorArray, "Your password can only contain numbers and letters");
				return;
			}

			if(strlen($apw) > 30 || strlen($apw) < 5) {
				array_push($this->errorArray, "Your password must be between 5 and 30 characters");
				return;
			}
			
		}

	}
?>