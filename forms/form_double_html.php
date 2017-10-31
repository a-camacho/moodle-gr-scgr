<?php

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class doublehtml_form extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG, $config;

        $mform = $this->_form; // Don't forget the underscore!

        // Get variables

        $groupsactivated = ($this->_customdata[3]) ? true : false;

        // ************** CUSTOM TITLE **************
        $mform->addElement('text', 'graph_custom_title', get_string('form_simple_label_graph_custom_title', 'gradereport_scgr') );

        // ************** INTER-INTRA CHOICE **************
        if ( $groupsactivated ) {
            $MODALITY_TYPES = array( 'inter' => get_string('form_simple_value_mod_inter', 'gradereport_scgr'),
                'intra' => get_string('form_simple_value_mod_intra', 'gradereport_scgr'));
            $mform->addElement('select', 'modality', get_string('form_simple_label_modality', 'gradereport_scgr'), $MODALITY_TYPES );
            $mform->setDefault('modality', 'intra');
        }

        // ************** AVERAGE **************

        $mform->addElement('selectyesno', 'average', get_string('form_simple_label_average', 'gradereport_scgr'));
        $mform->setDefault('average', 1);
        $mform->disabledIf('custom_weighting', 'average', $condition = 'eq', $value=0);

        // ************** CUSTOM WEIGHTING **************
        $mform->addElement('selectyesno', 'custom_weighting', get_string('form_simple_label_custom_weighting', 'gradereport_scgr'));
        $mform->setDefault('custom_weighting', 0);

        // ************** ACTIVITIES with custom weight **************
        $ACTIVITIES_LIST = $this->_customdata[1];                                    // Item 1 in array is SECTIONS
        $mform->addElement( 'select',
                            'activity1',
                            get_string('form_double_label_activity1',
                            'gradereport_scgr'),
                            $ACTIVITIES_LIST);
        $mform->addElement('text', 'custom_weighting_activity1', get_string('form_simple_label_custom_weighting_act_1', 'gradereport_scgr') );

        $mform->addElement( 'select',
                            'activity2',
                            get_string('form_double_label_activity2',
                                'gradereport_scgr'),
                            $ACTIVITIES_LIST);
        $mform->addElement('text', 'custom_weighting_activity2', get_string('form_simple_label_custom_weighting_act_2', 'gradereport_scgr') );

        // ************** CUSTOM WEIGHTING settings **************
        $mform->setDefault('custom_weighting_activity1', 1);
        $mform->setDefault('custom_weighting_activity2', 1);
        $mform->disabledIf('custom_weighting_activity1', 'custom_weighting', $condition = 'eq', $value=0);
        $mform->disabledIf('custom_weighting_activity2', 'custom_weighting', $condition = 'eq', $value=0);

        // ************** GROUP select (in intra-group mode) **************
        if ( $this->_customdata[2] ) {
            $GROUPS_LIST = $this->_customdata[2];                                    // Item 1 in array is SECTIONS
            $mform->addElement( 'select',
                'group',
                get_string('form_simple_label_group',
                    'gradereport_scgr'),
                $GROUPS_LIST);
        }
        $mform->disabledIf('group', 'modality', $condition = 'eq', $value='inter');

        // Add buttons

        $this->add_action_buttons(false, get_string('form_simple_button_submit', 'gradereport_scgr') );

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}