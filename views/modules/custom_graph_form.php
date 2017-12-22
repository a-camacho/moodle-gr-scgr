<?php

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class customhtml_form extends moodleform {

    //Add elements to form
    public function definition() {
        global $USER, $CFG, $config;

        $mform = $this->_form; // Don't forget the underscore!

        // Get variables

        $groupsactivated = ($this->_customdata[3]) ? true : false;
        $courseid = $this->_customdata[0];

        if ( $this->_customdata[4] ) {
            $user_groups = $this->_customdata[4];
        } else {
            $user_groups = NULL;
        }

        $mform->addElement('header', 'scgr-general', 'General Parameters');

        // ************** CUSTOM TITLE **************
        $mform->addElement('text', 'graph_custom_title', get_string('form_custom_label_custom_title', 'gradereport_scgr') );
        $mform->addHelpButton('graph_custom_title', 'helper_customtitle', 'gradereport_scgr');

        // ************** GRAPH VIEW TYPE **************
        $VIEW_TYPES = array( 'horizontal-bars' => get_string('form_custom_value_viewtype_horizontalbars', 'gradereport_scgr'),
            'vertical-bars' => get_string('form_custom_value_viewtype_verticalbars', 'gradereport_scgr'));

        $mform->addElement('select', 'viewtype', get_string('form_custom_label_viewtype', 'gradereport_scgr'), $VIEW_TYPES );
        $mform->setDefault('viewtype', 'vertical-bars');
        $mform->addHelpButton('viewtype', 'helper_viewtype', 'gradereport_scgr');

        // ************** INTER-INTRA CHOICE **************
        if ( $groupsactivated == true ) {
            $MODALITY_TYPES = array( 'inter' => get_string('form_custom_value_mod_inter', 'gradereport_scgr'),
                'intra' => get_string('form_custom_value_mod_intra', 'gradereport_scgr'));
        } else {
            $MODALITY_TYPES = array( 'intra' => get_string('form_custom_value_mod_intra', 'gradereport_scgr'));
        }

        $mform->addElement('select', 'modality', get_string('form_custom_label_modality', 'gradereport_scgr'), $MODALITY_TYPES );
        $mform->setDefault('modality', 'intra');

        $mform->addHelpButton('modality', 'helper_modality', 'gradereport_scgr');

        // ************** AVERAGE **************

        $mform->addElement('selectyesno', 'average', get_string('form_custom_label_average', 'gradereport_scgr'));
        $mform->setDefault('average', 0);
        $mform->disabledIf('custom_weighting', 'average', $condition = 'eq', $value=0);
        $mform->addHelpButton('average', 'helper_average', 'gradereport_scgr');

        $mform->addElement( 'advcheckbox', 'averageonly', ' ', get_string('form_custom_label_averageonly', 'gradereport_scgr') , array('group' => 1), array(0, 1));
        $mform->addHelpButton('averageonly', 'helper_averageonly', 'gradereport_scgr');

        // ************** CUSTOM WEIGHTING **************
        $mform->addElement('selectyesno', 'custom_weighting', get_string('form_custom_label_custom_weighting', 'gradereport_scgr'));
        $mform->setDefault('custom_weighting', 0);

        $mform->addHelpButton('custom_weighting', 'helper_customweight', 'gradereport_scgr');

        // ************** GROUP select (in intra-group mode) **************

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

        $mform->addElement('header', 'scgr-activities', 'Activities');

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


        // var_dump($this->_customdata);


        $mform->setType('custom_weighting_activity', PARAM_TEXT);

        $mform->setDefault('custom_weighting_activity', '1');

        $repeatarray = array();

        $repeatoptions = array();
        $repeatoptions['activitygroup']['helpbutton'] = array('helper_chooseactivity', 'gradereport_scgr');
        $repeatoptions['custom_weighting_activity']['disabledif'] = array('custom_weighting', 'eq', 0);
        $repeatoptions['custom_weighting_activity']['default'] = 1;

        /* $repeatarray[] = $mform->addGroup(  $activity_group, 'activitygroup', get_string('form_simple_label_activity',
            'gradereport_scgr'), array(' '));

        */

        $repeatarray[] = $mform->createElement( 'group', 'activitygroup',
            get_string('form_custom_label_activity', 'gradereport_scgr'),
            $activity_group, null, false);

        $this->repeat_elements($repeatarray, $START_REPETITIONS,
            $repeatoptions, 'activitygroup_repeats', 'activitygroup_add_fields', 1, null, true);


        // Get header of section (repeating activities)
        // Can other attributes come here ? Do I have to identify so ?
        $actualrepgroupsno = $this->_form->_elements[9]->_attributes['value'];
        $maximumrepgroupno = $MAX_ACTIVITIES;

        // var_dump($this->_form->_elements[9]->_attributes['value']);





        // ************** Activities not grouped **************
        /*
        $mform->addElement('header', 'scgr-activities2', 'Activities (not grouped)');

        $repeatarray = array();
        $repeatarray[] = $mform->createElement('text', 'option', get_string('optionno', 'choice'));
        $repeatarray[] = $mform->createElement('text', 'limit', get_string('limitno', 'choice'));
        $repeatarray[] = $mform->createElement('hidden', 'optionid', 0);

        if ($this->_instance){
            $repeatno = $DB->count_records('choice_options', array('choiceid'=>$this->_instance));
            $repeatno += 2;
        } else {
            $repeatno = 2;
        }

        // Set number maximum of instances
        $repeatno = 2;
        $maxrepeatno = count($ACTIVITIES_LIST);

        $repeateloptions = array();
        $repeateloptions['limit']['default'] = 0;
        $repeateloptions['limit']['disabledif'] = array('custom_weighting', 'eq', 0);
        $repeateloptions['limit']['rule'] = 'numeric';
        $repeateloptions['limit']['type'] = PARAM_INT;

        $repeateloptions['option']['helpbutton'] = array('choiceoptions', 'choice');

        $mform->setType('option', PARAM_CLEANHTML);
        $mform->setType('optionid', PARAM_INT);

        $this->repeat_elements($repeatarray, $repeatno,
            $repeateloptions, 'option_repeats', 'option_add_fields', 1, null, true);


        */

        // ************** CUSTOM WEIGHTING settings **************
        $mform->setDefault('custom_weighting_activity1', 1);
        $mform->setDefault('custom_weighting_activity2', 1);
        $mform->disabledIf('custom_weighting_activity1', 'custom_weighting', $condition = 'eq', $value=0);
        $mform->disabledIf('custom_weighting_activity2', 'custom_weighting', $condition = 'eq', $value=0);

        // Add buttons

        $this->add_action_buttons(false, get_string('form_button_submit', 'gradereport_scgr') );

    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}