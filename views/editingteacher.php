<?php

// Print title
echo html_writer::tag('h2', get_string('plugintitle', 'gradereport_scgr') . ' : ' . $role );

// Print navigation
printCustomNav( $courseid, $role, $view );

if ( $view == 'default' ) {

    include_once('modules/custom_graph.php');

} else {

    echo 'view error';

}
