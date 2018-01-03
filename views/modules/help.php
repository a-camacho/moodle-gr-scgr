<?php

// Print title
echo html_writer::tag('h2', get_string('help_title', 'gradereport_scgr'));

// Introduction
echo html_writer::tag('p', get_string('help_introduction', 'gradereport_scgr'));

// Informations about plugin
echo '<ul>';
echo html_writer::tag('li', get_string('help_striptutors', 'gradereport_scgr'));
echo '</ul>';
