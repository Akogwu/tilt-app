import React, {Fragment, useState,useContext} from 'react';
import List from '@material-ui/core/List';
import PropTypes from 'prop-types';
import ListItemIcon from "@material-ui/core/ListItemIcon";
import ListItemText from "@material-ui/core/ListItemText";
import ListItemSecondaryAction from '@material-ui/core/ListItemSecondaryAction';
import GroupActionButtons from "./GroupActionButtons";
import ListItem from "@material-ui/core/ListItem";
import GroupDeleteModal from "./GroupDeleteModal";
import GroupEditModal from "./GroupEditModal";
import Loader from 'react-loader-spinner';
import {SectionContext} from "../Sections/SectionContext";

const ListGroups = (props) => {
    const [selectedGroup,setSelectedGroup] = useState();
    const [openDeleteModal,setOpenDeleteModal] = useState(false);
    const [openEditModal,setOpenEditModal] = useState(false);
    const [,,loadingSections,,setSecGroupId] = useContext(SectionContext);
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

    const handleSelectedGroup = (index,groupId) => {
        setSelectedGroup(index);
        setSecGroupId(groupId);
    }
    return (
        <Fragment>
            <GroupDeleteModal group_id={id} open={openDeleteModal} handleClose={handleCloseDeleteModal}/>
            <GroupEditModal group_id={id} fillData={group} open={openEditModal} handleClose={handleCloseEditModal} />
            <List  >

                {props.groups.length > 0 &&  props.groups.map( (group,index) =>
                    <ListItem key={index} button className="my-3 py-9" selected={selectedGroup === index} onClick={ () => handleSelectedGroup(index,group.id)}>
                        <ListItemIcon>
                            <i className={`fa fa-${group.icon} text-${group.color}`}> </i>
                        </ListItemIcon>
                        <ListItemText primary={group.name}/>
                        <ListItemSecondaryAction>
                        {
                            ( loadingSections && selectedGroup === index)? <Loader edge="end" type="Oval" color="gray" height={27} width={27}/>:
                            <GroupActionButtons  handleOpenEdit={ () => handleOpenEditModal(group)}  handleOpen={ () => handleOpenDeleteModal(group.id)}/>
                        }
                        </ListItemSecondaryAction>


                    </ListItem>)}
            </List>

        </Fragment>
    );
}

ListGroups.propTypes={
    groups:PropTypes.array.isRequired,
}

export default ListGroups;
