<?php

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class chooseactivities_form extends moodleform {

    //Add elements to form
    public function definition()
    {
        global $CFG, $config;

        $mform = $this->_form; // Don't forget the underscore!

        $ACTIVITIES_LIST = $this->_customdata[0];

        // ************** FIRST ACTIVITY **************

        $select = $mform->addElement( 'select', 'activity', get_string('form_simple_label_activity',
            'gradereport_scgr'), $ACTIVITIES_LIST);
        $select->setMultiple(true);

        // Add buttons

        $this->add_action_buttons(false, get_string('form_button_submit', 'gradereport_scgr') );

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }

}