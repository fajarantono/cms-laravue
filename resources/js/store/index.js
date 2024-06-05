import { createStore } from "vuex";

import createPersistedState from "vuex-persistedstate";
import { auth } from "./modules/auth";
import { frontendSetting } from "./modules/frontend/frontendSetting";
import { backendGlobalState } from "./modules/backendGlobalState";

import { company } from "./modules/company";
import { branch } from "./modules/branch";
import { administrator } from "./modules/administrator";

export default new createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        frontendSetting,
        backendGlobalState,
        branch,
        company,
        administrator,
    },
    plugins: [
        createPersistedState({
            paths: ["auth"],
        }),
    ],
});
