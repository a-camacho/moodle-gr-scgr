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

$string['pluginname'] = 'Rapport de comparaison sociale';
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

$string['teacher_progression_description'] = 'L\'enseignant peut suiver la progression de ses étudiants à travers les
activités de son choix.';

$string['teacher_comparison_description'] = 'L\'enseignant peut comparer la réussite des étudiants de ses groupes à
travers les activités de son choix.';

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
$string['form_custom_subtitle'] = 'Génère un graphique personnalisé comparant la réussite des étudiants (ou groupes
d\'étudiants) sur des activités au choix.';
$string['form_custom_section_parameters'] = 'Paramètres du graphique';
$string['form_custom_section_activities'] = 'Activités';

// Forms - Custom - Labels

$string['form_custom_label_custom_title'] = 'Titre personnalisé';
$string['form_custom_label_viewtype'] = 'Type de visualisation';
$string['form_custom_label_modality'] = 'Modalité';
$string['form_custom_label_activity'] = 'Activité';
$string['form_custom_label_activity_coeff'] = 'Coeff. de pondération';
$string['form_custom_label_activities'] = 'Activités';
$string['form_custom_label_group'] = 'Groupe';
$string['form_custom_label_average'] = 'Calculer et afficher la moyenne';
$string['form_custom_label_averageonly'] = 'Masquer les séries d\'activités (et n\'afficher que la moyenne)';
$string['form_custom_label_custom_weighting'] = 'Pondération personnalisée';
$string['form_custom_label_gradesinpercentage'] = 'Notes en %';
$string['form_custom_label_gradesinpercentage_desc'] = 'Calculer les notes en pourcentage';

// Forms - Custom - Values

$string['form_custom_value_viewtype_horizontalbars'] = 'Barres horizontales';
$string['form_custom_value_viewtype_verticalbars'] = 'Barres verticales';
$string['form_custom_value_mod_intra'] = 'Intra-groupe';
$string['form_custom_value_mod_inter'] = 'Inter-groupe';

// Form helpers

$string['helper_customtitle'] = 'Ajouter un titre personnalisé ?';
$string['helper_customtitle_help'] = 'Utilisez ce champ pour définir un titre personnalisé qui s\'affichera en haut
                                      du graphique.';
$string['helper_viewtype'] = 'Choisir type de graphique';
$string['helper_viewtype_help'] = 'Choisissez le type de visualisation du graphique.';
$string['helper_gradesinpercentage'] = 'Calcule les notes en pourcentage';
$string['helper_gradesinpercentage_help'] = 'Les notes seront converties en pourcentage. Ceci est important si vos
activités n\'ont pas toutes les mêmes notes maximales et minimales.';
$string['helper_modality'] = 'Choisir modalité';
$string['helper_modality_help'] = 'Choisir une modalité (plus d\'informations dans l\'onglet "Aide").';
$string['helper_average'] = 'Calculer la moyenne?';
$string['helper_averageonly'] = 'Montrer uniquement la moyenne';
$string['helper_averageonly_help'] = 'Si coché, la note des activités utilisées pour calculer la moyenne seront cachées
et seule la note moyenne sera visible.';
$string['helper_average_help'] = 'Voulez-vous calculer la note moyenne des activités choisies et l\'afficher ?';
$string['helper_customweight'] = 'Pondération personnalisée pour moyenne';
$string['helper_customweight_help'] = 'Souhaitez-vous définir un coefficient de pondération (poids) différent pour chaque
activité choisie ? Ceux-ci sont utilisées lorsqu\'une moyenne est calculée.';
$string['helper_chooseactivity'] = 'Choisir une activité';
$string['helper_chooseactivity_help'] = 'Choix de l\'activité à inclure au graphique. Le coefficient de pondération
                                         paramétré dans le cours est affiché entre parenthèses. Il doit être renseigné
                                         dans le champ de droite pour être pris en considération.';
$string['helper_group'] = 'Choisir un groupe';
$string['helper_group_help'] = 'Choisissez le groupe d\'étudiants que vous souhaitez comparer.';


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
$string['nav_custom'] = 'Graphique personnalisé';
$string['nav_student_intra'] = 'Moi et mon groupe';
$string['nav_student_inter'] = 'Mon groupe et les autres';
$string['nav_teacher_progression'] = 'Progression (mes groupes)';
$string['nav_teacher_comparison'] = 'Comparaison (mes groupes)';


/* ################################################################################################################ */
/* #############################################      HELP PAGE        ############################################ */
/* ################################################################################################################ */

// Help page

$string['help_title'] = 'Page d\'aide';
$string['help_introduction'] = 'Cette page vous donne quelques informations sur le fonctionnement du plugin.';

$string['help_section_plugin'] = 'Informations et paramétrage';
$string['help_section_usage'] = 'Utilisation';

$string['help_plugin_enablegroups_title'] = 'Groupes d\'étudiants';
$string['help_plugin_enablegroups'] = 'Pour utiliser la fonctionnalité de groupes du plugin, il est tout d\'abord
                                       nécessaire de selectionner le cours dans les paramètres du plugin. <strong>
                                       Emplacement</strong> : Administration du site > Notes > Réglages des rapports
                                       > Rapport de comparaison sociale.';

$string['help_plugin_teachersignored_title'] = 'Enseignants (tuteurs) dans groupes d\'étudiants';
$string['help_plugin_teachersignored'] = 'Afin de pouvoir avoir des enseignants (teacher) dans des groupes d\'étudiants
                                          lorsque des graphiques seront générés, les utilisateurs portant le rôle de
                                          enseignant/tuteur (teacher) seront ignorés.';

$string['help_plugin_nothingequalzero_title'] = 'Devoir non rendu VS Zéro (0)';
$string['help_plugin_nothingequalzero'] = 'Actuellement ce plugin ne fait pas la différence entre un devoir non rendu et
                                           la note minimale (0) pour une activité. Lorsque la moyenne d\'un groupe est
                                           calculée il est important de vérifier que les devoirs aient été rendus.
                                           <br /><u>Cette fonctionnalité sera cependant rajoutée très bientôt</u>.';

$string['help_usage_modality_title'] = 'Modalités (intra vs inter)';
$string['help_usage_modality'] = 'Les modalités font référence aux entités qui seront comparées ou mises en contraste.
                                  Lorsque vous choisissez la modalité <strong>inter-groupe</strong> vous souhaitez
                                  comparer la réussite de différents groupes au sein d\'un cours. Lorsque vous choisissez
                                  <strong>intra-groupe</strong> vous vous situez au niveau d\'<strong>un</strong> et
                                  comparez donc la réussite des étudiants de ce groupe.';

$string['help_usage_aggregationcoef_title'] = 'Pondération personnalisée (par coefficients)';
$string['help_usage_aggregationcoef'] = 'Les coefficients de pondération correspondent au poids d\'une activité au sein
                                         d\'une formation. Lorsque vous demandez à calculer et afficher la moyenne des
                                         activités choisies, une moyenne non pondérée sera calculée : chaque activité 
                                         aura la même importance dans le calcul. Lorsque vous définissez des coefficients
                                         de pondération, vous pouvez définir le poids de chaque activité. Vous pouvez
                                         entrer n\'importe quelle valeur numérique (entiers ou décimaux).';

$string['help_usage_savecharts_title'] = 'Sauvegarde de graphique';
$string['help_usage_savecharts'] = 'Pour sauvegarder ou copier un graphique, afin de le réutiliser, il vous suffit
                                    d\'effectuer un clic droit sur celui-ci avec un navigateur moderne (testé sous
                                    Chrome, Firefox, Safari).';

$string['help_usage_mouseonover_title'] = 'Interaction avec le graphique';
$string['help_usage_mouseonover'] = 'Vous pouvez interagir légèrement avec les graphiques générés. Vous pouvez masquer
                                     une série de données en cliquant sur son nom (ou couleur) dans le haut du graphique.
                                     Vous pouvez également obtenir des informations sur une intersection, en passant
                                     la souris sur un des points du graphique. Vous pouvez également afficher les données
                                     utilisées pour construire le graphique en cliquant sur le lien prévu à cet effet
                                     en dessous du graphique.';