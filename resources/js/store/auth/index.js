import Cookies from "js-cookie";

const auth = {
    namespaced: true,
    state: () => ({
        loginStatus: false, //propiedad, que se encarga de actualizar si esta autentificado o no,
        //role: '',
        //permissions: []
    }),
    mutations: {
        setUserLogged(state, user){
            Cookies.set("usuario", user.access_token, { expires: new Date (user.expires_at) });
            window.location.href = process.env.MIX_APP_URL
            //state.loginStatus = true;
            //state.role = ( user.role == 'cliente' ) ? state.role : user.rol;
        },
        updatedUserStatus(state, status){
            state.loginStatus = status;
        },
        userLogout(state){
            state.loginStatus = false;
            Cookies.remove('usuario')
            window.location.href = process.env.MIX_APP_URL
        },
        /*set_role_permissions(state, role_permissions){
            state.role = role_permissions.role;
            for (let i = 0; i < role_permissions.permissions.length; i++) {
                state.permissions.push(role_permissions.permissions[i]);
            }
        }*/
    },
    getters: {
        getUserLogged: () => {
            return (Cookies.get("usuario") != undefined) ? true : false;
        },
        getUserStatus: (state) => {
            return  state.loginStatus;
        },
        /*getUserRol: (state) => {
            return state.role;
        },
        getUserPermissions: (state) => {
            return state.permissions;
        },*/
        getToken: () => {
            return Cookies.get("usuario")
        }
    },
    actions: {
        login({commit}, user){
            commit('setUserLogged', user)
        },
        logout({commit}){
            commit('userLogout')
        },
        update_status({commit}, statusAuth){
            commit('updatedUserStatus', statusAuth)
        },
        /*role_permissions({commit}, role_permissions){
            commit('set_role_permissions', role_permissions)
        }*/
    },
};

export default auth;