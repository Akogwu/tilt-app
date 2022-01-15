import axios from "axios";
const api = 'http://127.0.0.1:8000/';

let headers = {
    "Content-Type": "application/json",
    Accept: "*/*",
    'Access-Control-Allow-Origin': '*',
};

export const apiGet = (endpoint) =>{
    return axios.get(`${api}${endpoint}`,{
        headers
    }).then(res => {
        return res.data;
    }).catch((err) => {
        try {
            return err.response.data;
        } catch (error) {
            console.log(error);
        }
    });
}

export const apiDelete = (endpoint) => {
    return axios.delete(`${api}${endpoint}`).then(res => {
        return res.data;
    }).catch((err) => {
        try {
            return err.response.data;
        } catch (error) {
            console.log(error);
        }
    });
}

export const apiPost = (data,endpoint) => {
    return axios.post(`${api}${endpoint}`,data).then(res => {
        return res.data;
    }).catch((err) => {
        try {
            return err.response.data;
        } catch (error) {
            console.log(error);
        }
    });
}

export const apiUpdate = (data,endpoint) => {
    return axios.put(`${api}${endpoint}`,data).then(res => {
        return res.data;
    }).catch((err) => {
        try {
            return err.response.data;
        } catch (error) {
            console.log(error);
        }
    });
}
