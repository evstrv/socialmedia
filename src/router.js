import Profile from './pages/Profile';
import VueRouter from "vue-router"; //npm i vue-router
import Main from "./pages/Main";
import Users from "./pages/Users";

const routes = [
    {path: '/', component: Main},
    {path: '/profile', component: Profile},
    {path: '/users', component: Users}
];

export default new VueRouter({routes});