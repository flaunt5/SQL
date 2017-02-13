/**
 * Created by Joris on 13-2-2017.
 */
module.exports = function(grunt) {

    grunt.initConfig({
        concat: {
            options: {
                separator: ';', // permet d'ajouter un point-virgule entre chaque fichier concaténé.
            },
            dist: {
                src: ['dev/js/libs/bootstrap.js', 'dev/js/libs/jquery.validate.js', 'dev/js/libs/*.js', 'dev/js/*.js' ], // la source
                dest: 'js/index.js' // la destination finale
            }
        },
        uglify: {
            options: {
                separator: ';'
            },
            dist: {
                src: ['js/index.js'],
                dest: 'js/index.js'
            }
        },
        watch: {
            scripts: {
                files: ['dev/js/*.js'],
                tasks: ['default'],
                options: {
                    spawn: false,
                },
            },
        },
    })

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['concat:dist', 'uglify:dist']);
}