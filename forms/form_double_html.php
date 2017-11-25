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
        }

        $mform->addHelpButton('modality', 'helper_modality', 'gradereport_scgr');

        // ************** AVERAGE **************

        $mform->addElement('selectyesno', 'average', get_string('form_simple_label_average', 'gradereport_scgr'));
        $mform->setDefault('average', 1);
        $mform->disabledIf('custom_weighting', 'average', $condition = 'eq', $value=0);

        $mform->addHelpButton('average', 'helper_average', 'gradereport_scgr');

        $mform->addElement( 'advcheckbox', 'averageonly', ' ', get_string('form_simple_label_averageony_desc', 'gradereport_scgr') , array('group' => 1), array(0, 1));

        // ************** CUSTOM WEIGHTING **************
        $mform->addElement('selectyesno', 'custom_weighting', get_string('form_simple_label_custom_weighting', 'gradereport_scgr'));
        $mform->setDefault('custom_weighting', 0);

        $mform->addHelpButton('custom_weighting', 'helper_customweight', 'gradereport_scgr');

        // ************** ACTIVITIES with custom weight **************

        /*

        $ACTIVITIES_LIST = $this->_customdata[1];                                    // Item 1 in array is SECTIONS

        // Show activity 1 and custom weight in same line
        $activity1_array=array();
        $activity1_array[] =& $mform->createElement( 'select',
            'activity1',
            get_string('form_double_label_activity1',
                'gradereport_scgr'),
            $ACTIVITIES_LIST);
        $activity1_array[] =& $mform->createElement('text', 'custom_weighting_activity1', get_string('form_simple_label_custom_weighting_act_1', 'gradereport_scgr') );
        $mform->addGroup($activity1_array, 'activity1group', get_string('form_simple_label_custom_weighting_act_1', 'gradereport_scgr'), array(' '), false);

        // Show activity 2 and custom weight in same line
        $activity2_array=array();
        $activity2_array[] =& $mform->createElement( 'select',
            'activity2',
            get_string('form_double_label_activity2',
                'gradereport_scgr'),
            $ACTIVITIES_LIST);
        $activity2_array[] =& $mform->createElement('text', 'custom_weighting_activity2', get_string('form_simple_label_custom_weighting_act_2', 'gradereport_scgr') );
        $mform->addGroup($activity2_array, 'activity2group', get_string('form_simple_label_custom_weighting_act_2', 'gradereport_scgr'), array(' '), false);

        $mform->addHelpButton('activity1group', 'helper_chooseactivity', 'gradereport_scgr');
        $mform->addHelpButton('activity2group', 'helper_chooseactivity', 'gradereport_scgr');

         */

        // ************** ACTIVITIES with repeater **************





        $ACTIVITIES_LIST = $this->_customdata[1];
        $START_REPETITIONS = 1;
        $MAX_ACTIVITIES = count($ACTIVITIES_LIST);

        $repeatarray = array();

        $activity_group = array();
        $activity_group[] =& $mform->createElement( 'select', 'activity', get_string('form_simple_label_activity',
                                                    'gradereport_scgr'), $ACTIVITIES_LIST);

        $activity_group[] =& $mform->createElement( 'text', 'custom_weighting_activity',
                                                    get_string('form_simple_label_custom_weighting_act_1',
                                                    'gradereport_scgr') );

        $repeatarray[] = $mform->addGroup(  $activity_group, 'activitygroup', get_string('form_simple_label_activity',
                                            'gradereport_scgr'), array(' '));


        $repeateloptions = array();
        $repeateloptions['activitygroup']['helpbutton'] = array('helper_chooseactivity', 'gradereport_scgr');

        $repeateloptions['activitygroup']['custom_weighting_activity']['default'] = '1';
        $mform->setDefault('custom_weighting_activity', '1');

        $repeateloptions['custom_weighting_activity']['disabledif'] = array('custom_weighting', 'eq', 0);
        $mform->disabledIf('custom_weighting', 'custom_weighting_activity', $condition = 'eq', $value=0);

        var_dump($repeateloptions);

        $mform->addHelpButton('activitygroup', 'helper_chooseactivity', 'gradereport_scgr');

        $this->repeat_elements($repeatarray, $START_REPETITIONS,
            $repeateloptions, 'activitygroup_repeats', 'activitygroup_add_fields', 1, null, true);







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
        $mform->addHelpButton('group', 'helper_group', 'gradereport_scgr');

        // Add buttons

        $this->add_action_buttons(false, get_string('form_simple_button_submit', 'gradereport_scgr') );

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}