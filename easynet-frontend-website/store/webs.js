import axios from 'axios'
export const state = () => ({
  herodata:{}
})

export const mutations = {
  HERO_DATA(state,data){
    state.herodata = data
  }
}

export const actions = {
  storeHero({commit}, data) {
    commit('HERO_DATA', data)
  }
}

export const getters = {
  getHero(state){
    return state.herodata
  }
}