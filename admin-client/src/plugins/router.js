import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Panel from '../views/Panel'
import Table from "../components/Table";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: "/",
            component: Home,
            name: 'home',
        },
        {
            path: "/panel",
            component: Panel,
            name: 'panel',
            children: [
                {
                    path: '/table',
                    component: Table,
                    name: 'panel_table'
                },
            ]

        }
    ]
});