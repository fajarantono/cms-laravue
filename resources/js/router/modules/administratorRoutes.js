import AdministratorComponent from "../../components/admin/administrator/AdministratorComponent.vue";
import AdministratorListComponent from "../../components/admin/administrator/AdministratorListComponent.vue";

export default [
    {
        path: "/admin/administrators",
        component: AdministratorComponent,
        name: "admin.administrators",
        redirect: { name: "admin.administrators" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "administrators",
            breadcrumb: "administrators",
        },
        children: [
            {
                path: "",
                component: AdministratorListComponent,
                name: "admin.administrators",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "administrators",
                    breadcrumb: "",
                },
            },
        ],
    },
];
