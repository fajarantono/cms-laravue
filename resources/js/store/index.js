import { createStore } from "vuex";

import createPersistedState from "vuex-persistedstate";
import { auth } from "./modules/auth";
import { frontendSetting } from "./modules/frontend/frontendSetting";

export default new createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        frontendSetting,
    },
    plugins: [
        createPersistedState({
            paths: ["auth"],
        }),
    ],
});
