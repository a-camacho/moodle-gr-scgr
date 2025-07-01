
# Important

[![status: archive](https://github.com/GIScience/badges/raw/master/status/archive.svg)](https://github.com/GIScience/badges#archive)

This project is no longer actively maintained

# Social comparison grade report

### Description

A social comparison gradebook interface for students and teachers, showing the student's grades (or the group grades) in comparison with the others students (or groups) grades.

### Requirements

This plugin requires Moodle 3.2+ because we are using Chart.js API which has been included in Moodle core since version 3.2.

### Settings

In Moodle, go to Site administration -> Grades -> Report settings and choose SCGR settings.

### Warnings

This plugin has been made for University of Geneva, specially for a learning course. I tried to build it so it can be used in any other course or Moodle environment.

Some things are still (unfortunately) hardcoded in plugin. Be aware of these if you want to use this plugin in a different context.

1. By default the plugin strips users with role "teacher" from any chart made. If you want to disable this and have all users taken in by the plugin, search for where **stripTutorsGroupFromGroupIDS()** and **stripTutorsFromUsers()** functions are *used* in lib.php (lines 166, 171, 496 & 659) and comment them.
2. This plugin uses a setting to let your students, noneditingteachers or teachers to generate some "intergroup" charts. To be able to do that you need to have the groups setting enabled for your course in Site Administration > Settings.

