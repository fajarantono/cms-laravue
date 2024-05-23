import axios from "axios";
import appService from "../../services/appService";

export const administrator = {
    namespaced: true,
    state: {
        lists: [],
        page: {},
        pagination: [],
        show: {},
    },
    getters: {
        lists: function (state) {
            return state.lists;
        },
    },
    actions: {
        lists: function (context, payload) {
            return new Promise((resolve, reject) => {
                let url = "admin/administrator";
                if (payload) {
                    url = url + appService.requestHandler(payload);
                }
                axios
                    .get(url)
                    .then((res) => {
                        if (
                            typeof payload.vuex === "undefined" ||
                            payload.vuex === true
                        ) {
                            context.commit("lists", res.data.data);
                            // context.commit("page", res.data.meta);
                            // context.commit("pagination", res.data);
                        }

                        resolve(res);
                    })
                    .catch((err) => {
                        reject(err);
                    });
            });
        },
    },
    mutations: {
        lists: function (state, payload) {
            state.lists = payload;
        },
    },
};
