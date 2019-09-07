<?php
include_once 'includes/functions.php';
include_once 'includes/db_functions.php';
sec_session_start();

      $error_msg = '';
      //error_log('opening_id: ' . $_POST['opening_id']);
      //error_log('summoner_name: ' . $_POST['summoner_name']);
      //error_log('summoner_data: ' . print_r($_POST['summoner_data'], true));
      if(isset ($_POST['opening_id'], $_POST['summoner_name'], $_POST['summoner_data'])){
        $conn->autocommit(FALSE);
        $summonerName = $_POST['summoner_name'];
        $summonerData = $_POST['summoner_data'];
        $openingId = $_POST['opening_id'];
        
        //error_log('summoner_data: ' . print_r($summonerData, true));
        $summonerId = $summonerData["id"];
        //error_log('summonerId: ' . print_r($summonerId, true));

        $error_msg .= insertSummoner($conn, $summonerData);
        //$summonerId = getSummonerId($conn, $username);
        $opening = getOpening($conn, $openingId);

        $roleId = $opening['role_id'];
        $role = getPrettyRoleName($conn, $roleId);
        $teamId = $opening["team_id"];
        $teamName = getTeamName($conn, $teamId);

        insertApplication($conn, $openingId, $summonerId);
        
        // send response to AJAX
        $response_array = [];
        if($error_msg != ''){
          $conn->close();
          $response_array = array('status' => 'error','message'=> $error_msg);
        }
        else{
          $conn->commit();
          $conn->autocommit(TRUE);
          $response_array = array('status' => 'success','message'=> 'hooray! success!');
          //header('Location: ./register_success.php');
        }
        header('Content-type: application/json');
        echo json_encode($response_array);

/*
        echo '<div id="header2">Application Sent!</div><br>';
        echo '<div id="item">';
        echo 'You applied as ' . $summonerName . ' to be a ' . $role . ' at ' . $teamName . '.<br>' ;
        //echo 'You will recieve an email if they accept you.<br>';
        echo 'They should message you in-game if they accept you.<br>';
        echo '</div>';
      }
*/
      }
      else{
        echo 'Oops! You should not access this page this way.';
      }
    ?>
