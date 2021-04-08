import React, {useContext, useState, Fragment} from 'react';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import ListItemSecondaryAction from '@material-ui/core/ListItemSecondaryAction';
import IconButton from '@material-ui/core/IconButton';
import {SectionContext} from "./SectionContext";
import SectionActionButtons from "./SectionActionButtons";
import SectionEditModal from "./SectionEditModal";
import SectionDeleteModal from "./SectionDeleteModal";
import GroupDeleteModal from "../Groups/GroupDeleteModal";
import {QuestionContext} from "../questions/QuestionContext";


const ListSections = () =>{
    const [sections,,loadingSections] = useContext(SectionContext);
    const [selectedSection,setSelectedSection] = useState();
    const [openDeleteModal,setOpenDeleteModal] = useState(false);
    const [openEditModal,setOpenEditModal] = useState(false);
    const [id,setId] = useState();
    const [section,setSection] = useState();
    const [questions,setQuestions,loadingQuestions,sectionId,setSectionId] = useContext(QuestionContext);



    const handleOpenDeleteModal = (id) => {
        setId(id);
        setOpenDeleteModal(true);
    }

    const handleCloseDeleteModal = () => {
        setOpenDeleteModal(false);
    }

    const handleOpenEditModal = (section) => {
        setOpenEditModal(true);
        setSection(section);
    }
    const handleCloseEditModal = () =>{
        setOpenEditModal(false);
    }

    const handleSelectedSection = (section,index) => {
        setSectionId(section.id);
        setSelectedSection(index);
    }



    return (
        <Fragment>
            <SectionEditModal open={openEditModal} fillData={section} handleClose={handleCloseEditModal} />
            <SectionDeleteModal section_id={id} open={openDeleteModal} handleClose={handleCloseDeleteModal}/>
            <List>
                {
                    (sections.length > 0) ?
                 sections && sections.map( (section,index) =>
                    <ListItem className="pt-2 pb-2 shadow-sm" button key={index} selected={index === selectedSection}  onClick={ () => handleSelectedSection(section,index) } >
                        <ListItemText primary={section.name} />
                        <ListItemSecondaryAction>
                            <SectionActionButtons handleOpen={ () => handleOpenDeleteModal(section.id)} handleOpenEdit={ () => handleOpenEditModal(section)}/>
                        </ListItemSecondaryAction>
                    </ListItem>):

                        <div className="">
                            <h1 className=""> No Data found </h1>
                        </div>
                }
            </List>
        </Fragment>
    );

};

export default ListSections;
