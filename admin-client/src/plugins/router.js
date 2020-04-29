import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Panel from '../views/Panel'

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: "/",
            name: "login",
            component: Home
        },
        {
            path: "/panel",
            name: "panel",
            component: Panel
        }
    ]
});