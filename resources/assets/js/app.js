/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('portada', require('./components/Portada.vue').default);

Vue.component('maestro', require('./components/Maestro.vue').default);
Vue.component('aula', require('./components/Aula.vue').default);

Vue.component('periodo', require('./components/Periodo.vue').default);
// Vue.component('alumno', require('./components/Alumno.vue').default);
Vue.component('maestroaula', require('./components/MaestroAula.vue').default);
Vue.component('estudiante', require('./components/Estudiante.vue').default);
 Vue.component('curso', require('./components/Curso.vue').default);
 Vue.component('rol', require('./components/Rol.vue').default);
 Vue.component('usuario', require('./components/Usuario.vue').default);
 Vue.component('competencia', require('./components/Competencia.vue').default);
 Vue.component('nota', require('./components/Nota.vue').default);
 Vue.component('calendario', require('./components/Calendario.vue').default);
 Vue.component('prueba', require('./components/Prueba.vue').default);
 Vue.component('editar', require('./components/Editar.vue').default);
 Vue.component('padre', require('./components/Padre.vue').default);
// Vue.component('alumnoasignatura', require('./components/AlumnoAsignatura.vue').default);
// Vue.component('maestroasignatura', require('./components/MaestroAsignatura.vue').default);

// Vue.component('grado', require('./components/Grado.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        menu:0
    }
});
