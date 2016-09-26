import axios from 'axios';

const API_URL = '/';

export function sendUrl(url) {
  return axios({
    method: 'post',
    url: API_URL,
    data: {
      url: url
    }
  }).then((response) => {
    return response.data;
  }).catch((error) => {
    return error.response;
  });
}
