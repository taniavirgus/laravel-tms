import 'flowbite';
import axios from 'axios';
import alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Alpine = alpine;
alpine.start();

createIcons({
  icons,
});
