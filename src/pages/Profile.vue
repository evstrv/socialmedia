<template>
    <div class="profile">
        <div class="body">
            <div class="news"></div>
            <div class="form">
                <form action="">
                    <label for="">
                        <span>Название</span>
                        <input type="text" v-model="name" :class="{error: isError && !name}">
                        <span v-show="isError && !name">
                            Название не может быть пустым!
                        </span>
                    </label>
                    <label for="">
                        <span>Тип</span>
                        <input type="text" v-model="type" :class="{error: isError && !type}">
                        <span v-show="isError && !type">
                            Тип не может быть пустым!
                        </span>
                    </label>
                    <label for="">
                        <span>Дата открытия</span>
                        <input type="date" v-model="dateOpen" :class="{error: isError && !dateOpen}">
                        <span v-show="isError && !dateOpen">
                            Дата открытия не может быть пустой!
                        </span>
                    </label>
                    <label for="">
                        <span>Логин</span>
                        <input type="text" v-model="login" :class="{error: isError && !login}">
                        <span v-show="isError && !login">
                            Логин не может быть пустым!
                        </span>
                    </label>
                    <label for="">
                        <span>Пароль</span>
                        <input type="password" v-model="password" :class="{error: isError && (!password || password !== checkPass)}">
                        <span v-show="isError && !password">
                            Пароль не может быть пустым!
                        </span>
                    </label>
                    <label for="">
                        <span>Повторите пароль</span>
                        <input type="password" v-model="checkPass" :class="{error: isError && (!checkPass || password !== checkPass)}">
                        <span v-show="isError && (!checkPass || !password || password !== checkPass)">
                            Пароль не может быть пустым!
                        </span>
                    </label>
                    <button @click="submit">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Profile',
        data() {
            return {
                name: '',
                type: '',
                dateOpen: '',
                login: '',
                password: '',
                checkPass: '',
                needCheck: false,
                successRegistration: false
            };
        },
        computed: {
            isError() {
                if(this.needCheck) {
                    return !((this.password && this.password === this.checkPass) && 
                        this.name && this.type && this.dateOpen && this.login);
                }
                return false;
            }
        },
        methods: {
            submit(event) {
                event.preventDefault();
                this.needCheck = true;
                if(!this.isError) {
                    const body = {
                        name: this.name,
                        type: this.type,
                        dateOpen: new Date(this.dateOpen).valueOf() / 1000,
                        login: this.login
                    };
                    if(this.password) {
                        body.password = this.password;
                    }
                    fetch(
                        '//localhost/socialmedia/api/user/user.php?id='+localStorage.getItem('id'), 
                        {
                            method: 'get',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(body)
                        }
                    ).then(res => res.json()).then(res => {
                        console.log(res);
                    });
                }
            }
        },
        mounted() {
            fetch(
                '//localhost/socialmedia/api/user/user.php?id='+localStorage.getItem('id'), 
                {
                    method: 'get',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
            ).then(res => res.json()).then(res => {
                console.log(res);
                const date = new Date(+res.user.dateOpen * 1000);
                this.name = res.user.name;
                this.type = res.user.type;
                this.dateOpen = `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`;
                this.login = res.user.login;
            });
        }
    }
</script>

<style lang="scss" scoped>
    .profile {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;

        .body {
            height: 80%;
            width: 100%;
            display: flex;

            .news {
                width: 60%;
                height: 100%;
            }

            .form {
                width: 40%;
                height: 100%;
                padding: 16px 0 0 16px;
                box-sizing: border-box;

                h2 {
                    margin: 16px 0 8px;
                    font-size: .9rem;
                    color: rgb(110, 180, 120);
                }

                form {
                    display: flex;
                    flex-direction: column;
                    width: 80%;

                    label {
                        display: flex;
                        flex-direction: column;
                        margin-bottom: 12px;

                        span {
                            text-transform: uppercase;
                            margin-left: 2px;

                            &:first-child {
                                color: rgba(110, 110, 130, .8);
                                font-size: .9rem;
                                margin-bottom: 4px;
                            }

                            &:last-child {
                                font-size: .6rem;
                                margin-top: 4px;
                                color: red;
                            }
                        }

                        input {
                            border: 2px solid rgba(110, 110, 130, .8);
                            padding: 6px 4px;
                            border-radius: 3px;
                            font-size: .9rem;

                            &.error {
                                border-color: red;
                            }
                        }
                    }

                    button {
                        display: flex;
                        margin: 16px auto 0;
                        border: 2px solid rgba(110, 110, 130, .8);
                        padding: 10px 8px;
                        text-transform: uppercase;
                        border-radius: 2px;
                        font-size: .9rem;
                        font-weight: 500;
                        
                        &:hover {
                            cursor: pointer;
                        }
                    }
                }
            }
        }
    }
</style>