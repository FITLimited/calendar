export default function (Vue) {
    Vue.auth = {
        setToken(token)  {
            localStorage.setItem('token', token)
        },
        destroyToken() {
            localStorage.removeItem('token');
        },
        getToken()  {
            var token = localStorage.getItem('token');

            if (!token)
                return null

            return token;
        },
        isAuthenticated()  {
            if (this.getToken()){
                return true
            }
            else {
                return false
            }
        }
    }

    Object.defineProperties(Vue.prototype, {
        $auth: {
            get: () => {
                return Vue.auth
            }
        }
    })
}