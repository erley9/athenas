import { PUSH_CATEGORIES_MUTATION, LIST_CATEGORIES_ACTION} from '@/store/mutation-types'
import CategoryDataService from '@/services/CategoryDataService'

export const moduleCategories = {
    mutations:{
        [PUSH_CATEGORIES_MUTATION] (state, $data) {
            state.categories = $data
        }
    },
    actions:{
        [LIST_CATEGORIES_ACTION] (context) {
            CategoryDataService.getPaginate().then((response) => context.commit(PUSH_CATEGORIES_MUTATION,  response.data.data.data))
        }
    },
    getters: {
        categories (state) {
          return state.categories
        }
    }
}