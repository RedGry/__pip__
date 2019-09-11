<?php
include 'utils.php';

session_start();
if (!isset($_SESSION['results'])) {
    $_SESSION['results'] = [];
}

// TODO: check params here



switch (count($_GET)) {
    case 1:
        if ($_GET['needAreasImage'] == 'true') {
            renderAreasImg();
            break;
        } elseif ($_GET['needResultFromHistory'] == 'true') {
            renderHistoryPage();
            break;
        }
    default:
        if ($_GET['needResult'] == 'true'){
            renderResultPage();
            break;
        }
        http_response_code(400);
        renderError('wrong parameters');
}
?>

