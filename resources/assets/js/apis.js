
window.apiService = {
  API_URL: '/api',
  url: (url) => window.apiService.API_URL + '/' + url
};

Vue.http.headers.common.Authorization = 'Bearer ' + window.Laravel.token;