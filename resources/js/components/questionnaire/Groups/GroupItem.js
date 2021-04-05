import React, {Fragment, useState} from 'react';
import ListItemIcon from "@material-ui/core/ListItemIcon";
import ListItemText from "@material-ui/core/ListItemText";
import GroupActionButtons from "./GroupActionButtons";
import ListItem from "@material-ui/core/ListItem";

import PropTypes from 'prop-types';


const GroupItem = ({group,index}) => {
    const [selectedGroup,setSelectedGroup] = useState();
    const [openDeleteModal,setOpenDeleteModal] = useState(false);

    const handleSelectedGroup = (id) => {
        setSelectedGroup(id);
    }

    const handleOpenDeleteModal = () => {
        setOpenDeleteModal(true);
    }
    const handleCloseDeleteModal = () => {
        setOpenDeleteModal(false);
    }





    return (
        <Fragment>
            <GroupDeleteModal open={open} handleClose={handleCloseDeleteModal}/>

        </Fragment>
    );
}

GroupItem.propTypes = {
    group: PropTypes.object.isRequired,
}

export default GroupItem;
