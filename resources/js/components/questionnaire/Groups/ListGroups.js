import React, {Fragment} from 'react';
import List from '@material-ui/core/List';
import GroupItem from "./GroupItem";
import PropTypes from 'prop-types';
import GroupAddModal from "./GroupAddModal";

const ListGroups = (props) => {

    return (
        <Fragment>
            <GroupAddModal/>
            <List dense={true} >

                {
                  props.groups.length > 0 &&  props.groups.map( (group,index) => <GroupItem key={index} group={group} index={index}/> )
                }

            </List>
        </Fragment>
    );
}

ListGroups.propTypes={
    groups:PropTypes.array.isRequired,
}

export default ListGroups;
