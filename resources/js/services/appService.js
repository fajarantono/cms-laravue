import VueSimpleAlert from "vue3-simple-alert";

export default {
    textShortener: function (text, number = 30) {
        if (text) {
            if (!(text.length < number)) {
                return text.substring(0, number) + "..";
            }
        }
        return text;
    },

    responsiveLoad: function () {
        let mainHeader = document?.querySelector(".db-header");
        let subHeader = document?.querySelector(".sub-header");
        let mainHeight = mainHeader?.scrollHeight;

        if (subHeader) {
            subHeader.style.top = `${mainHeight}px`;
        }
    },
};
