<?php

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class simplehtml_form extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG, $config;

        $mform = $this->_form; // Don't forget the underscore!

        $groupsactivated = ($this->_customdata[3]) ? true : false;

        // ************** CUSTOM TITLE **************
        $mform->addElement('text', 'graph_custom_title', get_string('form_simple_label_graph_custom_title', 'gradereport_scgr') );
        $mform->addHelpButton('graph_custom_title', 'helper_customtitle', 'gradereport_scgr');

        // ************** GRAPH VIEW TYPE **************
        $VIEW_TYPES = array( 'horizontal-bars' => get_string('form_simple_value_viewtype_horizontalbars', 'gradereport_scgr'),
            'vertical-bars' => get_string('form_simple_value_viewtype_verticalbars', 'gradereport_scgr'));

        $mform->addElement('select', 'viewtype', get_string('form_label_viewtype', 'gradereport_scgr'), $VIEW_TYPES );
        $mform->setDefault('viewtype', 'vertical-bars');
        $mform->addHelpButton('viewtype', 'helper_viewtype', 'gradereport_scgr');

        // ************** INTER-INTRA CHOICE **************
        if ( $groupsactivated ) {

            $MODALITY_TYPES = array( 'inter' => get_string('form_simple_value_mod_inter', 'gradereport_scgr'),
                'intra' => get_string('form_simple_value_mod_intra', 'gradereport_scgr'));

            $mform->addElement('select', 'modality', get_string('form_simple_label_modality', 'gradereport_scgr'), $MODALITY_TYPES );
            $mform->setDefault('modality', 'intra');
            $mform->addHelpButton('modality', 'helper_modality', 'gradereport_scgr');

        }

        // ************** ACTIVITY **************
        $ACTIVITIES_LIST = $this->_customdata[1];                                    // Item 1 in array is SECTIONS
        $mform->addElement( 'select',
                            'activity1',
                            get_string('form_simple_label_activity',
                            'gradereport_scgr'),
                            $ACTIVITIES_LIST);
        $mform->addHelpButton('activity1', 'helper_chooseactivity', 'gradereport_scgr');

        // If groups array is not empty we show the select field
        if ( $this->_customdata[2] ) {

            $GROUPS_LIST = $this->_customdata[2];                                    // Item 2 in array is SECTIONS
            $mform->addElement( 'select',
                'group',
                get_string('form_simple_label_group',
                    'gradereport_scgr'),
                $GROUPS_LIST);
            $mform->addHelpButton('group', 'helper_group', 'gradereport_scgr');

        }

        // Conditional disable
        $mform->disabledIf('group', 'modality', $condition = 'eq', $value='inter');

        // Add buttons
        $this->add_action_buttons(false, get_string('form_simple_button_submit', 'gradereport_scgr') );

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}