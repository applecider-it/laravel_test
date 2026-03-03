import { createRouter, createWebHashHistory } from 'vue-router';

import Page1 from '../vue/router-test-area/Page1.vue';
import Page2 from '../vue/router-test-area/Page2.vue';

const routes = [
  { path: '/', component: Page1 },
  { path: '/page2/:id', component: Page2 },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
