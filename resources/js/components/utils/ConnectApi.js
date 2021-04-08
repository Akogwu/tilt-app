
import axios from "axios";
const api = 'https://tiltapp-api.herokuapp.com/';


export const apiGet = (endpoint) =>{
    return axios.get(`${api}${endpoint}`).then(res => {
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