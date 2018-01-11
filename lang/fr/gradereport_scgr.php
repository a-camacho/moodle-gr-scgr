<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'gradereport_scgr', language 'fr'
 *
 * @package   gradereport_scgr
 * @copyright 2017 onwards André Camacho http://www.camacho.pt
 * @author    André Camacho
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Social comparison grade report';
$string['plugintitle'] = 'SCGR';

// Page

$string['page_not_active_on_this_course'] = 'Le plugin SCGR n\'est pas actif pour ce cours.';
$string['page_not_active_on_this_course_description'] = 'Avant de pouvoir utiliser le plugin SCGR, il est nécessaire de
        l\'activer pour ce cours, dans les paramètres des plugins.';

// Buttons

$string['form_button_submit'] = 'Soumettre';

/* ################################################################################################################ */
/* ###########################################      PREDEFINED        ############################################# */
/* ################################################################################################################ */

// Predefined graphs - Descriptions

$string['student_intra_description'] = 'L\'étudinat peut voir une visualisation présentant sa progression (réussite)
à travers les activités de son choix, et la comparer à la réussite moyenne de son groupe ou de sa classe.';

$string['student_inter_description'] = 'L\'étudiant peut voir une visualisation comparant la réussite de son groupe
avec celle des autres groupes du cours.';

$string['teacher_progression_description'] = 'L\'enseignant peut voir la progression de ses étudiants à travers les
activités de son choix.';

$string['teacher_comparison_description'] = 'L\'enseignant peut voir la comparaison entre ses étudiants à travers les
activités de son choix.';

$string['custom_group_restriction_desc'] = '<strong><u>Information</u></strong> : Les enseignants peuvent uniquement 
générer des visualisations d\'étudiants du (ou des) groupe(s) au(x)quel(s) ils appartiennent. <br />Les groupes sont
<strong>activés</strong>. Vous appartenez au(x) groupe(s) suivant(s) : ';


// Predefined graphs - Customize

$string['predefined_customize_title'] = 'Personnaliser';
$string['predefined_customize_label_activity'] = 'Activités';


/* ################################################################################################################ */
/* ##############################################      FORMS        ############################################### */
/* ################################################################################################################ */

// Forms - Custom

$string['form_custom_title'] = 'Graphique personnalisé';
$string['form_custom_subtitle'] = 'Génère un graphique personnalisé comparant des étudiants (ou groupes d\'étudiants)
à travers les activités choisies.';
$string['form_custom_section_parameters'] = 'Paramètres du graphique';
$string['form_custom_section_activities'] = 'Activités';

// Forms - Custom - Labels

$string['form_custom_label_custom_title'] = 'Titre personnalisé';
$string['form_custom_label_viewtype'] = 'Type de visualisation';
$string['form_custom_label_modality'] = 'Modalité';
$string['form_custom_label_activity'] = 'Choix d\'activités';
$string['form_custom_label_activities'] = 'Activités';
$string['form_custom_label_group'] = 'Groupe';
$string['form_custom_label_average'] = 'Calculer la moyenne';
$string['form_custom_label_averageonly'] = 'Montrer uniquement la moyenne';
$string['form_custom_label_custom_weighting'] = 'Pondération personnalisée';
$string['form_custom_label_gradesinpercentage'] = 'Notes en %';
$string['form_custom_label_gradesinpercentage_desc'] = 'Notes sont calculées en pourcentage';

// Forms - Custom - Values

$string['form_custom_value_viewtype_horizontalbars'] = 'Barres horizontales';
$string['form_custom_value_viewtype_verticalbars'] = 'Barres verticales';
$string['form_custom_value_mod_intra'] = 'Intra-group';
$string['form_custom_value_mod_inter'] = 'Inter-group';

// Form helpers

$string['helper_customtitle'] = 'Ajouter un titre personnalisé ?';
$string['helper_customtitle_help'] = 'Si activé, ceci affichera un titre personnalisé dans le graphique.';
$string['helper_viewtype'] = 'Choisir type de graphique';
$string['helper_viewtype_help'] = 'Choisissez le type de graphique souhaité.';
$string['helper_gradesinpercentage'] = 'Calcule les notes en pourcentage';
$string['helper_gradesinpercentage_help'] = 'Important si vos activités n\'ont pas toutes les mêmes notes maximales et
minimales.';
$string['helper_modality'] = 'Choisir modalité';
$string['helper_modality_help'] = 'Intra-group montrera une comparaison des étudiants d\'un groupe.<br />
                                   Inter-group montrera une comparaison des différents groupes d\'un cours.';
$string['helper_average'] = 'Calculer la moyenne?';
$string['helper_averageonly'] = 'Montrer uniquement la moyenne';
$string['helper_averageonly_help'] = 'Si activé, les séries utilisées pour calculer la moyenne seront cachées et seule
la série de la moyenne sera visible.';
$string['helper_average_help'] = 'Si activé, une série sera créée avec la moyenne calculée à partir des notes des 
activités choisies.';
$string['helper_customweight'] = 'Pondération personnalisée pour moyenne';
$string['helper_customweight_help'] = 'Si activé, permet de définir des pondérations personnalisées pour chacune des
activités choisies, afin que la moyenne soit calculer selon celles-ci.';
$string['helper_chooseactivity'] = 'Choisir une activité';
$string['helper_chooseactivity_help'] = 'Choisissez une activité que vous voulez inclure au graphique.<br />La
                                         pondération de l\'activité est recupérée depuis la base de données. <br />
                                         Vous pouvez la changer en allant sur Notes > Paramètres.';
$string['helper_group'] = 'Choisir un groupe';
$string['helper_group_help'] = 'Choisissez le groupe dont vous voulez voir les étudiants affichés.';


/* ################################################################################################################ */
/* #############################################      SETTINGS        ############################################# */
/* ################################################################################################################ */

// Settings Page

$string['settings_page_title'] = 'Paramètres de SCGR';


/* ################################################################################################################ */
/* #############################################      FUNCTIONS        ############################################ */
/* ################################################################################################################ */

// Navigation

$string['nav_help'] = 'Aide';
$string['nav_custom'] = 'Graph personnalisé';
$string['nav_student_intra'] = 'Moi et mon groupe';
$string['nav_student_inter'] = 'Mon groupe et les autres';
$string['nav_teacher_progression'] = 'Progression';
$string['nav_teacher_comparison'] = 'Comparaison';

// Help page

$string['help_title'] = 'Page d\'aide';
$string['help_introduction'] = 'Cette page vous donne quelques informations sur le fonctionnement du plugin.';
$string['help_striptutors'] = 'Le module "Social comparison grade report" ignore par défaut tous les utilisateurs porteurs
du rôle "teacher" lors de la création de visualisations personnalisées ou prédéfinies. <br />Ainsi, lorsque le module souhaite
afficher les résultats des groupes du cours, ou des apprenants du groupe-classe tout utilisateur porteur du rôle "teacher"
sera ignoré.';