import { createStore, Store, useStore as vuexUseStore } from 'vuex'
import { moduleCategories } from './modules/categories'
import { moduleClients } from './modules/clients'

export const key = Symbol()

export const store = createStore({
    state :{
        "clients":[],
        "pagination":[],
        "categories":[] 
    },
    modules: {
        'a': moduleClients,
        'b': moduleCategories
    }
})

export function useStore() {
    return vuexUseStore(key)
}

