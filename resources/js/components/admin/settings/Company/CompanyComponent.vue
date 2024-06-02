<template>
    <LoadingComponent :props="loading" />
    <div id="company" class="mx-card mx-tab-div active">
        <div class="mx-card-header">
            <h3 class="mx-card-title">{{ $t("menu.company") }}</h3>
        </div>
        <div class="mx-card-body">

        </div>
        </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue'
export default {
    name: "CompanyComponent",
    components: { LoadingComponent },
    data() {
        return {
            loading: {
                isActive: false,
            },
            form: {
                company_name: "",
                company_email: "",
                company_phone: "",
                company_website: "",
                company_city: "",
                company_state: "",
                company_country_code: null,
                company_zip_code: "",
                company_address: "",
            },
            errors: {},
        }
    }
}
</script>
