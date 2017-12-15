<?php

// Print title
echo html_writer::tag('h2', get_string('plugintitle', 'gradereport_scgr') . ' : ' . $role );

// Print navigation
printCustomNav( $courseid, $role, $view );

if ( $view == 'progression' || $view == 'default' ) {

    echo '<p>Le tuteur peut voir la progression de ses apprenants (leur réussite sur différentes activités au choix)</p>';
    $chart2 = new \core\chart_line();
    $chart2->set_title('Graph #3 : TUT - Group students progression');
    $chart2->set_smooth(true); // Calling set_smooth() passing true as parameter, will display smooth lines.
    $CFG->chart_colorset = ['#001f3f', '#11ad55', '#d6d6d6', '#a0a0a0', '#b27b7b', '#7bb28a', '#7b86b2', '#ad7bb2', '#b27b9a'];
    $series1 = new core\chart_series('User1', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
    $series2 = new core\chart_series('User2', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
    $series3 = new core\chart_series('User3', [62, 87, 68, 90, 87, 73, 81, 0, 0, 0]);
    $series4 = new core\chart_series('User4', [73, 62, 63, 92, 78, 79, 82, 0, 0, 0]);
    $series5 = new core\chart_series('User5', [78, 72, 76, 72, 68, 59, 62, 0, 0, 0]);
    $series6 = new core\chart_series('User6', [88, 66, 59, 75, 70, 64, 76, 0, 0, 0]);
    $series7 = new core\chart_series('User7', [80, 69, 59, 70, 73, 60, 78, 0, 0, 0]);
    $series8 = new core\chart_series('User8', [52, 77, 58, 80, 77, 63, 71, 0, 0, 0]);
    $series9 = new core\chart_series('User9', [63, 52, 53, 82, 68, 69, 72, 0, 0, 0]);
    $series10 = new core\chart_series('User10', [68, 62, 66, 62, 58, 49, 72, 0, 0, 0]);
    $series2->set_type(\core\chart_series::TYPE_LINE); // Set the series type to line chart.
    $chart2->add_series($series1);
    $chart2->add_series($series2);
    $chart2->add_series($series3);
    $chart2->add_series($series4);
    $chart2->add_series($series5);
    $chart2->add_series($series6);
    $chart2->add_series($series7);
    $chart2->add_series($series8);
    $chart2->add_series($series9);
    $chart2->add_series($series10);
    $chart2->set_labels(['act1', 'act2', 'act3', 'act4', 'act5', 'act6', 'act7', 'act8', 'act9', 'act10']);
    echo $OUTPUT->render($chart2);


} elseif( $view == 'comparison' ) {

    echo '<p>Le tuteur peut comparer la réussite sur différentes activités (au choix) pour chaque apprenant de son groupe</p>';
    $chart4 = new core\chart_bar();
    $chart4->set_title('Graph #4 : TUT - Comparison');
    $CFG->chart_colorset = ['#001f3f', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#11ad55'];
    $series1 = new core\chart_series('Act1', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
    $series2 = new core\chart_series('Act2', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
    $series3 = new core\chart_series('Act3', [62, 87, 68, 90, 87, 73, 81, 0, 0, 0]);
    $series4 = new core\chart_series('Act4', [73, 62, 63, 92, 78, 79, 82, 0, 0, 0]);
    $series5 = new core\chart_series('Act5', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
    $series6 = new core\chart_series('Act6', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
    $series7 = new core\chart_series('Moyenne', [85, 79, 67, 83, 73, 80, 68, 0, 0, 0]);
    $chart4->add_series($series1);
    $chart4->add_series($series2);
    $chart4->add_series($series3);
    $chart4->add_series($series4);
    $chart4->add_series($series5);
    $chart4->add_series($series6);
    $chart4->add_series($series7);
    $chart4->set_labels(['user1', 'user2', 'user3', 'user4', 'user5', 'user6', 'user7', 'user8', 'user9', 'user10']);
    echo $OUTPUT->render($chart4);

} elseif( $view == 'custom' ) {

   include_once('modules/custom_graph.php');

}