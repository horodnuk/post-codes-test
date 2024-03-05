import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';

const api = axios.create({
  timeout: 10000
});

api.interceptors.request.use(
  config => {
    return config;
  },
  async error => {
    await Promise.reject(error);
  }
);

api.interceptors.response.use(
  response => {
    return response;
  },

  async function (error) {
    if (error?.response?.status === 401) {
      return Promise.reject(error);
    }

    if (error?.response?.status === 400 || error?.response?.status > 401) {
      return Promise.reject(error);
    }
  }
);

export default api;
