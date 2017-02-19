module.exports = function(grunt) {

    'use strict';

    // Project configuration
    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        // Bump version numbers
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

        // Clean the build folder
        clean: {
            build: {
                src: [
                    'build/',
                    'release/'
                ]
            }
        },

        // Install composer dependencies and generate autoloader
        exec: {
            composer_install: {
                command: 'composer install --prefer-dist --no-dev --no-interaction --no-suggest --optimize-autoloader'
            },
            composer_update: {
                command: 'composer update --prefer-dist --no-interaction --no-suggest --optimize-autoloader'
            },
            changelog: {
                command: 'github_changelog_generator'
            }
        },

        // Copy to build folder
        copy: {
            build: {
                expand: true,
                src: [
                    '**',
                    '!.distignore',
                    '!.editorconfig',
                    '!.git/**',
                    '!.gitignore',
                    '!.gitlab-ci.yml',
                    '!.travis.yml',
                    '!.DS_Store',
                    '!Thumbs.db',
                    '!assets/**',
                    '!behat.yml',
                    '!bin/**',
                    '!build/**',
                    '!CHANGELOG.md',
                    '!codecept-runner.php',
                    '!codeception.yml',
                    '!codeception.dist.yml',
                    '!circle.yml',
                    '!composer.json',
                    '!composer.lock',
                    '!Gruntfile.js',
                    '!package.json',
                    '!phpunit.xml',
                    '!multisite.xml',
                    '!phpunit.xml.dist',
                    '!phpcs.ruleset.xml',
                    '!TODO.md',
                    '!release/**',
                    '!ruleset.xml',
                    '!wp-cli.local.yml',
                    '!tests/**',
                    '!node_modules/**',
                    '!*.zip',
                    '!*.tar.gz'
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
                files: [{
                    expand: true,
                    dest: '<%= pkg.name %>/',
                    cwd: 'build/',
                    src: ['**']
                }]
            }
        }

    });

    require('load-grunt-tasks')(grunt);
    grunt.registerTask('pretag', ['version', 'exec:composer_update', 'exec:changelog']);
    grunt.registerTask('build', ['clean:build', 'exec:composer_install', 'copy:build', 'compress:build']);

    grunt.util.linefeed = '\n';

};
