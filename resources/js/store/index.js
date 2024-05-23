import { createStore } from "vuex";

import createPersistedState from "vuex-persistedstate";
import { auth } from "./modules/auth";
import { frontendSetting } from "./modules/frontend/frontendSetting";
import { administrator } from "./modules/administrator";

export default new createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        frontendSetting,
        administrator,
    },
    plugins: [
        createPersistedState({
            paths: ["auth"],
        }),
    ],
});
