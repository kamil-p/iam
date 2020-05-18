import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify';
import store from './plugins/store'
import router from './plugins/router';
import vueMoment from './plugins/vueMoment';

Vue.config.productionTip = false

new Vue({
  vuetify,
  store,
  router,
  vueMoment,
  render: h => h(App)
}).$mount('#app')
