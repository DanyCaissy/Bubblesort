<?php

    header('Content-Type: application/json');

    require_once "../init.php";
    require_once "../classes/bubblesort.php";

    $bubblesort = new bubblesort(0, 100, 'red', 'yellow');

    $response = null;
    $response['status'] = 'Success';

    switch ($_POST['method'])
    {
        case 'getShuffle': // Shuffles the values and returns the result

            $shuffled = $bubblesort->getShuffled();

            $response['data'] = $shuffled;
            $_SESSION['bubblesort'] = $shuffled;

            break;
        case 'get': // Returns the values, if session is not set, shuffle them first

            $response = null;
            $response['status'] = 'Success';

            if (isset($_SESSION['bubblesort'])) // The data is saved in the session, return it
            {
                $response['data'] = $_SESSION['bubblesort'];
            }
            else // Session is empty, regenerate randomized values
            {
                $shuffled = $bubblesort->getShuffled();

                $response['data'] = $shuffled;
                $_SESSION['bubblesort'] = $shuffled;
            }

            break;

        case 'getStep': // Does one step then returns the values

            if (isset($_SESSION['bubblesort']))  // The data is saved in the session, do one more step
            {
                $shuffled = $bubblesort->getStep($_SESSION['bubblesort']);

                $response['data'] = $shuffled;
                $_SESSION['bubblesort'] = $shuffled;
            }
            else // Session is empty, regenerate randomized values
            {
                $shuffled = $bubblesort->getShuffled();

                $response['data'] = $shuffled;
                $_SESSION['bubblesort'] = $shuffled;
            }

            break;

        default: // Incorrect method name called, return relevant error
            $response = null;
            $response['status'] = 'Failure';
            $response['error'] = "Ajax method does not exist";
    }

echo json_encode($response);


