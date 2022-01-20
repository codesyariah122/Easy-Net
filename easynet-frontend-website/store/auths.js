import axios from "axios";
export const strict = false;
export const state = () => ({
  checks: {},
  user: {},
});

export const mutations = {
  CHECK_AUTH(state, name) {
    state.checks = localStorage.getItem(name) ? JSON.parse(localStorage.getItem(name)) : '';
  },
  USER_DATA(state, user) {
    state.user = user
  },
};

export const actions = {
  storeUser({commit}, url){
    let data = localStorage.getItem('checked') ? JSON.parse(localStorage.getItem('checked')) :  '';
    // console.log(data)
    if(data){
      axios.defaults.headers.common.Authorization = `Bearer ${data.token}`;
      axios
      .get(`${url}/user`)
      .then((res) => {
        // console.log(res.data.data[0])
        commit('USER_DATA', res.data.data[0])
      })
      .catch((err) => {
        console.error(err.message);
      });
    }else{
      return false
    }
    
  }
};

export const getters = {
  getAuth(state) {
    return state.checks;
  },
  getUser(state) {
    return state.user;
  },
};
