import axios from "axios";

export const auth = {
    state: {
        authStatus: false,
        authToken: null,
        authBranchId: "",
        authInfo: {},
        authMenu: [],
        resetInfo: {
            email: null,
        },
        authPermission: {},
        authDefaultPermission: {},
    },
    getters: {
        authStatus: function (state) {
            return state.authStatus;
        },
        authToken: function (state) {
            return state.authToken;
        },
        authBranchId: function (state) {
            return state.authBranchId;
        },
        authInfo: function (state) {
            return state.authInfo;
        },
        authMenu: function (state) {
            return state.authMenu;
        },
    },
    actions: {
        login: function (context, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .post("auth/login", payload)
                    .then((res) => {
                        context.commit("authLogin", res.data);
                        resolve(res);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
    mutations: {
        authLogin: function (state, payload) {
            state.authStatus = true;
            state.authToken = payload.token;
            state.authBranchId = payload.branch_id;
            state.authInfo = payload.user;
            state.authMenu = payload.menu;
            state.authPermission = payload.permission;
            state.authDefaultPermission = payload.defaultPermission;
        },
        authInfo: function (state, payload) {
            state.authInfo = payload;
        },
    },
};
