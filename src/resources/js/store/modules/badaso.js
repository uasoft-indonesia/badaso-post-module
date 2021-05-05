import api from "../../api";
import createPersistedState from "vuex-persistedstate";
import helpers from "../../utils/helper";

export default {
  namespaced: true,
  state: {},
  mutations: {
    SET_AUTH_ISSUE(state, value) {
      state.authorizationIssue = value;
    },
    SET_KEY_ISSUE(state, value) {
      state.keyIssue = value;
    },
  },
  actions: {},
  getters: {},
  plugins: [createPersistedState()],
};
