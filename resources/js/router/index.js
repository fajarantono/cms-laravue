import { createRouter, createWebHashHistory } from "vue-router";
import ENV from "../config/env";
import store from "../store";
import NotFoundComponent from "../components/frontend/otherPage/NotFoundComponent.vue";
import authRoutes from "./modules/authRoutes";

const baseRoutes = [
    {
        path: "/",
        redirect: { name: "auth.login" },
        name: "root",
    },
    {
        path: "/:pathMatch(.*)*",
        name: "route.notFound",
        component: NotFoundComponent,
        meta: {
            isFrontend: true,
        },
    },
];

const routes = baseRoutes.concat(authRoutes);

const API_URL = ENV.API_URL;
const router = createRouter({
    linkActiveClass: "active",
    mode: "history",
    history: createWebHashHistory(API_URL),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.auth === true) {
        if (!store.getters.authStatus) {
            next({ name: "auth.login" });
        } else {
            if (to.meta.isFrontend === false) {
                if (to.meta.access === false) {
                    next({
                        name: "route.exception",
                    });
                } else {
                    next();
                }
            } else {
                next();
            }
        }
    } else if (to.name === "auth.login" && store.getters.authStatus) {
        next({ name: "admin.dashboard" });
    } else {
        next();
    }
});

export default router;
