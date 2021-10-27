
import axios from "axios";
const api = 'https://tiltapp-api.herokuapp.com';


export const getGroupResources = () =>{
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

export const deleteGroupResource = (groupId) => {
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

export const postGroupResource = (data) => {
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

export const updateGroupResource = (data,group_id) => {
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
