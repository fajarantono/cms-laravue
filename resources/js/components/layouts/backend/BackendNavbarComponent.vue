<template>
    <div class="backdrop"></div>
    <header class="mx-header">
        <router-link class="w-40 flex-shrink-0" :to="{ name: 'admin.dashboard' }">
            <!-- <img class="w-full" :src="setting.theme_logo" alt="logo"> -->
        </router-link>
        <div class="flex items-center justify-end w-full gap-4">
            <div
                class="sub-header flex items-center gap-4 transition xh:justify-between xh:fixed xh:left-0 xh:w-full xh:p-4 xh:border-y xh:border-[#EFF0F6] xh:bg-white">
                <div v-if="authBranch === 0" class="relative dropdown-group">
                    <button class="flex items-center text-left gap-2 dropdown-btn">
                        <i class="lab lab-shop lab-font-size-24 font-fill-primary"></i>
                        <h3 class="capitalize text-xs font-medium text-heading">
                            <span class="block font-normal mb-0.5">{{ $t('label.branch') }}</span>
                            <!-- <b class="font-semibold whitespace-nowrap">{{ branch.name }}</b> -->
                        </h3>
                        <i class="lab lab-arrow-down text-xs ml-1.5 lab-font-size-14"></i>
                    </button>

                </div>


            </div>
            <button class="fa-solid fa-align-left db-header-nav w-9 h-9 rounded-lg text-primary bg-primary/5"></button>

            <div class="dropdown-group">
                <button class="dropdown-btn flex items-center gap-2">

                    <h3 class="whitespace-nowrap text-sm capitalize text-left leading-[17px]">{{ $t('label.hello') }} <b
                            class="block font-semibold">{{ textShortener(authInfo.name, 15) }}</b></h3>
                    <i class="lab lab-arrow-down text-xs ml-1.5 lab-font-size-14"></i>
                </button>
                <div
                    class="dropdown-list fixed sm:absolute top-[75px] sm:top-12 right-0 z-[60] rounded-xl w-full h-[calc(100vh_-_75px)] overflow-y-auto sm:h-auto sm:w-[360px] p-4 shadow-paper bg-white">
                    <div class="w-fit mx-auto text-center mb-5">
                        <figure
                            class="relative z-10 w-[98px] h-[98px] border-2 border-dashed rounded-full inline-flex items-center justify-center border-white bg-gradient-to-t from-[#FF7A00] to-[#FF016C] before:absolute before:top-1/2 before:left-1/2 before:-translate-x-1/2 before:-translate-y-1/2 before:w-24 before:h-24 before:rounded-full before:-z-10 before:bg-white">

                        </figure>

                        <label for="imageProperty"
                            class="block w-11 h-11 mx-auto -mt-7 mb-3 relative z-10 rounded-full border-2 cursor-pointer bg-heading border-white">
                            <input @change="saveImage" accept="image/png, image/jpeg, image/jpg" ref="imageProperty"
                                type="file" id="imageProperty"
                                class="w-full h-full rounded-full opacity-0 cursor-pointer">
                            <i
                                class="lab lab-edit-2 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 -z-10 lab-font-size-24 lab-font-color-1"></i>
                        </label>

                        <h3 class="font-medium text-sm leading-6 capitalize mb-0.5">
                            {{ textShortener(authInfo.name, 20) }}
                        </h3>
                        <p class="text-xs mb-0.5">{{ authInfo.email }}</p>
                        <p class="text-xs">{{ authInfo.country_code }}{{ authInfo.phone }}</p>
                        <h3 class="font-medium text-sm leading-6 capitalize mb-0.5">{{ authInfo.currency_balance }}</h3>
                    </div>
                    <nav>
                        <!-- <router-link :to="{ name: 'admin.profile.editProfile' }"
                            class="paper-link transition w-full flex items-center gap-3.5 py-3 border-b last:border-none border-[#EFF0F6]">
                            <i class="lab lab-edit lab-font-size-17"></i>
                            <span class="text-sm leading-6 capitalize">{{ $t('button.edit_profile') }}</span>
                        </router-link>

                        <router-link :to="{ name: 'admin.profile.changePassword' }"
                            class="paper-link transition w-full flex items-center gap-3.5 py-3 border-b last:border-none border-[#EFF0F6]">
                            <i class="lab lab-key lab-font-size-17"></i>
                            <span class="text-sm leading-6 capitalize">{{ $t('button.change_password') }}</span>
                        </router-link>

                        <button @click="logout()"
                            class="paper-link transition w-full flex items-center gap-3.5 py-3 border-b last:border-none border-[#EFF0F6]">
                            <i class="lab lab-logout lab-font-size-17"></i>
                            <span class="text-sm leading-6 capitalize">{{ $t('button.logout') }}</span>
                        </button> -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import appService from "../../../services/appService";

export default {
    name: "BackendNavbarComponent",
    data() {
        return {
            loading: {
                isActive: false,
            },
            defaultBranch: null,
            defaultLanguage: null,
        }
    },
    computed: {
        authInfo: function() {
            return this.$store.getters.authInfo;
        },
        authBranch: function () {
            return this.$store.getters.authBranchId;
        },
    },
    mounted() {
        appService.responsiveLoad();
    },
    methods: {
        textShortener: function (text, number = 30) {
            return appService.textShortener(text, number);
        },
    }
}
</script>
