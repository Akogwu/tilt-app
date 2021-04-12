import React, {useContext} from 'react';
import PropTypes from 'prop-types';
import {deleteGroup} from "./GroupApi";
import {GroupContext} from "./GroupContext";
import {apiDelete} from "../../utils/ConnectApi";


const UseActionDelete = () => {
    const [groups,setGroups] = useContext(GroupContext);

    const handleDeleteModal = (group_id) => {
        apiDelete(`groups/${group_id}`).then( () => {
            setGroups(groups.filter((group) => group.id !== group_id));
        });
    }
    return {handleDeleteModal}
}

UseActionDelete.propTypes = {};

export default UseActionDelete;
