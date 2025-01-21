import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
const store=new Vuex.Store({
    state:{
        token:'',
        theme:'',
        currency_id:''
    },
    mutations:{
        loginMutation(state,token){
            state.token=token;
        },
        changeTheme(state,theme){
            state.theme=theme;
        },
        setCurrencyId(state,id){
            state.currency_id = id
        }
    },
    actions:{
        loginFunAction(context,params){
            context.commit('loginMutation',status)
        }
    }
})
export default store