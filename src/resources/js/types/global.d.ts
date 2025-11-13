import axios from 'axios';
import Alpine from 'alpinejs';

declare global {
  interface Window {
    axios: typeof axios;
    Alpine: typeof Alpine;
  }
}
