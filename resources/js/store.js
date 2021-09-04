import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
    actions: {
        getErrors(ctx,xhr){
            ctx.commit('errorsFill',xhr)
        },
        clearErrors(ctx){
            ctx.commit('clearErrors')
        },
    },
    mutations: {
        errorsFill(state,xhr){
            console.log(xhr.response)
            if(xhr.response.data.errors){
                for(let err in xhr.response.data.errors){
                    state.errors.push(xhr.response.data.errors[err][0])
                }
            }else{
                state.errors.push(xhr.response.data.message)
            }
        },
        clearErrors(state){
            state.errors = []
        },
    },
    state: {
        errors:[],
    },
    getters: {
        errorsGetter(state){
            return state.errors
        },
    }
})
