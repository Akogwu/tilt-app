
import axios from "axios";
const api = 'https://tiltapp-api.herokuapp.com';


export const getGroups = () =>{
    return axios.get(`${api}/groups`).then(res => {
        return res.data;
    }).catch((err) => {
        try {
            return err.response.data;
        } catch (error) {
            console.log(error);
        }
    });
}

export const deleteGroup = (groupId) => {
    return axios.delete(`${api}/groups/${groupId}`).then(res => {
        return res.data;
    }).catch((err) => {
        try {
            return err.response.data;
        } catch (error) {
            console.log(error);
        }
    });
}

export const postGroup = (data) => {
    return axios.post(`${api}/groups`,data).then(res => {
        return res.data;
    }).catch((err) => {
        try {
            return err.response.data;
        } catch (error) {
            console.log(error);
        }
    });
}

export const updateGroup = (data,group_id) => {
    return axios.put(`${api}/groups/${group_id}`,data).then(res => {
        return res.data;
    }).catch((err) => {
        try {
            return err.response.data;
        } catch (error) {
            console.log(error);
        }
    });
}
