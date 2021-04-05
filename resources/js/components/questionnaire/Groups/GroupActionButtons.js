import React, {Fragment} from 'react';
import IconButton from '@material-ui/core/IconButton';
import Menu from '@material-ui/core/Menu';
import MenuItem from '@material-ui/core/MenuItem';
import MoreVertIcon from '@material-ui/icons/MoreVert';



const ITEM_HEIGHT = 48;


const GroupActionButtons = ({handleOpen,handleOpenEdit}) => {
    const [anchorEl, setAnchorEl] = React.useState(null);
    const open = Boolean(anchorEl);


    const handleClick = (event) => {
        setAnchorEl(event.currentTarget);
    };

    const handleClose = () => {
        setAnchorEl(null);
    };

    const handleOpenModal = () => {
        handleOpen();
        setAnchorEl(null);
    }

    const handleOpenEditModal = () => {
        handleOpenEdit();
        setAnchorEl(null);
    }

    return (
        <div>
            <IconButton
                aria-label="more"
                aria-controls="long-menu"
                aria-haspopup="true"
                onClick={handleClick}>
                <MoreVertIcon />
            </IconButton>
            <Menu
                id="long-menu"
                anchorEl={anchorEl}
                keepMounted
                open={open}
                onClose={handleClose}
                PaperProps={{
                    style: {
                        maxHeight: ITEM_HEIGHT * 4.5,
                        width: '12ch',
                    },
                }}>
                <MenuItem  onClick={handleOpenEditModal} >
                    Edit
                </MenuItem>

                <MenuItem  onClick={ handleOpenModal } >
                    Delete
                </MenuItem>
            </Menu>
        </div>
    );
}

export default GroupActionButtons;
