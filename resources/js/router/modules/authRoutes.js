import LoginComponent from "../../components/frontend/auth/LoginComponent";

export default [
    {
        path: "/login",
        component: LoginComponent,
        name: "auth.login",
        meta: {
            isFrontend: true,
            auth: false,
        },
    },
];
