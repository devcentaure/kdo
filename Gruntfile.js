module.exports = function(grunt){

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-autoprefixer');

    grunt.initConfig({

        uglify: {
            dist: {
                files: {
                    'app/Resources/public/js/min.js': [
                        'app/Resources/public/js/vendor/jquery.min.js',
                        'app/Resources/public/js/vendor/modernizr.js',
                        'app/Resources/public/js/app.js',
                        'app/Resources/public/js/vendor/foundation.min.js',
                        'app/Resources/public/js/vendor/foundation.topbar.js',
                        'app/Resources/public/js/vendor/owl.carousel.min.js',
                        'app/Resources/public/js/ga.js'
                    ]
                }
            }
        },

        autoprefixer: {
            single_file: {
                src: 'app/Resources/public/css/app.css',
                dest: 'app/Resources/public/css/app.css'
            }
        },

        cssmin: {
            combine: {
                files: {
                    'app/Resources/public/css/min.css': ['app/Resources/public/css/app.css']
                }
            }
        },

        jshint: {
            all: ['app/Resources/public/js/app.js']
        },

        copy: {

            init: {
                files: [
                    {src: 'bower_components/foundation/scss/foundation/_settings.scss', dest: 'app/Resources/public/scss/_settings.scss'},
                    {src: 'bower_components/foundation/scss/foundation/_functions.scss', dest: 'app/Resources/public/scss/_functions.scss'},
                    {src: 'bower_components/foundation/scss/foundation.scss', dest: 'app/Resources/public/scss/_foundation_mod.scss'},
                    {src: 'bower_components/jquery/dist/jquery.min.js', dest: 'app/Resources/public/js/vendor/jquery.min.js'},
                    {src: 'bower_components/modernizr/modernizr.js', dest: 'app/Resources/public/js/vendor/modernizr.js'},
                    {src: 'bower_components/foundation/js/foundation.min.js', dest: 'app/Resources/public/js/vendor/foundation.min.js'},
                    {src: 'bower_components/foundation/js/foundation/foundation.topbar.js', dest: 'app/Resources/public/js/vendor/foundation.topbar.js'},
                    {src: 'bower_components/owlcarousel/owl-carousel/owl.carousel.min.js', dest: 'app/Resources/public/js/vendor/owl.carousel.min.js'}
                ]
            }

        },

        watch: {

            js: {
                files: ['**/*.js'],
                tasks: ['js'],
                options: {
                    spawn: false
                }
            },

            scss: {
                files: ['**/*.scss'],
                tasks: ['css'],
                options: {
                    spawn: false
                }
            }
        },

        compass: {
            dist: {
                options: {
                    config: 'config.rb'
                }
            }
        }

    });

    grunt.registerTask('default', ['css', 'js']);
    grunt.registerTask('dev', ['jsdev', 'jshint', 'cssdev']);
    grunt.registerTask('cssdev', ['compass', 'autoprefixer']);
    grunt.registerTask('jsdev', ['jshint']);
    grunt.registerTask('js', ['jshint', 'uglify']);
    grunt.registerTask('css', ['compass', 'autoprefixer', 'cssmin']);
    grunt.registerTask('init', ['copy:init']);

};