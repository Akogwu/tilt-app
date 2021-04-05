import React, {useContext} from 'react';
import PropTypes from 'prop-types';
import {deleteGroup} from "./GroupApi";
import {GroupContext} from "./GroupContext";


const UseActionDelete = () => {
    const [groups,setGroups] = useContext(GroupContext);

    const handleDeleteModal = (group_id) => {
        deleteGroup(group_id).then( () =>{
            setGroups(groups.filter((group) => group.id !== group_id));
        });
    }


    return {handleDeleteModal}
}

UseActionDelete.propTypes = {};

export default UseActionDelete;
