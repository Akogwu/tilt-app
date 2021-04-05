import React, {Fragment, useState} from 'react';
import List from '@material-ui/core/List';
import GroupItem from "./GroupItem";
import PropTypes from 'prop-types';
import ListItemIcon from "@material-ui/core/ListItemIcon";
import ListItemText from "@material-ui/core/ListItemText";
import GroupActionButtons from "./GroupActionButtons";
import ListItem from "@material-ui/core/ListItem";
import GroupDeleteModal from "./GroupDeleteModal";
import GroupEditModal from "./GroupEditModal";


const ListGroups = (props) => {
    const [selectedGroup,setSelectedGroup] = useState();
    const [openDeleteModal,setOpenDeleteModal] = useState(false);
    const [openEditModal,setOpenEditModal] = useState(false);
    const [id,setId] = useState();
    const [group,setGroup] = useState();


    const handleOpenDeleteModal = (id) => {
        setId(id);
        setOpenDeleteModal(true);
    }

    const handleCloseDeleteModal = () => {
        setOpenDeleteModal(false);
    }

    const handleOpenEditModal = (group) => {
        setId(group.id);
        setGroup(group);
        setOpenEditModal(true);

    }

    const handleCloseEditModal = () =>{
        setOpenEditModal(false);
    }

    const handleSelectedGroup = (id) => {
        setSelectedGroup(id);
    }
    return (
        <Fragment>
            <GroupDeleteModal group_id={id} open={openDeleteModal} handleClose={handleCloseDeleteModal}/>
            <GroupEditModal group_id={id} fillData={group} open={openEditModal} handleClose={handleCloseEditModal} />
            <List dense={true} >
                {props.groups.length > 0 &&  props.groups.map( (group,index) =>
                    <ListItem key={index} button className={'shadow-md my-1'} selected={selectedGroup === index} onClick={ () => handleSelectedGroup(index)}>
                        <ListItemIcon>
                            <i className={`fa fa-${group.icon} text-${group.color}`}> </i>
                        </ListItemIcon>
                        <ListItemText primary={group.name}/>
                        <GroupActionButtons  handleOpenEdit={ () => handleOpenEditModal(group)}  handleOpen={ () => handleOpenDeleteModal(group.id)}/>
                    </ListItem>)}
            </List>
        </Fragment>
    );
}

ListGroups.propTypes={
    groups:PropTypes.array.isRequired,
}

export default ListGroups;
