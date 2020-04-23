import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Panel from '../views/Panel'

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: "/",
            name: "home",
            component: Home
        },
        {
            path: "/panel",
            name: "panel",
            component: Panel
        }
    ]
});