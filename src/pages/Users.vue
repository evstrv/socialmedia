<template>
    <div class="users">
        <div class="search"></div>
        <div class="users-list">
            <div class="item" v-for="(item, id) in users" :key="`user_item_${id}`">
                <div class="img">
                    <img :src="item.avatar || noImage" :alt="name">
                </div>
                <div class="info">
                    <div class="name">{{ item.name }} <span v-if="item.id === userId">Это вы</span></div>
                    <div class="type">{{ item.type }}</div>
                    <div class="button" v-if="item.id !== userId" @click="submitRequestFriend(item.id)">
                        <button>Добавить в друзья</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Users',
    data() {
        return {
            users: [],
            search: '',
            noImage: '//localhost/socialmedia/src/assets/noimage.png',
            userId: localStorage.getItem('id')
        };
    },
    methods: {
        submitRequestFriend(friendId) {
            fetch(
                '//localhost/socialmedia/api/users/friends.php',
                {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    method: 'post',
                    body: JSON.stringify({
                        userId: this.userId,
                        friendId
                    })
                }
            ).then(res => res.json()).then(res => {
                console.log(res);
            });
        }
    },
    mounted() {
        fetch(
            '//localhost/socialmedia/api/users/index.php',
            {
                headers: {
                    'Content-Type': 'application0/json'
                }
            }
        ).then(res => res.json()).then(res => {
            console.log(res);
            this.users = res.users || [];
        });
    }
}
</script>

<style lang="scss" scoped>
    .users {
        width: 100;

        .search {

        }

        &-list {
            display: flex;
            flex-direction: column;
            margin: 2rem;

            .item {
                display: flex;
                width: 100%;
                box-shadow: 0 0 16px rgba(0, 0, 0, .2);
                border-radius: 4px;
                padding: 2rem;
                box-sizing: border-box;

                &:not(:first-child) {
                    margin-top: 2rem;
                }

                .img {
                    min-width: 120px;
                    max-width: 120px;
                    min-height: 120px;
                    max-height: 120px;
                    display: flex;
                    align-items: center;
                    justify-content: center;

                    img {
                        width: auto;
                        max-width: 120px;
                        height: 100%;
                        max-height: 120px;
                        border-radius: 50%;
                    }
                }

                .info {
                    display: flex;
                    flex-direction: column;
                    margin-left: 2rem;
                    width: 100%;

                    .name {
                        font-size: 2rem;
                        margin-bottom: 1rem;
                        
                        span {
                            color: green;
                            font-size: 1rem;
                            margin-left: 1rem;
                            font-weight: 600;
                        }
                    }

                    .type {
                        font-weight: 500;
                        font-size: 1rem;
                        font-style: italic;
                    }

                    .button {
                        margin-top: auto;
                        display: flex;
                        align-items: center;
                        justify-content: flex-end;
                        
                        button {
                            border: none;
                            background-color: lightseagreen;
                            color: white;
                            padding: .6rem 1rem;
                            font-size: 1rem;
                            border-radius: 4px;
                        }
                    }
                }
            }
        }
    }
</style>