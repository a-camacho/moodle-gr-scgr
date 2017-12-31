<?php

// Print title
echo html_writer::tag('h2', get_string('help_title', 'gradereport_scgr'));

echo '<ul>';

echo html_writer::tag('li', 'Besoin de définir les rôles utilisateurs à STRIPPER lors des graphiques : permet à un
                      cours de mettre des tuteurs (avec rôle étudiant + teacher) dans des groupes et de les ignorer.
                      Pour cela il faut définir le rôle teacher comme rôle à ignorer. Ainsi tous les teachers trouvés
                      sur la route seront ignorés, et même s\'ils ont le statut d\'étudiant.');

echo html_writer::tag('li', 'Besoin de permettre aux enseignants (editingteacher) de modifier certains paramètres
                             relatifs et spécifiques à ce cours.');

echo '</ul>';
