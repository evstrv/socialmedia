import Profile from './pages/Profile';
import VueRouter from "vue-router"; //npm i vue-router
import Main from "./pages/Main"

const routes = [
    {path: '/', component: Main},
    {path: '/profile', component: Profile}
];

export default new VueRouter({routes});