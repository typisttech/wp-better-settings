/*
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package TypistTech\WPBetterSettings
 * @author Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license GPL-2.0+
 * @see https://www.typist.tech/projects/wp-better-settings
 * @see https://github.com/TypistTech/wp-better-settings
 */

module.exports = function (grunt) {

    'use strict';

    // Project configuration.
    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        // Bump version numbers.
        version: {
            composer: {
                options: {
                    prefix: '"version"\\:\\s+"'
                },
                src: ['composer.json']
            },
            changelog: {
                options: {
                    prefix: 'future-release='
                },
                src: ['.github_changelog_generator']
            },
            php: {
                options: {
                    prefix: '\\* Version:\\s+'
                },
                src: ['<%= pkg.name %>.php']
            }
        },

        // Clean the build folder.
        clean: {
            "pre-build": {
                src: [
                    'build/',
                    'release/',
                    'vendor/'
                ]
            }
        },

        // Copy to build folder.
        copy: {
            build: {
                expand: true,
                src: [
                    'partials/**',
                    'src/**',
                    'vendor/**',
                    'class-plugin.php',
                    'LICENSE',
                    '<%= pkg.name %>.php'
                ],
                dest: 'build/'
            }
        },

        compress: {
            build: {
                options: {
                    archive: 'release/<%= pkg.name %>.zip'
                },
                expand: true,
                dest: '<%= pkg.name %>/',
                cwd: 'build/',
                src: ['**']
            }
        }

    });

    require('load-grunt-tasks')(grunt);
    grunt.registerTask('pre-build', ['clean:pre-build']);
    grunt.registerTask('build', ['copy:build', 'compress:build']);
    grunt.registerTask('pre-tag', ['version']);

    grunt.util.linefeed = '\n';

};
