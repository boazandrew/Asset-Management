import axios from 'axios';
import { gsap } from "gsap";
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
gsap.from(".box", { opacity: 0, y: 50, duration: 1 });

