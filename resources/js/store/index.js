import Vue from 'vue'
import Vuex from 'vuex'



import tableadmin from './tableadmin'
import auth from './auth'



Vue.use(Vuex)
//const debug = process.env.NODE_ENV !== 'production'


const store = new Vuex.Store({
    modules: {
      auth,
      tableadmin
    },
    //strict: debug
})

  export default store