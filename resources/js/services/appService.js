import VueSimpleAlert from "vue3-simple-alert";
import store from "../store";
import statusEnum from "../enums/modules/statusEnum";

export default {
    textShortener: function (text, number = 30) {
        if (text) {
            if (!(text.length < number)) {
                return text.substring(0, number) + "..";
            }
        }
        return text;
    },

    statusClass: function (status) {
        if (status === statusEnum.ACTIVE) {
            return "mx-table-badge text-green-600 bg-green-100";
        } else {
            return "mx-table-badge text-red-600 bg-red-100";
        }
    },

    responsiveLoad: function () {
        let mainHeader = document?.querySelector(".db-header");
        let subHeader = document?.querySelector(".sub-header");
        let mainHeight = mainHeader?.scrollHeight;

        if (subHeader) {
            subHeader.style.top = `${mainHeight}px`;
        }
    },

    requestHandler: function (requests) {
        let i = 1;
        let what = "?";
        let response = "";

        for (let request in requests) {
            if (requests[request] !== "" && requests[request] !== null) {
                if (i !== 1) {
                    response += "&";
                }
                response += request + "=" + requests[request];
            }
            i++;
        }

        if (response) {
            response = what + response;
        }

        return response;
    },

    sideDrawerShow: function (id = "sideDrawer") {
        const drawerDivs = document?.querySelectorAll(".drawer");
        const drawerSets = document?.querySelectorAll("[data-drawer]");
        drawerSets?.forEach((drawerSet) => {
            const targetElm = document?.querySelector(
                drawerSet?.dataset?.drawer
            );
            drawerSets?.forEach((drawerBtn) =>
                drawerBtn?.classList?.remove("active")
            );
            drawerDivs?.forEach((drawerDiv) =>
                drawerDiv?.classList?.remove("active")
            );
            targetElm?.classList?.add("active");
            drawerSet?.classList?.add("active");
            document.body.style.overflowY = "hidden";
            document?.querySelector(".backdrop")?.classList?.add("active");
        });
    },

    sideDrawerHide: function (id = "sideDrawer") {
        const drawerDivs = document?.querySelectorAll(".drawer");
        const drawerSets = document?.querySelectorAll("[data-drawer]");
        document?.querySelectorAll("#sidebar")?.forEach((closeBtn) => {
            drawerSets?.forEach((drawerBtn) =>
                drawerBtn?.classList?.remove("active")
            );
            drawerDivs?.forEach((drawerDiv) =>
                drawerDiv?.classList?.remove("active")
            );
            document?.querySelector(".backdrop")?.classList?.remove("active");
            document.body.style.overflowY = "auto";
        });
    },

    modalShow: function (id = ".modal") {
        let modalButton = document?.querySelectorAll("[data-modal]");
        modalButton?.forEach((modalBtn) => {
            const modalTarget = document?.querySelector(id);
            modalTarget?.classList?.add("active");
            document.body.style.overflowY = "hidden";
        });
    },

    modalHide: function (id = ".modal") {
        let modalDivs = document?.querySelectorAll(id);
        document.body.style.overflowY = "auto";
        modalDivs?.forEach((modalDiv) => modalDiv?.classList?.remove("active"));
    },

    destroyConfirmation: function () {
        return new VueSimpleAlert.confirm(
            "You will not be able to recover the deleted record!",
            "Are you sure?",
            "warning",
            {
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No, Cancel!",
                confirmButtonColor: "#696cff",
                cancelButtonColor: "#8592a3",
            }
        );
    },

    permissionChecker: function (permissionName) {
        let i,
            permissions = store.getters.authPermission;
        for (i = 0; i < permissions.length; i++) {
            if (
                typeof permissions[i].name !== "undefined" &&
                permissions[i].name
            ) {
                if (permissions[i].name === permissionName) {
                    return permissions[i].access;
                }
            }
        }
    },

    phoneNumber: function (e) {
        let char = String.fromCharCode(e.keyCode);
        if (/^[+]?[0-9]*$/.test(char)) return true;
        else e.preventDefault();
    },
};
