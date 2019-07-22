<?php
require_once("../../config.php");
include("../../classes/User.php");

if( isset($_SESSION['userLoggedIn']) ) {
    $userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
    $tbl_name = 'subscribers';

    if( isset($_POST['userTo']) ) {
        $userTo = (int) $_POST['userTo'];
        $userFrom = (int) $userLoggedIn->id;

        // check if the user is subbed
        $subscribed = $database->has($tbl_name, [
            'AND' => [
                'userFrom' => $userLoggedIn->id,
                'userTo' => $userTo
            ]
        ]);

        $count_subscribers = $database->count($tbl_name, [
            'userTo' => $userTo
        ]);

        if( !$subscribed ) {
            // INSERT subscriber information
            $database->insert($tbl_name, [
                'userFrom' => $userLoggedIn->id,
                'userTo' => $userTo
            ]);

            echo json_encode([
                'msg' => 'subscribed',
                'result' => $count_subscribers + 1
            ]);
        } else {
            // DELETE
            $database->delete($tbl_name, [
                'userFrom' => $userLoggedIn->id,
                'userTo' => $userTo
            ]);

            echo json_encode([
                'msg' => 'unsubscribed',
                'result' => $count_subscribers - 1
            ]);
        }
    }
    else {
        echo "One or more parameters are not passed into subscribe.php the file";
    }
}
?>
