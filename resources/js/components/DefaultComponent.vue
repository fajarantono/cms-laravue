<template>
    <div v-if="theme === 'frontend'">
        <router-view></router-view>
    </div>

    <div v-if="theme === 'backend'">
        <main class="db-main" v-if="logged">
            <router-view></router-view>
        </main>

        <div v-if="!logged">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DefaultComponent",
        data() {
            return {
                theme: "frontend",
            }
        },
        computed: {
            logged: function () {
                return this.$store.getters.authStatus;
            }
        },
    }
</script>
