<template>
    <LoadingComponent :props="loading" />

    <div class="mx-card">
        <div class="mx-card-header">
            <h3 class="mx-card-title">{{ $t("label.branch_id") }}</h3>
        </div>
        <div class="mx-card-body">
            <div class="row">
                <div class="col-12">
                    <ul class="mx-list single">
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.name")
                            }}</span>
                            <span class="mx-list-item-text">{{
                                branch.name
                            }}</span>
                        </li>
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.latitude")
                            }}</span>
                            <span class="mx-list-item-text">{{
                                branch.latitude
                            }}</span>
                        </li>
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.longitude")
                            }}</span>
                            <span class="mx-list-item-text">{{
                                branch.longitude
                            }}</span>
                        </li>
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.email")
                            }}</span>
                            <span class="mx-list-item-text">{{
                                branch.email
                            }}</span>
                        </li>
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.phone")
                            }}</span>
                            <span class="mx-list-item-text">{{
                                branch.phone
                            }}</span>
                        </li>
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.city")
                            }}</span>
                            <span class="mx-list-item-text">{{
                                branch.city
                            }}</span>
                        </li>
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.state")
                            }}</span>
                            <span class="mx-list-item-text">{{
                                branch.state
                            }}</span>
                        </li>
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.zip_code")
                            }}</span>
                            <span class="mx-list-item-text">{{
                                branch.zip_code
                            }}</span>
                        </li>
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.address")
                            }}</span>
                            <span class="mx-list-item-text">{{
                                branch.address
                            }}</span>
                        </li>
                        <li class="mx-list-item">
                            <span class="mx-list-item-title">{{
                                $t("label.status")
                            }}</span>
                            <span class="mx-list-item-text">
                                <span :class="statusClass(branch.status)" class="mx-badge">{{
                                    enums.statusEnumArray[branch.status]
                                }}</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingComponent from "../../components/LoadingComponent";
import statusEnum from "../../../../enums/modules/statusEnum";
import appService from "../../../../services/appService";

export default {
    name: "BranchShowComponent",
    components: {
        LoadingComponent,
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
        };
    },
    computed: {
        branch: function () {
            return this.$store.getters["branch/show"];
        },
    },
    mounted() {
        this.loading.isActive = true;
        this.$store
            .dispatch("branch/show", this.$route.params.id)
            .then((res) => {
                this.loading.isActive = false;
            })
            .catch((error) => {
                this.loading.isActive = false;
            });
    },
    methods: {
        statusClass: function (status) {
            return appService.statusClass(status);
        },
    },
};
</script>
