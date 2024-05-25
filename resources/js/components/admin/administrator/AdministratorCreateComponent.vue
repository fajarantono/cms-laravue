<template>
    <LoadingComponent :props="loading" />
    <SmSidebarModalCreateComponent :props="addButton" />

    <div id="sidebar" class="drawer">
        <div class="drawer-header">
            <h3 class="drawer-title">{{ $t("menu.administrators") }}</h3>
            <button class="fa-solid fa-xmark close-btn" @click="reset"></button>
        </div>
        <div class="drawer-body">
            <form @submit.prevent="save">
                <div class="form-row">
                    <div class="form-col-12 sm:form-col-6">
                        <label for="name" class="mx-field-title required">
                            {{ $t("label.name")}}
                        </label>
                        <input type="text" id="name" class="mx-field-control" />
                        <small class="db-field-alert" v-if="errors.name">
                            {{ errors.name[0] }}
                        </small>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label for="email" class="mx-field-title required">
                            {{ $t("label.email") }}
                        </label>
                        <input type="text" id="email" class="mx-field-control" />
                        <small class="db-field-alert" v-if="errors.email">
                            {{ errors.email[0] }}
                        </small>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label for="phone" class="mx-field-title">{{ $t('label.phone') }}</label>
                        <div :class="errors.phone ? 'invalid' : ''" class="mx-field-control flex items-center">
                            <div class="w-fit flex-shrink-0 dropdown-group">
                                <button type="button" class="flex items-center gap-1 dropdown-btn">
                                    {{ flag }}
                                    <span class="whitespace-nowrap flex-shrink-0 text-xs">
                                        <!-- {{ props.form.country_code }} -->
                                    </span>
                                    <input type="hidden">
                                </button>
                            </div>
                            <input v-on:keypress="phoneNumber($event)" type="text" id="phone"
                                class="pl-2 text-sm w-full h-full" />
                        </div>
                        <small class="mx-field-alert" v-if="errors.phone">
                            {{ errors.phone[0] }}
                        </small>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label class="mx-field-title required" for="active">{{ $t("label.status") }}</label>
                        <div class="mx-field-radio-group">
                            <div class="mx-field-radio">
                                <div class="custom-radio">
                                    <input :value="enums.statusEnum.ACTIVE" id="active" type="radio"
                                        class="custom-radio-field" />
                                    <span class="custom-radio-span"></span>
                                </div>
                                <label for="active" class="mx-field-label">{{ $t("label.active") }}</label>
                            </div>
                            <div class="mx-field-radio">
                                <div class="custom-radio">
                                    <input :value="enums.statusEnum.INACTIVE" type="radio" id="inactive"
                                        class="custom-radio-field" />
                                    <span class="custom-radio-span"></span>
                                </div>
                                <label for="inactive" class="mx-field-label">{{ $t("label.inactive") }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label for="password" class="mx-field-title required">{{ $t("label.password") }}</label>
                        <input type="password" id="password" class="mx-field-control" autocomplete="off" />
                        <small class="db-field-alert" v-if="errors.password">{{ errors.password[0] }}</small>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label for="password_confirmation"
                            class="mx-field-title required">{{ $t("label.password_confirmation")}}</label>
                        <input type="password" id="password_confirmation" class="mx-field-control" autocomplete="off" />
                        <small class="mx-field-alert"
                            v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</small>
                    </div>

                    <div class="form-col-12 sm:form-col-6">
                        <label class="mx-field-title required" for="current_branch">{{ $t("label.branch") }}</label>
                        <div class="mx-field-radio-group">
                            <div class="mx-field-radio">
                                <div class="custom-radio">
                                    <input class="custom-radio-field" />
                                    <span class="custom-radio-span"></span>
                                </div>
                                <label for="current_branch"
                                    class="mx-field-label">{{ $t("label.current_branch") }}</label>
                            </div>
                            <div class="mx-field-radio">
                                <div class="custom-radio">
                                    <input class="custom-radio-field" type="radio" id="all_branch" value="0" />
                                    <span class="custom-radio-span"></span>
                                </div>
                                <label for="all_branch" class="mx-field-label">{{ $t("label.all_branch") }}</label>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="drawer-footer">
            <button type="button" class="modal-btn-outline modal-close" @click="reset">
                <i class="lab lab-close"></i>
                <span>{{ $t("button.close") }}</span>
            </button>
            <button type="button" class="mx-btn py-2 text-white bg-primary" @click="save">
                <i class="lab lab-save"></i>
                <span>{{ $t("label.save") }}</span>
            </button>
        </div>
    </div>
</template>
<script>
import SmSidebarModalCreateComponent from '../components/buttons/SmSidebarModalCreateComponent.vue';
import LoadingComponent from '../components/LoadingComponent.vue';
import statusEnum from "../../../enums/modules/statusEnum";
import alertService from "../../../services/alertService";
import appService from '../../../services/appService';

export default {
    name: "AdministratorCreateComponent",
    components: {
        SmSidebarModalCreateComponent,
        LoadingComponent,
    },
    props: ["props"],
    data() {
        return {
            loading: {
                isActive: false,
            },
            addButton: {
                title: this.$t("button.add_administrator"),
            },
            enums: {
                statusEnum: statusEnum,
                statusEnumArray: {
                    [statusEnum.ACTIVE]: this.$t("label.active"),
                    [statusEnum.INACTIVE]: this.$t("label.inactive"),
                },
            },
            errors: {},
            flag: "",
            country_code: "",
        }
    },
    mounted() {
        //this.loading.isActive = true;
    },
    computed: {
        countryCode: function () {
            return this.$store.getters['countryCode/show'];
        }
    },
    methods: {
        reset: function () {
            appService.sideDrawerHide();
        },

        save: function () {
            try {
                const tempId = this.$store.getters["administrator/temp"].temp_id;
                this.loading.isActive = true;
                this.$store.dispatch("administrator/save", this.props).then((res) => {
                    appService.sideDrawerHide();
                    this.loading.isActive = false;
                    alertService.successFlip(
                        tempId === null ? 0 : 1,
                        this.$t("menu.administrators")
                    );
                    this.props.form = {
                        name: "",
                        email: "",
                        phone: "",
                        password: "",
                        password_confirmation: "",
                        branch_id: this.defaultAccess.branch_id,
                        status: statusEnum.ACTIVE,
                        country_code: this.country_code,
                    };
                    this.errors = {};
                }).catch((err) => {
                    this.loading.isActive = false;
                    this.errors = err.response.data.errors;
                })
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err);
            }
        },

        phoneNumber(e) {
            return appService.phoneNumber(e);
        },
    }
}
</script>
