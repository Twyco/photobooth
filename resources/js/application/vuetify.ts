import 'vuetify/styles'
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'

export default createVuetify({
  display: {
    mobileBreakpoint: 'sm',
  },
  components,
  directives,
  theme: {
    defaultTheme: 'dark',
    themes: {
      dark: {
        dark: true,
        colors: {
          primary: "#e5e7eb",
          secondary: "#2563eb",
          'dark-background': "#131314"
        }
      }
    }
  }
});