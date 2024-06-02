import SettingsComponent from "../../components/admin/settings/SettingComponent.vue";
import CompanyComponent from "../../components/admin/settings/Company/CompanyComponent.vue";
import BranchComponent from "../../components/admin/settings/Branch/BranchComponent.vue";
import BranchListComponent from "../../components/admin/settings/Branch/BranchListComponent.vue";
import BranchShowComponent from "../../components/admin/settings/Branch/BranchShowComponent.vue";
export default [
    {
        path: "/admin/settings",
        component: SettingsComponent,
        name: "admin.settings",
        redirect: { name: "admin.settings.company" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "settings",
            breadcrumb: "settings",
        },
        children: [
            {
                path: "company",
                component: CompanyComponent,
                name: "admin.settings.company",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "company",
                },
            },
            {
                path: "branches",
                component: BranchComponent,
                name: "admin.settings.branch",
                redirect: { name: "admin.settings.branch.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "branches",
                },
                children: [
                    {
                        path: "list",
                        component: BranchListComponent,
                        name: "admin.settings.branch.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                    {
                        path: "show/:id",
                        component: BranchShowComponent,
                        name: "admin.settings.branch.show",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "view",
                        },
                    },
                ],
            },
        ],
    },
];
