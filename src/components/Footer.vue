<template>
    <footer>
        <span>© 2020 Bacterium, Inc.</span>
    </footer>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
    name: 'Footer'
})
</script>

<style lang="scss" scoped>
    footer {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: auto;
        padding: 16px 0 8px;
    }
</style>