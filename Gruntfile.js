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
            build: {
                command: 'composer install --prefer-dist --no-dev --no-interaction --no-suggest --optimize-autoloader'
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
    grunt.registerTask('precommit', ['version']);
    grunt.registerTask('build', ['clean:build', 'exec:build', 'copy:build', 'compress:build']);

    grunt.util.linefeed = '\n';

};