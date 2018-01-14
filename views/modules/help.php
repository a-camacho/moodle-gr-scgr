<?php

// Print title
echo html_writer::tag('h2', get_string('help_title', 'gradereport_scgr'));

// Introduction
echo html_writer::tag('p', get_string('help_introduction', 'gradereport_scgr'));

// Section 1 : Config
echo html_writer::tag('hr', '');
echo html_writer::tag('h3', get_string('help_section_plugin', 'gradereport_scgr'));
echo html_writer::tag('hr', '');

echo html_writer::tag('h5', get_string('help_plugin_enablegroups_title', 'gradereport_scgr'));
echo html_writer::tag('p', get_string('help_plugin_enablegroups', 'gradereport_scgr'));

echo html_writer::tag('h5', get_string('help_plugin_teachersignored_title', 'gradereport_scgr'));
echo html_writer::tag('p', get_string('help_plugin_teachersignored', 'gradereport_scgr'));

echo html_writer::tag('h5', get_string('help_plugin_nothingequalzero_title', 'gradereport_scgr'));
echo html_writer::tag('p', get_string('help_plugin_nothingequalzero', 'gradereport_scgr'));

// Section 2 : Usage
echo html_writer::tag('hr', '');
echo html_writer::tag('h3', get_string('help_section_usage', 'gradereport_scgr'));
echo html_writer::tag('hr', '');

echo html_writer::tag('h5', get_string('help_usage_modality_title', 'gradereport_scgr'));
echo html_writer::tag('p', get_string('help_usage_modality', 'gradereport_scgr'));

echo html_writer::tag('h5', get_string('help_usage_aggregationcoef_title', 'gradereport_scgr'));
echo html_writer::tag('p', get_string('help_usage_aggregationcoef', 'gradereport_scgr'));

echo html_writer::tag('h5', get_string('help_usage_savecharts_title', 'gradereport_scgr'));
echo html_writer::tag('p', get_string('help_usage_savecharts', 'gradereport_scgr'));

echo html_writer::tag('h5', get_string('help_usage_mouseonover_title', 'gradereport_scgr'));
echo html_writer::tag('p', get_string('help_usage_mouseonover', 'gradereport_scgr'));
