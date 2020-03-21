<template>
    <header>
        <div class="menu">
            <span></span>
            <nav>
                <a href="">Text</a>
                <a href="">Text</a>
                <a href="">Text</a>
                <a href="">Text</a>
            </nav>
        </div>
        <div class="login">
            Login
        </div>
    </header>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    name: 'Header'
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
    }
</style>