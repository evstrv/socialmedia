<template>
    <header>
        <div class="menu" :class="{open: isMenuOpen}" v-if="isLogin">
            <span @click="isMenuOpen = !isMenuOpen"></span>
            <nav>
                <router-link to="/profile">Профиль</router-link>
                <router-link to="/users">Пользователи</router-link>
            </nav>
        </div>
        <div class="notification"  v-if="isLogin" :class="{open: (isNoticeOpen && notifications.length > 0)}">
            <img :src="notificationImg" @click="isNoticeOpen = !isNoticeOpen">
            <span class="count">{{ notifications.length }}</span>
            <div>
                <div class="item" v-for="(item, id) in notifications" :key="`notice_${id}`">
                    <div>
                        <span v-if="item.type === 'ADD_FRIEND'">
                            Вас хотят добавить в друзья!
                        </span>
                    </div>
                    <div v-if="item.type === 'ADD_FRIEND'">
                        <button @click="acceptFriend(id)">Принять</button>
                        <button @click="removeNotice(id)">Отклонить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="login">
            <span @click="isFormOpen = !isFormOpen" v-if="!isLogin">Войти</span>
            <span @click="logout" v-else>Выйти</span>
            <form action="" :class="{open: isFormOpen}">
                <input type="text" placeholder="Введите логин" v-model="login">
                <input type="password" placeholder="Введите пароль" v-model="password">
                <button @click="authorize">Войти</button>
            </form>
        </div>
    </header>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    name: 'Header',
    data() {
        const isLogin = localStorage.getItem('id') && localStorage.getItem('login');

        return {
            isMenuOpen: false,
            isFormOpen: false,
            login: '',
            password: '',
            isLogin: isLogin,
            notificationImg: require('../assets/notification.png'),
            notifications: [],
            isNoticeOpen: false
        };
    },
    // computed: {
    //     isLogin() {
    //         return localStorage.getItem('id') && localStorage.getItem('login');
    //     }
    // },
    methods: {
        authorize(event) {
            event.preventDefault();
            fetch(
                '//localhost/socialmedia/api/user/authorize.php',
                {
                    method: 'post',
                    headers: {
                       'Conten-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        login: this.login,
                        password: this.password
                    })
                }
            ).then(res => res.json()).then(res => {
                // console.log(res);
                this.isFormOpen = false;
                this.isLogin = true;
                localStorage.setItem('id', res.userId);
                localStorage.setItem('login', this.login);
            });
        },
        logout() {
            localStorage.setItem('id', '');
            localStorage.setItem('login', '');
            this.isLogin = false;
            this.login = '';
            this.password = '';
        },
        submitFriend(id) {
            fetch(
                '//localhost/socialmedia/api/users.php',
                {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        userId: this.notifications[id].userId,
                        friendId: this.notifications[id].otherId
                    })
                }
            ).then(res => res.json()).then(() => {
                this.removeNotice(id);
            });
        },
        removeNotice(id) {
            fetch(
                `//localhost/socialmedia/api/notification.php?id=${this.notifications[id].ids}`,
                {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    method: 'delete'
                }
            ).then(res => res.json()).then(() => {
                this.notifications.splice(id, 1);
            });
        }
    },
    mounted() {
        fetch(
            `//localhost/socialmedia/api/notification.php?id=${localStorage.getItem('id')}`,
            {
                headers: {
                    'Content-Type': 'application/json'
                }
            }
        ).then(res => res.json()).then(res => {
            this.notifications = res.notifications || [];
        });
    }
})
</script>

<style lang="scss" scoped>
    header {
        box-shadow: 0 0 8px 0 black;
        width: 100%;
        padding: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
        background-color: white;

        > div {
            &.menu {
                position: relative;
                > span {
                    position: relative;
                    display: flex;
                    height: 30px;
                    width: 25px;
                    transition: .01s;

                    &:after, &:before {
                        transition: .4s;
                        transition-delay: .2s;
                        content: '';
                        width: 25px;
                        height: 3px;
                        // background-color: rgba(120, 120, 120, .8);
                        background-color: rgb(120, 120, 120);
                        border-radius: 5px;
                        position: absolute;
                        left: 0;
                    }

                    &:after {
                        top: 35%;
                    }

                    &:before {
                        top: 60%;
                    }
                }

                > nav {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    position: absolute;
                    left: 0;
                    border-radius: 3px;
                    height: 0;
                    overflow: hidden;
                    transition: .3s;

                    > a {
                        text-decoration: none;
                        color: black;
                        padding: 8px 8px;
                        min-width: 100px;
                        transition: .3s;

                        &:hover {
                            cursor: pointer;
                            background-color: rgba(120, 120, 120, .1);
                            transition: .3s;
                        }
                    }
                }
            }

            &.open {
                > span {
                    &:after, &:before {
                        width: calc(25px / 1.4);
                        top: calc(50% - 2px);
                        transition: top .05s;
                    }
                    
                    &:after {
                        left: 0;
                        transform: rotate(45deg);
                        transition: transform .3s;
                    } 

                    &:before {
                        left: calc(100% - (25px / 1.4) + 4px);
                        transform: rotate(-45deg);
                        transition: transform .3s;
                    }
                }
                > nav {
                    height: 136px;
                    transition: .3s;
                    transition-delay: .15s;
                    box-shadow: 0 4px 8px 0 black;
                    display: flex;
                    background-color: white;
                }
            }

            &.login {
                span {
                    padding: 4px;
                    transition: .3s;
                    border-radius: 2px;

                    &:hover {
                        cursor: pointer;
                        background-color: rgba(120, 120, 120, .1);
                        transition: .3s;
                    }
                }

                form {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    position: absolute;
                    right: 0;
                    border-radius: 3px;
                    height: 0;
                    overflow: hidden;
                    transition: .3s;

                    &.open {
                        height: 118px;
                        transition: .3s;
                        box-shadow: 0 4px 8px 0 black;
                        display: flex;
                        background-color: white;
                    }

                    input {
                        border: 2px solid rgba(110, 110, 130, .8);
                        padding: 4px 4px;
                        border-radius: 3px;
                        font-size: 1rem;
                        margin: 5px;

                        &.error {
                            border-color: red;
                        }
                    }

                    button {
                        display: flex;
                        border: 2px solid rgba(110, 110, 130, .8);
                        padding: 2px 6px;
                        border-radius: 2px;
                        font-size: .9rem;
                        font-weight: 500;
                        margin: 5px 0;
                        
                        &:hover {
                            cursor: pointer;
                        }
                    }
                }
            }

            &.notification {
                display: flex;
                position: relative;

                img {
                    width: 20px;
                    
                    &:hover {
                        cursor: pointer;
                    }
                }

                span.count {
                   border-radius: 50%;
                   background-color: lightseagreen; 
                   color: white;
                   right: -10px;
                   top: -5px;
                   position: absolute;
                   font-size: 10px;
                   padding: 3px 5px;
                   font-weight: 600;
                   line-height: 9px;
                }

                > div {
                    display: none;
                    position: absolute;
                    top: calc(100% + 5px);
                    width: 350px;
                    left: -175px;
                    box-shadow: 0 4px 8px 0 black;
                    background-color: #fff;
                    padding: .5rem;

                    > .item {
                        display: flex;
                        width: 100%;
                        justify-content: space-between;
                        align-items: center;

                        > div:last-child {
                            display: flex;
                            flex-direction: column;

                            > button {
                                background-color: lightseagreen;
                                color: white;
                                border-radius: 4px;
                                padding: .3rem .5rem;
                                border: none;

                                &:hover {
                                    cursor: pointer;
                                }

                                &:first-child {
                                    margin-bottom: 5px;
                                }
                            }
                        }

                        &:not(:last-child) {
                            padding-bottom: .5rem;
                            margin-bottom: .5rem;
                            border-bottom: 1px solid grey;
                        }
                    }
                }

                &.open {
                    > div {
                        display: flex;
                    }
                }
            }
        }
    }
</style>