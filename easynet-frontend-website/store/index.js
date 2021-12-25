export const state = () => ({
  notif: []
})
// getter
export const getters = {
  getNotif (state) {
    return state.notif
  }
}
export const mutations = {
  setNotif (state, data) {
    state.notif.push(data)
  }
}