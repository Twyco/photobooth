import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import vuetify from "@/application/vuetify";
import {createPinia} from "pinia";

const appName = import.meta.env.VITE_APP_NAME || 'Fotobox';

createInertiaApp({
  title: (title) => title ? `${title} - ${appName}`: appName,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./Pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(vuetify)
      .use(createPinia())
      .use(ZiggyVue)
      .mount(el);
  },
  progress: {
    color: '#4B5563'
  }
});
