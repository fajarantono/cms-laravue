<template>
    <aside class="mx-sidebar">
        <div class="mx-sidebar-header">

            <button class="fa-solid fa-xmark xmark-btn close-mx-menu"></button>
        </div>
<!--        {{ menus }}-->
        <nav class="mx-sidebar-nav">
            <ul class="mx-sidebar-nav-list" v-if="menus.length > 0" v-for="menu in menus" :key="menu">
                <li class="mx-sidebar-nav-item" v-if="menu.url === '#'">
                    <a href="javascript:void(0);" class="mx-sidebar-nav-title">
                        {{ $t('menu.' + menu.language) }}
                    </a>
                </li>

                <li class="mx-sidebar-nav-item" v-else>
                    <router-link :to="'/admin/' + menu.url" class="mx-sidebar-nav-menu">
                        <i class="text-sm" :class="menu.icon"></i>
                        <span class="text-base flex-auto">{{ $t('menu.' + menu.language) }}</span>
                    </router-link>
                </li>

                <li class="mx-sidebar-nav-item" v-if="menu.children" v-for="children in menu.children">
                    <router-link :to="'/admin/' + children.url" class="mx-sidebar-nav-menu">
                        <i class="text-sm" :class="children.icon"></i>
                        <span class="text-base flex-auto">{{ $t('menu.' + children.language) }}</span>
                    </router-link>
                </li>
            </ul>
        </nav>
    </aside>
</template>

<script>
export default {
    name: "BackendMenuComponent",
    data: function () {
        return {
            activeParentId: 1,
            activeChildId: 0
        }
    },
    computed: {
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        },
        menus: function () {
            return this.$store.getters.authMenu;
        }
    }
}
</script>
