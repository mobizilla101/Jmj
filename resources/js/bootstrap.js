import axios from 'axios';
import Alpine from 'alpinejs'
import 'animate.css';
import WOW from 'wow.js'
import './swiper.js'
import './magnifier.js'


window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.start();
}

new WOW().init();


