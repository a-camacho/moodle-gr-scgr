<?php

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class customhtml_form extends moodleform {

    public function definition() {

        /******************** Global variables *********************/
        global $USER, $CFG, $config;

        $mform = $this->_form;

        /******************** Get variables *********************/

        $groupsactivated = ($this->_customdata[3]) ? true : false;
        $courseid = $this->_customdata[0];

        // ******************************************
        // ************** PRINT HEADER **************
        // ******************************************

        $mform->addElement('header', 'scgr-general', get_string('form_custom_section_parameters', 'gradereport_scgr'));

        // ******************************************
        // ************** CUSTOM TITLE **************
        // ******************************************

        $mform->addElement('text', 'graph_custom_title', get_string('form_custom_label_custom_title', 'gradereport_scgr') );
        $mform->addHelpButton('graph_custom_title', 'helper_customtitle', 'gradereport_scgr');

        // ******************************************
        // ************ GRAPH VIEW TYPE *************
        // ******************************************

        $VIEW_TYPES = array( 'horizontal-bars' => get_string('form_custom_value_viewtype_horizontalbars', 'gradereport_scgr'),
            'vertical-bars' => get_string('form_custom_value_viewtype_verticalbars', 'gradereport_scgr'));

        $mform->addElement('select', 'viewtype', get_string('form_custom_label_viewtype', 'gradereport_scgr'), $VIEW_TYPES );
        $mform->setDefault('viewtype', 'vertical-bars');
        $mform->addHelpButton('viewtype', 'helper_viewtype', 'gradereport_scgr');

        // ******************************************
        // ********** INTER-INTRA CHOICE ************
        // ******************************************

        if ( $groupsactivated == true ) {
            $MODALITY_TYPES = array( 'inter' => get_string('form_custom_value_mod_inter', 'gradereport_scgr'),
                'intra' => get_string('form_custom_value_mod_intra', 'gradereport_scgr'));
        } else {
            $MODALITY_TYPES = array( 'intra' => get_string('form_custom_value_mod_intra', 'gradereport_scgr'));
        }

        $mform->addElement('select', 'modality', get_string('form_custom_label_modality', 'gradereport_scgr'), $MODALITY_TYPES );
        $mform->setDefault('modality', 'intra');

        $mform->addHelpButton('modality', 'helper_modality', 'gradereport_scgr');

        // ******************************************
        // ******** GRADES IN PERCENTAGE ************
        // ******************************************

        $mform->addElement('advcheckbox', 'gradesinpercentage', get_string('form_custom_label_gradesinpercentage', 'gradereport_scgr'),
                           get_string('form_custom_label_gradesinpercentage_desc', 'gradereport_scgr'), array('group' => 1), array(0, 1));

        $mform->addHelpButton('gradesinpercentage', 'helper_gradesinpercentage', 'gradereport_scgr');

        // ******************************************
        // ***************** AVERAGE ****************
        // ******************************************

        $mform->addElement('selectyesno', 'average', get_string('form_custom_label_average', 'gradereport_scgr'));
        $mform->setDefault('average', 0);
        $mform->disabledIf('custom_weighting', 'average', $condition = 'eq', $value=0);
        $mform->addHelpButton('average', 'helper_average', 'gradereport_scgr');

        $mform->addElement( 'advcheckbox', 'averageonly', ' ', get_string('form_custom_label_averageonly', 'gradereport_scgr') , array('group' => 1), array(0, 1));
        $mform->addHelpButton('averageonly', 'helper_averageonly', 'gradereport_scgr');

        // ******************************************
        // ************ CUSTOM WEIGHTING ************
        // ******************************************

        $mform->addElement('selectyesno', 'custom_weighting', get_string('form_custom_label_custom_weighting', 'gradereport_scgr'));
        $mform->setDefault('custom_weighting', 0);

        $mform->addHelpButton('custom_weighting', 'helper_customweight', 'gradereport_scgr');

        // **********************************************
        // ***** GROUP select (in intra-group mode) *****
        // **********************************************

        if ( $this->_customdata[4] ) { $user_groups = $this->_customdata[4];
        } else { $user_groups = NULL; }

        if ( $this->_customdata[2] ) {
            if ( $user_groups ) {
                $groups_with_names = array();
                foreach ( $user_groups as $group ) {
                    $groups_with_names[$group] = groups_get_group_name($group);
                }
                $GROUPS_LIST = $groups_with_names;
                $mform->addElement( 'select',
                    'group',
                    get_string('form_custom_label_group',
                        'gradereport_scgr'),
                    $GROUPS_LIST);
            } else {
                $GROUPS_LIST = $this->_customdata[2];
                $mform->addElement( 'select',
                    'group',
                    get_string('form_custom_label_group',
                        'gradereport_scgr'),
                    $GROUPS_LIST);
            }
            $mform->addHelpButton('group', 'helper_group', 'gradereport_scgr');
        }
        $mform->disabledIf('group', 'modality', $condition = 'eq', $value='inter');

        // **********************************************
        // ***************** ACTIVITIES *****************
        // **********************************************

        $mform->addElement('header', 'scgr-activities', get_string('form_custom_section_activities', 'gradereport_scgr'));

        $ACTIVITIES_LIST = $this->_customdata[1];
        $START_REPETITIONS = 1;
        $MAX_ACTIVITIES = count($ACTIVITIES_LIST);

        $attributes = array('size'=>'20');
        $activity_group = array();
        $activity_group[] =& $mform->createElement( 'select', 'activity', get_string('form_custom_label_activity',
            'gradereport_scgr'), $ACTIVITIES_LIST);

        $activity_group[] =& $mform->createElement( 'text', 'custom_weighting_activity',
            get_string('form_custom_label_custom_weighting',
                'gradereport_scgr'), $attributes );

        $mform->setType('custom_weighting_activity', PARAM_TEXT);

        $mform->setDefault('custom_weighting_activity', '1');

        $repeatarray = array();

        $repeatoptions = array();
        $repeatoptions['activitygroup']['helpbutton'] = array('helper_chooseactivity', 'gradereport_scgr');
        $repeatoptions['custom_weighting_activity']['disabledif'] = array('custom_weighting', 'eq', 0);
        $repeatoptions['custom_weighting_activity']['default'] = 1;

        $repeatarray[] = $mform->createElement( 'group', 'activitygroup',
            get_string('form_custom_label_activity', 'gradereport_scgr'),
            $activity_group, null, false);

        $this->repeat_elements($repeatarray, $START_REPETITIONS,
            $repeatoptions, 'activitygroup_repeats', 'activitygroup_add_fields', 1, null, true);


        // ******************************************
        // ******************************************
        // ******************************************


        // Add buttons

        $this->add_action_buttons(false, get_string('form_button_submit', 'gradereport_scgr') );

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}