module.exports = function(grunt) {

    // Config.
    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

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
        }

    });

    // Load tasks.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Define task shortcuts.
    grunt.registerTask('default', ['concat', 'uglify']);

};
