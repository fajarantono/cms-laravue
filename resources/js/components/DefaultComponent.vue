<template>
    <div v-if="theme === 'frontend'">
        <router-view></router-view>
    </div>

    <div v-if="theme === 'backend'">
        <main class="mx-main" v-if="logged">
            <BackendNavbarComponent/>
            <BackendMenuComponent />
            <router-view></router-view>
        </main>

        <div v-if="!logged">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import BackendNavbarComponent from "./layouts/backend/BackendNavbarComponent.vue";
    import BackendMenuComponent from "./layouts/backend/BackendMenuComponent.vue";
    export default {
        name: "DefaultComponent",
        components: {
            BackendNavbarComponent,
            BackendMenuComponent
        },
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
        beforeMount() {
            this.$store.dispatch('frontendSetting/lists').then(res => {

            }).catch();
        },
        watch: {
            $route(e) {
                if (e.meta.isFrontend === true) {
                    this.theme = "frontend";
                } else if (e.meta.isTable === true) {
                    this.theme = "table";
                } else {
                    this.theme = "backend";
                }
            }
        }
    }
</script>
