import axios from "axios";

const axiosProvider = axios.create({
    baseURL: import.meta.env.VITE_API_PATH_REQUEST,
    headers: {
        'Accept': 'application/json',
        'Content': 'application/json'
    },
    withCredentials: false
})

axiosProvider.interceptors.request.use((config) => {
    const jwtToken = localStorage.getItem('meuTreinoLoginToken');

    if (jwtToken) {
        config.headers['Authorization'] = `Bearer ${jwtToken}`;
    }
    return config;
});

function getCookie(name) {
    const cookies = document.cookie.split('; ');
    for (const cookie of cookies) {
        const [cookieName, cookieValue] = cookie.split('=');
        if (cookieName === name) {
            return decodeURIComponent(cookieValue);
        }
    }
    return null;
}

export default axiosProvider;