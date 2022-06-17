import axios from 'axios';

const tableadmin = {
    namespaced: true,
    state () {
        return { 
            request: {  
                url: '',
                params:  {}
            },
            tbodyComponent: '', //inicio component skeletonTableBody
            paginationComponent: '', //inicio component skeletonPagination
            cardBodyComponent: '', // inicio de component loaderWhite
            dataTble: [],
            pagination: {}
        }
    },
    mutations: {
        mutRequest(state, request){
            state.request = request
        },
        mutDataTblePagination(state, response){
            state.dataTble = response.results;
            state.pagination = response.pagination;
        },
        mutAlertMsg(state, boleano){
            state.cardBodyComponent = ( boleano ) ? 'alertMessage' : ''
        },
        mutDelete(state, boleano){
            state.cardBodyComponent = ( boleano ) ? 'deleteConfirmModal' : ''
        },
        componentRender(state, objeto){
            if ( objeto != null ){
                state.tbodyComponent = objeto.tbody
                state.paginationComponent = objeto.pagination
                state.cardBodyComponent = objeto.cardBody
            }else{
                state.tbodyComponent = 'skeletonTableBody'
                state.paginationComponent = 'skeletonPagination'
                state.cardBodyComponent ='loaderWhite'
            }
        }
    },
    getters: {
        getRequest(state){
            return state.request
        },
        getComponents(state){
            return { tbody: state.tbodyComponent, pagination: state.paginationComponent, cardBody: state.cardBodyComponent }
        },
        getDataTable(state){
            return state.dataTble
        },
        getPagination(state){
            return state.pagination
        } 
    },
    actions: {
        initTable({commit, dispatch},objeto = {}){
            commit('mutRequest', objeto)
            commit('componentRender', null)
            dispatch('getData',{root:true}) 
        },
        alertMessage({commit}, boleano = true){
            commit('mutAlertMsg', boleano)
        },
        modalDelete({commit}, boleano = true){
            commit('mutDelete', boleano)
        },
        resetTable({commit}){
            commit('mutRequest', {  
                url: '',
                params:  {}
            })
            commit('componentRender', null)
        },
        resetInit({commit,  dispatch}){
            commit('componentRender', null)
            dispatch('getData',{root:true}) 
        },
        async getData({commit, getters }){
            const request = getters.getRequest;
            console.log('hola aqui')
                console.log(request)

            await axios.get(request.url, {params : request.params}).then(response => {
                console.log(response.data)
            
                setTimeout(() => {
                    commit('mutDataTblePagination', response.data)
                    commit('componentRender', {
                        tbody: 'tablebody',
                        pagination: 'pagination',
                        cardBody: ( response.data.results.length == 0 ) ? 'alertMessage' : ''
                    });
                }, 2000);
            }).catch(error => {
                console.log(error.response)
            });
        }
    }
}


export default tableadmin