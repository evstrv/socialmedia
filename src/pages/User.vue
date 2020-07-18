<template>
    <div class="user">
        <div class="info">
            <div class="avatar">
                <img :src="user.avatar" :alt="user.name">
            </div>
        </div>
        <div class="desc">
            <h1>{{ user.name }}<span class="online">Онлайн</span></h1>
            <h3>{{ user.type }}</h3>
            <div class="date">Дата открытия: <span>{{ user.dateOpen }}</span></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'User',
        data() {
            return {
                user: {}
            }
        },
        mounted() {
            fetch(
                `//localhost/socialmedia/api/user/user.php?id=${this.$route.params.id}`,
                {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
            ).then(res => res.json()).then(res => {
                this.user = res.user;
                console.log(this.user);
            });
        }
    }
</script>

<style lang="scss" scoped>
    .user {
        display: flex;
        width: 100%;

        .info {
            width: 30%;
            box-sizing: border-box;
            margin: 2rem 2rem 0;
            padding: .5rem;
            border-radius: 4px;
            box-shadow: 0 0 8px rgba(0, 0, 0, .2);
            background-color: #fff;

            .avatar {
                width: 100%;
                margin: 0 auto;

                img {
                    width: 100%;
                    height: auto;
                }
            }
        }

        .desc {
            width: 70%;
            box-sizing: border-box;
            margin: 2rem 2rem 0;

            h1 {
                margin: 0;
                padding: 0;
                line-height: 1;
                font-size: 2rem;
                font-weight: 500;
                display: flex;
                
                span {
                    font-size: .8rem;
                    margin-left: .5rem;

                    &.online {
                        color: green;
                    }

                    &.offline {
                        color: red;
                    }
                }
            }

            h3 {
                font-weight: 400;
                font-size: 1.3rem;
                margin: 1rem 0 1rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid grey;
            }

            .date {
                span {
                    font-size: 1.5rem;
                    font-weight: 500;
                }
            }
        }
    }
</style>