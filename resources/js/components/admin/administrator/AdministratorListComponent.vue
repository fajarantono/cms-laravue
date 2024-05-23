<template>
    <LoadingComponent :props="loading" />
    <div class="col-12">
        <div class="mx-card">
            <div class="mx-card-header border-none">
                <h3 class="mx-card-title">{{ $t("menu.administrators") }}</h3>
                <div class="mx-card-filter">

                </div>
                <AdministratorCreateComponent :props="props" v-if="permissionChecker('administrators_create')" />
            </div>

            <div class="mx-table-responsive">
                <table class="mx-table stripe" id="print">
                    <thead class="mx-table-head">
                        <tr class="mx-table-head-tr">
                            <th class="mx-table-head-th">
                                {{ $t("label.name") }}
                            </th>
                            <th class="mx-table-head-th">
                                {{ $t("label.email") }}
                            </th>
                            <th class="mx-table-head-th">
                                {{ $t("label.phone") }}
                            </th>
                            <th class="mx-table-head-th">
                                {{ $t("label.status") }}
                            </th>
                            <th class="mx-table-head-th hidden-print text-center">
                                {{ $t("label.action") }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mx-table-body" v-if="administrators.length > 0">
                        <tr class="mx-table-body-tr" v-for="administrator in administrators" :key="administrator">
                            <td class="mx-table-body-td">
                                {{ textShortener(administrator.name, 20) }}
                            </td>
                            <td class="mx-table-body-td">
                                {{ administrator.email }}
                            </td>
                            <td class="mx-table-body-td">
                                {{ administrator.country_code + '' + administrator.phone }}
                            </td>
                            <td class="mx-table-body-td">
                                <span :class="statusClass(administrator.status)">
                                    {{
                                        enums.statusEnumArray[administrator.status]
                                    }}
                                </span>
                            </td>
                            <td class="mx-table-body-td text-center">
                                action btn
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-6">
                <!-- TODO: create pagination -->
            </div>
        </div>
    </div>
</template>
<script>
import LoadingComponent from "../components/LoadingComponent.vue";
import AdministratorCreateComponent from "./AdministratorCreateComponent.vue";
import appService from "../../../services/appService";
import statusEnum from "../../../enums/modules/statusEnum";

export default {
    name: "AdministratorListComponent",
    components: {
        LoadingComponent,
        AdministratorCreateComponent,
    },
    data() {
        return {
            loading: {
                isActive: false
            },
            enums: {
                statusEnum: statusEnum,
                statusEnumArray: {
                    [statusEnum.ACTIVE]: this.$t("label.active"),
                    [statusEnum.INACTIVE]: this.$t("label.inactive"),
                },
            },
            props: {
                search: {
                    paginate: 1,
                    page: 1,
                    per_page: 10,
                    order_column: "id",
                    order_type: "desc",
                    name: "",
                    email: "",
                    phone: "",
                    branch_id: null,
                    status: null
                }
            }
        }
    },
    mounted() {
        this.list();

    },
    computed: {
        administrators: function () {
            return this.$store.getters["administrator/lists"];
        },
    },
    methods: {
        list: function (page = 1) {
            this.loading.isActive = true;
            this.props.search.page = page;
            this.$store
                .dispatch("administrator/lists", this.props.search)
                .then((res) => {
                    this.loading.isActive = false;
                })
                .catch((err) => {
                    this.loading.isActive = false;
                });
        },
        textShortener: function (text, number = 30) {
            return appService.textShortener(text, number);
        },
        statusClass: function (status) {
            return appService.statusClass(status);
        },
        permissionChecker(e) {
            return appService.permissionChecker(e);
        },
    }
}
</script>
<style scoped>
@media print {
    .hidden-print {
        display: none !important;
    }
}
</style>
