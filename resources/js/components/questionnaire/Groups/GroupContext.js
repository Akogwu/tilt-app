import React, {createContext, useEffect, useState} from 'react';
import {getGroups} from "./GroupApi";
import {apiGet} from "../../utils/ConnectApi";

export const GroupContext = createContext();

export const GroupProvider = (props) => {
    const [groups,setGroups] = useState([]);
    const [loadingGroups,setLoadingGroups] = useState(true);
    const [overview, setOverview] = useState({
        id:'',
        description:''
    });
    useEffect( () => {
        apiGet('groups').then(groups => {
            setGroups(groups);
            setLoadingGroups(false);
        });
    },[]);

    return (
        <GroupContext.Provider value={[groups,setGroups,loadingGroups]}>
            {props.children}
        </GroupContext.Provider>
    );

}

