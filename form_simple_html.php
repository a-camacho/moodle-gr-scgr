<?php

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class simplehtml_form extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!

        $MODALITY_TYPES = array( 'inter' => get_string('form_simple_value_mod_inter', 'gradereport_scgr'),
                                    'intra' => get_string('form_simple_value_mod_intra', 'gradereport_scgr'));
        $mform->addElement('select', 'modality', get_string('form_simple_label_modality', 'gradereport_scgr'), $MODALITY_TYPES);

        $TEMPORALITY_TYPES = array( 'all' => get_string('form_simple_value_tempo_all', 'gradereport_scgr'),
            'section' => get_string('form_simple_value_tempo_section', 'gradereport_scgr'),
                                    'activity' => get_string('form_simple_value_tempo_activity', 'gradereport_scgr'));
        $mform->addElement('select', 'temporality', get_string('form_simple_label_temporality', 'gradereport_scgr'), $TEMPORALITY_TYPES);

        $sections_list = array( 1, 2, 3, 4, 5);

        $SECTIONS = $sections_list;
        $mform->addElement('select', 'sections', get_string('form_simple_label_section', 'gradereport_scgr'), $SECTIONS);

        $activities_list = array( 1, 2, 3, 4, 5);

        $ACTIVITIES = $activities_list;
        $mform->addElement('select', 'activities', get_string('form_simple_label_activity', 'gradereport_scgr'), $ACTIVITIES);

        $this->add_action_buttons(false, get_string('form_simple_button_submit', 'gradereport_scgr') );

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}