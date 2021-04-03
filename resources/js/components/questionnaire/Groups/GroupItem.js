import React, {Fragment, useState} from 'react';
import ListItemIcon from "@material-ui/core/ListItemIcon";
import ListItemText from "@material-ui/core/ListItemText";
import GroupActionButtons from "./GroupActionButtons";
import ListItem from "@material-ui/core/ListItem";

import PropTypes from 'prop-types';

const GroupItem = ({group,index}) => {

    const [selectedGroup,setSelectedGroup] = useState();

    const handleSelectedGroup = (id) => {
        setSelectedGroup(id);
    }




    return (
        <Fragment>
            <ListItem button className={'shadow-md my-1'} selected={selectedGroup === index} onClick={ () => handleSelectedGroup(index)}>
                <ListItemIcon>
                    <i className={`fa fa-${group.icon} text-${group.color}`}> </i>
                </ListItemIcon>
                <ListItemText primary={group.name}/>
                <GroupActionButtons/>
            </ListItem>
        </Fragment>
    );
}

GroupItem.propTypes = {
    group: PropTypes.object.isRequired,
}

export default GroupItem;
