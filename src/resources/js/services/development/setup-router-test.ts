import { createApp } from 'vue';

import RouterTestArea from './vue/RouterTestArea.vue';

import router from './router-test/router'

const el = document.getElementById('test-root');
if (el) {
  const all: any = JSON.parse(el.dataset.all);

  console.log('vue all', all);

  createApp(RouterTestArea, { name: all.name }).use(router).mount(el);
}
