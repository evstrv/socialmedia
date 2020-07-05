<template>
    <div class="profile">
        <div class="body">
            <div class="menu">
                <div class="card">
                    <div class="head">
                        <label>
                            <img :src="avatar" :alt="name">
                            <span>Изменить</span>
                            <input type="file" name="avatar" @change="upload">
                        </label>
                        <div>{{name}}</div>
                    </div>
                    <div class="body">
                        <div>Личный данные</div>
                        <div>Приватность</div>
                        <div>Настройки</div>
                    </div>
                </div>
            </div>
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
                successRegistration: false,
                avatar: ''
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
            },
            upload(event) {
                console.log(event);
                const data = new FormData();
                data.append('file', event.target.files[0]);
                data.append('userId', localStorage.getItem('id'));

                fetch(
                    '//localhost/socialmedia/api/user/user.php',
                    {
                        method: 'post',
                        // headers: {
                        //     'Content-Type': 'multipart/form-data'
                        // },
                        body: data
                    }
                ).then(res => res.json()).then(res => {
                    // console.log(res);
                    if(res.res) {
                        this.avatar = res.src;
                    }
                });
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
                let strDate = date.getFullYear() + '-';
                const month = '' + date.getMonth();
                const day = '' + date.getDate();

                strDate += (month.length < 2 ? '0' + month : month) + '-';
                strDate += (day.length < 2 ? '0' + day : day);

                this.name = res.user.name;
                this.type = res.user.type;
                this.dateOpen = strDate;
                this.login = res.user.login;
                this.avatar = res.user.login || '../assets/noimage.png';
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

            .menu {
                width: 30%;
                height: 100%;

                .card {
                    display: flex;
                    flex-direction: column;
                    margin: 3rem auto 0;
                    width: 80%;
                    background-color: white;
                    box-shadow: 0 0 12px rgba(0, 0, 0, .1);
                    box-sizing: border-box;
                    border-radius: 3px;

                    .head {
                        text-align: center;
                        padding: 1rem;
                        box-sizing: border-box;

                        label {
                            width: 120px;
                            height: 120px;
                            border-radius: 50%;
                            overflow: hidden;
                            position: relative;
                            display: flex;
                            margin: 0 auto;

                            img {
                                width: 100%;
                                height: 100%;
                            }

                            span {
                                display: flex;
                                opacity: 0;
                                position: absolute;
                                width: 100%;
                                height: 100%;
                                align-items: center;
                                justify-content: center;
                                background-color: rgba(0, 0, 0, .4);
                                font-size: 1.1rem;
                                transition: .5s;
                                color: white;
                                letter-spacing: -.8px;
                                font-weight: 600;
                                border-radius: 50%;
                            }
                            
                            input {
                                display: none;
                            }

                            &:hover {
                                cursor: pointer;

                                span {
                                    opacity: 1;
                                    transition: .5s;
                                }
                            }
                        }

                        div {
                            font-size: 1.7rem;
                            font-weight: 600;
                        }
                    }

                    .body {
                        display: flex;
                        flex-direction: column;
                        box-sizing: border-box;
                        border-top: 2px solid rgba(0, 0, 0, .3);
                        
                        > div {
                            padding: 1rem;
                            box-sizing: border-box;
                            transition: .5s;

                            &:not(:last-child) {
                                border-bottom: .5px solid rgba(0, 0, 0, .3);
                            }

                            &:hover {
                                background-color: rgba(0, 0, 0, .1);
                                transition: .5s;
                                cursor: pointer;
                            }
                        }
                    }
                }
            }

            .form {
                width: 70%;
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
                    margin: 0 auto;

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