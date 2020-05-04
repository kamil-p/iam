import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Panel from '../views/Panel'
import Table from '../components/Table';
import UserForm from '../components/UserForm';
import store from './store';

Vue.use(VueRouter);

const router = new VueRouter({
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
                    path: '/panel/table',
                    component: Table,
                    name: 'panel_table'
                },
                {
                    path: '/panel/user/:userId',
                    component: UserForm,
                    name: 'panel_user'
                }
            ]

        }
    ]
});

router.beforeEach((to, from, next) => {
    const user = store.state.account.user;
    if (user && !user.token.expired() && to.name === 'home') {
        next({name: 'panel_table'});
    } else if (user === null && to.name !== 'home') {
        next({ name: 'home'});
    }
    next();
})


export default router;