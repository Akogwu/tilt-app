import React, {createContext, useEffect, useState} from 'react';
import {getGroups} from "./GroupApi";

export const GroupContext = createContext();

export const GroupProvider = (props) => {
    const [groups,setGroups] = useState([]);

    useEffect( () => {
        getGroups().then(res => {
            setGroups(res);
        })
    },[]);

    return (
        <GroupContext.Provider value={[groups,setGroups]}>
            {props.children}
        </GroupContext.Provider>
    );

}

