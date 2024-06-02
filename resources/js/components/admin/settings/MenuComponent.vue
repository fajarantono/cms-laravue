<template>
    <button
        class="settings-btn w-full md:hidden flex items-center justify-center gap-2 p-2 rounded bg-primary text-white">
        <span class="capitalize">{{ $t('menu.settings_menu') }}</span>
        <i class="fa-solid fa-chevron-down text-sm"></i>
    </button>
    <div class="h-0 overflow-hidden md:h-auto md:overflow-auto transition-all duration-300">
        <nav class="mx-card p-3">
            <router-link :to="{ name: 'admin.settings.company' }" class="mx-tab-btn">
                <i class="lab lab-company text-sm"></i>
                {{ $t("menu.company") }}
            </router-link>
            <router-link :to="{ name: 'admin.settings.branch' }" class="mx-tab-btn">
                <i class="lab lab-branches text-sm"></i>
                {{ $t("menu.branches") }}
            </router-link>
        </nav>
    </div>
</template>

<script>
export default {
    name: "MenuComponent",
};
</script>
