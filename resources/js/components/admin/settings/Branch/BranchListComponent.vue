<template>
    <LoadingComponent :props="loading" />
    <div class="mx-card mx-tab-div active">
        <div class="mx-card-header border-none">
            <h3 class="mx-card-title">{{ $t("menu.branches") }}</h3>
            <div class="mx-card-filter">
                <BranchCreateComponent :props="props" />
            </div>
        </div>

        <div class="mx-card-body">
            <div class="mx-table-responsive">
                <table class="mx-table stripe">
                    <thead class="mx-table-head">
                        <tr class="mx-table-head-tr">
                            <th class="mx-table-head-th">{{ $t("label.name") }}</th>
                            <th class="mx-table-head-th text-center">
                                {{ $t("label.status") }}
                            </th>
                            <th class="mx-table-head-th text-center">
                                {{ $t("label.action") }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mx-table-body" v-if="branches.length > 0">
                        <tr class="mx-table-body-tr" v-for="branch in branches" :key="branch">
                            <td class="mx-table-body-td" v-if="site_default_branch === branch.id">
                                {{ branch.name }}({{ $t('label.default') }})
                            </td>
                            <td class="mx-table-body-td" v-else>
                                {{ branch.name }}
                            </td>
                            <td class="mx-table-body-td text-center">
                                <span :class="statusClass(branch.status)">
                                    {{ enums.statusEnumArray[branch.status] }}
                                </span>
                            </td>
                            <td class="mx-table-body-td text-center">
                                <div class="flex justify-start items-center sm:items-start sm:justify-start gap-1.5">
                                    <SmViewComponent :link="'admin.settings.branch.show'" :id="branch.id" />
                                    <SmModalEditComponent @click="edit(branch)" />
                                    <SmDeleteComponent @click="destroy(branch.id)" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-6">
                <PaginationSMBox :pagination="pagination" :method="list" />
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <PaginationTextComponent :props="{ page: paginationPage }" />
                    <PaginationBox :pagination="pagination" :method="list" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingComponent from "../../components/LoadingComponent.vue";
import BranchCreateComponent from "./BranchCreateComponent.vue";
import PaginationSMBox from "../../components/pagination/PaginationSMBox.vue";
import PaginationTextComponent from "../../components/pagination/PaginationTextComponent.vue";
import PaginationBox from "../../components/pagination/PaginationBox.vue";
import SmViewComponent from "../../components/buttons/SmViewComponent.vue";
import SmModalEditComponent from "../../components/buttons/SmModalEditComponent.vue";
import SmDeleteComponent from "../../components/buttons/SmDeleteComponent.vue";
import appService from "../../../../services/appService";
import statusEnum from "../../../../enums/modules/statusEnum";
import alertService from "../../../../services/alertService";
export default {
    name: "BranchListComponent",
    components: {
        LoadingComponent,
        BranchCreateComponent,
        PaginationSMBox,
        PaginationTextComponent,
        PaginationBox,
        SmViewComponent,
        SmModalEditComponent,
        SmDeleteComponent
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            enums: {
                statusEnum: statusEnum,
                statusEnumArray: {
                    [statusEnum.ACTIVE]: this.$t("label.active"),
                    [statusEnum.INACTIVE]: this.$t("label.inactive"),
                },
            },
            props: {
                form: {
                    name: "",
                    email: "",
                    phone: "",
                    latitude: "",
                    longitude: "",
                    city: "",
                    state: "",
                    zip_code: "",
                    address: "",
                    status: statusEnum.ACTIVE,
                },
                search: {
                    paginate: 1,
                    page: 1,
                    per_page: 10,
                    order_column: "id",
                    order_type: "desc",
                },
            },
            site_default_branch: null,
        }
    },
    mounted() {
        this.list();
    },
    computed: {
        branches: function () {
            return this.$store.getters["branch/lists"];
        },
        pagination: function () {
            return this.$store.getters["branch/pagination"];
        },
        paginationPage: function () {
            return this.$store.getters["branch/page"];
        },
    },
    methods: {
        list: function (page = 1) {
            this.loading.isActive = true;
            this.props.search.page = page;
            this.$store.dispatch("branch/lists", this.props.search).then((res) => {
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        edit: function (branch) {
            appService.modalShow();
            this.loading.isActive = true;
            this.$store.dispatch("branch/edit", branch.id);
            this.props.form = {
                name: branch.name,
                email: branch.email,
                phone: branch.phone,
                latitude: branch.latitude,
                longitude: branch.longitude,
                city: branch.city,
                state: branch.state,
                zip_code: branch.zip_code,
                address: branch.address,
                status: branch.status,
            };
            this.loading.isActive = false;
        },
        destroy: function (id) {
            appService
                .destroyConfirmation()
                .then((res) => {
                    try {
                        this.loading.isActive = true;
                        this.$store
                            .dispatch("branch/destroy", {
                                id: id,
                                search: this.props.search,
                            })
                            .then((res) => {
                                this.loading.isActive = false;
                                alertService.successFlip(null, this.$t("menu.branches"));
                            })
                            .catch((err) => {
                                this.loading.isActive = false;
                                alertService.error(err.response.data.message);
                            });
                    } catch (err) {
                        this.loading.isActive = false;
                        alertService.error(err.response.data.message);
                    }
                })
                .catch((err) => {
                    this.loading.isActive = false;
                });
        },
        statusClass: function (status) {
            return appService.statusClass(status);
        },
    }
}
</script>
