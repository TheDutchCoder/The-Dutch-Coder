module.exports = function(grunt) {

    // Config.
    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        // Sass.
        sass: {
            dev: {
                files: {
                    'css/style.css' : 'sass/style.scss'
                }
            },
            prod: {
                options: {
                    style: 'compressed',
                    sourcemap: 'none'
                },
                files: {
                    'css/style.css' : 'sass/style.scss'
                }
            }
        },

        // Autoprefix CSS.
        autoprefixer: {
            no_dest: {
                src: 'css/style.css'
            }
        },

        // Concatenate JS files.
        concat: {
            dist: {
                src: [
                    'js/**/*.js',
                    '!js/scripts.js'
                ],
                dest: 'js/scripts.js'
            }
        },

        // Minify JS files.
        uglify: {
            build: {
                src: 'js/scripts.js',
                dest: 'dist/js/scripts.min.js'
            }
        },

        // Watch files.
        watch: {
            css: {
                files: '**/*.scss',
                tasks: ['sass']
            }
        }

    });

    // Load tasks.
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Define task shortcuts.
    grunt.registerTask('default', ['watch']);
    grunt.registerTask('js', ['concat', 'uglify']);

    grunt.registerTask('dev', ['sass:dev', 'autoprefixer', 'concat']);
    grunt.registerTask('prod', ['sass:prod', 'autoprefixer', 'concat', 'uglify']);

};
