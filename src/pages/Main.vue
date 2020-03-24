<template>
    <div class="main">
        <div class="banner">

        </div>
        <div class="body">
            <div class="news"></div>
            <div class="form">
                <h2 v-if="successRegistration">Вы успешно зарегистрированы!</h2>
                <form action="">
                    <label for="">
                        <span>Имя</span>
                        <input type="text" v-model="name" :class="{error: isError && !name}">
                        <span v-show="isError && !name">
                            Введите имя!
                        </span>
                    </label>
                    <label for="">
                        <span>Фамилия</span>
                        <input type="text" v-model="surname" :class="{error: isError && !surname}">
                        <span v-show="isError && !surname">
                            Введите фамилию!
                        </span>
                    </label>
                    <label for="">
                        <span>Почта</span>
                        <input type="email" v-model="email" :class="{error: isError && !email}">
                        <span v-show="isError && !email">
                            Введите почту!
                        </span>
                    </label>
                    <label for="">
                        <span>Телефон</span>
                        <input type="text" v-model="phone" :class="{error: isError && !phone}">
                        <span v-show="isError && !phone">
                            Введите телефон!
                        </span>
                    </label>
                    <label for="">
                        <span>Дата рождения</span>
                        <input type="date" v-model="birthday" :class="{error: isError && !birthday}">
                        <span v-show="isError && !birthday">
                            Введите дату рождения!
                        </span>
                    </label>
                    <label for="">
                        <span>Пароль</span>
                        <input type="password" v-model="password" :class="{error: isError && (!password || password !== checkPass)}">
                        <span v-show="isError && !password">
                            Введите пароль!
                        </span>
                    </label>
                    <label for="">
                        <span>Повторите пароль</span>
                        <input type="password" v-model="checkPass" :class="{error: isError && (!checkPass || password !== checkPass)}">
                        <span v-show="isError && (!checkPass || !password || password !== checkPass)">
                            Пароли не совпадают!
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
    name: 'Main',
    data() {
        return {
            name: '',
            surname: '',
            email: '',
            phone: '',
            birthday: '',
            password: '',
            checkPass: '',
            needCheck: false,
            successRegistration: false
        };
    },
    computed: {
        isError() {
            if(this.needCheck) {
                return !(this.password === this.checkPass && this.name && this.surname && this.email && this.phone && this.birthday);
            }
            return false;
        }
    },
    methods: {
        submit(event) {
            event.preventDefault();
            this.needCheck = true;
            if(!this.isError) {
                fetch(
                    '//localhost/socialmedia/api/user/registration.php',
                    {
                        method: 'post',
                        headeres: {
                            'Conten-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            name: this.name,
                            surname: this.surname,
                            email: this.email,
                            phone: this.phone,
                            birthday: new Date(this.birthday).valueOf() / 1000,
                            password: this.password
                        })
                    }
                ).then(res=>res.json()).then(res=>{
                    console.log(res);
                    if(res && res.res) {
                        this.name = '';
                        this.surname = '';
                        this.email = '';
                        this.phone = '';
                        this.birthday = '';
                        this.password = '';
                        this.checkPass = '';
                        this.needCheck = false;
                        this.successRegistration = true;
                    }
                }).catch(err=>{
                    console.log(err);
                });
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    .main {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;

        .banner {
            height: 20%;
            width: 100%;
        }

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