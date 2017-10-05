<?php

/* ######################  GRAPH FROM URL PARAMETERS  ###################### */

if ( isset($_GET['userid']) ) {

    echo 'Bonjour, vous êtes l\'utilisateur #' . $_GET['userid'] . ', grâce à cette information je vais pouvoir charger
            le graphique que vous désirez.';

} else {

    echo 'ERROR !';

}

