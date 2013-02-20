<?php

require( "config.php" );
session_start();
$action = isset($_GET['action']) ? $_GET['action'] : "";
if (!$action)
    $action = isset($_POST['action']) ? $_POST['action'] : "";

// If the user isn't logged in and they're trying to access a protected page,
// display the login form and exit
if (!User::getLoggedInUser() && $action != "login" && $action != "logout"
        && $action != "signup" && $action != "sendPassword") {
    login();
    exit;
}

// Carry out the appropriate action
if (!in_array($action, array('login', 'logout', 'searchClient', 'clientDetail',
            'searchItem', 'itemDetail', 'ultimiAcquisti', 'aqcuistiMaggiori',
            'matNonAqcuist', 'storicoPrezzi', 'getLog', 'changePassword'), true))
    $action = 'goHome';
$action();

/**
 * Logs the user in
 */
function login() {
    $results = array();
    $results['errorReturnAction'] = "login";
    $results['errorMessage'] = "Incorrect email address or password. Please try again.";
    if (isset($_POST['login'])) {
        // User has posted the login form: attempt to log the user in
        if ($user = User::getByUsername($_POST['username'])) {
            if ($user->checkPassword($_POST['password'])) {
                // Login successful: Create a session and redirect to the to-do list
                $user->createLoginSession();
                
                if ($_SESSION['userType'] != 'admin') { // don't log admin user activity
                    $logMsg = $_SESSION['userId'] . " ha fatto login"; //log
                    Log::insertLog($logMsg, 1);                   
                }

                header("Location: " . APP_URL);
            } else {
                // Login failed: display an error message to the user
                require( TEMPLATE_PATH . "/errorDialog.php" );
            }
        } else {
            // Login failed: display an error message to the user
            require( TEMPLATE_PATH . "/errorDialog.php" );
        }
    } else {
// User has not posted the login form yet: display the form
        require( TEMPLATE_PATH . "/loginForm.php" );
    }
}

/**
 * Logs the user out
 */
function logout() {
    if ($_SESSION['userType'] != 'admin') { // don't log admin user activity
        $logMsg = $_SESSION['userId'] . " ha fatto logout"; //log
        Log::insertLog($logMsg, 4);
    }
    User::destroyLoginSession();
    header("Location: " . APP_URL);
}

/**
 * Go to the main page
 */
function goHome() {
    require( TEMPLATE_PATH . "/homeScreen.php" );
}

/**
 * Search for clients
 */
function searchClient() {
    if (isset($_POST['cerca'])) {
        $results = array();
        $results['clients'] = Client::getClientList($_POST['searchTerm'], $_POST['clientSearchOptions']);
        require( TEMPLATE_PATH . "/searchClientForm.php" );
    } else {
        require( TEMPLATE_PATH . "/searchClientForm.php" );
    }
}

/**
 * Client details page
 */
function clientDetail() {
    $results['client'] = Client::getClientById($_GET['clientId']);
    $_SESSION['clientId'] = $results['client']->codice;
    $_SESSION['ragSociale'] = $results['client']->ragSociale;
    $_SESSION['fasciaSconto'] = $results['client']->categoriaSconto;
    
    if ($_GET['back'] == "") { //check that the user has not clicked the back button in the detail screens
        if ($_SESSION['userType'] != 'admin') { // don't log admin user activity
            $logMsg = $_SESSION['userId'] . " ha cercato cliente : " . $_SESSION['ragSociale']; //log the search
            Log::insertLog($logMsg, 3);
        }
    }
    require( TEMPLATE_PATH . "/clientDetailForm.php" );
}

/**
 * Search items page
 */
function searchItem() {
    if (isset($_POST['cerca'])) { // user is posting the form.
        $_SESSION['searchTerm'] = $_POST['searchTerm'];
        $_SESSION['itemSearchOptions'] = $_POST['itemSearchOptions'];
        $results['items'] = Item::getItemList($_POST['searchTerm'], $_SESSION['fasciaSconto'], $_POST['itemSearchOptions']);

        if ($_SESSION['userType'] != 'admin') { // don't log admin user activity
            $logMsg = $_SESSION['userId'] . " ha cercato articolo : " . $_POST['searchTerm']; //log the search
            Log::insertLog($logMsg, 3);
        }

        require( TEMPLATE_PATH . "/searchItemForm.php" );
        
    } else if (isset($_GET['searchTerm'])) { //user is coming back from details page, so we have to preserve search results.
        $results['items'] = Item::getItemList($_GET['searchTerm'], $_SESSION['fasciaSconto'], $_SESSION['itemSearchOptions']);
        require( TEMPLATE_PATH . "/searchItemForm.php" );
    } else {
        require( TEMPLATE_PATH . "/searchItemForm.php" );
    }
}

/**
 *
 *  Item details page
 */
function itemDetail() {
    $_SESSION['itemId'] = $_GET['itemId'];
    $results['item'] = Item::getItemById($_GET['itemId'], $_SESSION['fasciaSconto']);
    require( TEMPLATE_PATH . "/itemDetailForm.php" );
}

/**
 *
 *  Storico prezzi applicati  a un cliente per l'articolo selezionato
 */
function storicoPrezzi() {
    $results['salesHistory'] = SalesHistory::getItemPriceHistory($_SESSION['itemId'], $_SESSION['clientId']);
    require( TEMPLATE_PATH . "/itemSalesHistory.php" );
}

/**
 *
 *  Storico acquisti di un cliente
 */
function ultimiAcquisti() {
    $results['salesHistory'] = SalesHistory::getClientSalesHistory($_GET['clientId']);
    require( TEMPLATE_PATH . "/clientSalesHistoryForm.php" );
}

/**
 *
 *  Storico acquisti maggiori di un cliente
 */
function aqcuistiMaggiori() {
    $results['salesHistory'] = SalesHistory::getClientMaggiorSalesHistory($_GET['clientId']);
    require( TEMPLATE_PATH . "/MagggiorSalesHistoryForm.php" );
}

/**
 *
 *  Consulta il log
 */
function getLog() {
    if ($_SESSION['userType'] == 0) { //if user is admin show the log screen
        $results['log'] = Log::getLogForToday();
        require( TEMPLATE_PATH . "/logDetail.php" );
    } else {
        logout();
    }
}

/**
 * Change the user's password
 * 
 */
function changePassword() {

}

/**
 * Checks the supplied anti-CSRF token is valid
 * If it isn't, the user is logged out
 */
function checkAuthToken() {
    if (!isset($_POST['authToken']) || $_POST['authToken'] != $_SESSION
            ['authToken']) {
        logout();
        return false;
    } else {
        return true;
    }
}

?>