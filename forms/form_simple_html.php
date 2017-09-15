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
        $mform->addElement('select', 'modality', get_string('form_simple_label_modality', 'gradereport_scgr'), $MODALITY_TYPES,
                            array('disabled'));

        $TEMPORALITY_TYPES = array( 'all' => get_string('form_simple_value_tempo_all', 'gradereport_scgr'),
            'section' => get_string('form_simple_value_tempo_section', 'gradereport_scgr'),
                                    'activity' => get_string('form_simple_value_tempo_activity', 'gradereport_scgr'));
        $mform->addElement('select', 'temporality', get_string('form_simple_label_temporality', 'gradereport_scgr'),
                            $TEMPORALITY_TYPES, array('disabled'));

        // Initialize array
        $SECTIONS_LIST = $this->_customdata[0];                                 // Item 0 in array is SECTIONS

        $mform->addElement( 'select',
                            'section',
                            get_string('form_simple_label_section',
                            'gradereport_scgr'),
                            $SECTIONS_LIST, array('disabled') );

        $ACTIVITIES_LIST = $this->_customdata[1];                                    // Item 1 in array is SECTIONS
        $mform->addElement( 'select',
                            'activity',
                            get_string('form_simple_label_activity',
                            'gradereport_scgr'),
                            $ACTIVITIES_LIST);

        // If groups array is not empty we show the select field
        if ( $this->_customdata[2] ) {

            $GROUPS_LIST = $this->_customdata[2];                                    // Item 1 in array is SECTIONS
            $mform->addElement( 'select',
                'group',
                get_string('form_simple_label_group',
                    'gradereport_scgr'),
                $GROUPS_LIST);

        }

        // Add buttons
        $this->add_action_buttons(false, get_string('form_simple_button_submit', 'gradereport_scgr') );

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}