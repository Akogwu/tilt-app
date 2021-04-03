import React, {Fragment, useEffect, useState,useContext} from 'react';
import ListGroups from "./ListGroups";
import {GroupContext} from "./GroupContext";

const Groups = () => {

    const [groups,setGroups] = useContext(GroupContext);



    return (
        <Fragment>
            <div className="py-3 w-1/4">
                <ListGroups groups={groups}/>
            </div>
        </Fragment>
    );

}

export default Groups;
