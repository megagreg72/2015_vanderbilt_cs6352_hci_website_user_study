<?php
include_once 'psl-config.php';
 
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

function login($email, $password, $conn) {
    error_log('email: ' . print_r($email, true));
    error_log('password: ' . print_r($password, true));
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $conn->prepare("SELECT id, name, password, salt 
        FROM teams
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_id, $name, $db_password, $salt);
        $stmt->fetch();
 
        //$password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
          error_log('login found 1 matching team');
          error_log('user_id: ' . print_r($user_id, true));
          error_log('name: ' . print_r($name, true));
          error_log('db_password: ' . print_r($db_password, true));
          error_log('salt: ' . print_r($salt, true));
          // hash the password with the unique salt.
          $hashedPassword = hash('sha512', $password . $salt);
          error_log('hashedPassword: ' . print_r($hashedPassword, true));
            // If the user exists we check if the account is locked
            // from too many login attempts 
 /*
            if (checkbrute($user_id, $conn) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                return false;
            } else {
*/
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $hashedPassword) {
                    error_log('password matches!');
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    //$user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    //$name = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                    //                                            "", 
                    //                               $name);
                    $_SESSION['name'] = $name;
                    $_SESSION['login_string'] = hash('sha512', 
                              $hashedPassword . $user_browser);
                    // Login successful.
                    return true;
                } 
                else {
                    // Password is not correct
                    // We record this attempt in the database
                //    $now = time();
                //    $conn->query("INSERT INTO login_attempts(user_id, time)
                //                    VALUES ('$user_id', '$now')");
                    return false;
                }
  //          }
        } else {
            // No user exists.
            return false;
        }
    }
}
/*
function checkbrute($user_id, $conn) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $conn->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}
*/
function login_check($conn) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['name'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['name'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $conn->prepare("SELECT password 
                                      FROM teams
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

